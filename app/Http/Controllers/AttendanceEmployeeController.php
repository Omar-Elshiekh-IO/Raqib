<?php

namespace App\Http\Controllers;

use App\Helpers\Helpers;
use App\Imports\AttendanceImport;
use App\Models\AttendanceEmployee;
use App\Models\Branch;
use App\Models\Department;
use App\Models\Employee;
use App\Models\IpRestrict;
use App\Models\User;
use App\Models\Utility;
use App\Models\WorkShiftDays;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AttendanceEmployeeController extends Controller
{
  public function index(Request $request)
  {
    if (\Auth::user()->can('manage attendance')) {

      $branch = Branch::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
      $branch->prepend('Select Branch', '');

      $department = Department::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
      $department->prepend('Select Department', '');

      if (\Auth::user()->type != 'client' && \Auth::user()->type != 'company') {

        $emp = !empty(\Auth::user()->employee) ? \Auth::user()->employee->id : 0;

        $attendanceEmployee = AttendanceEmployee::where('employee_id', $emp);

        if ($request->type == 'monthly' && !empty($request->month)) {
          $month = date('m', strtotime($request->month));
          $year = date('Y', strtotime($request->month));

          $start_date = date($year . '-' . $month . '-01');
          $end_date = date($year . '-' . $month . '-t');

          $attendanceEmployee->whereBetween(
            'date',
            [
              $start_date,
              $end_date,
            ]
          );
        } elseif ($request->type == 'daily' && !empty($request->date)) {
          $attendanceEmployee->where('date', $request->date);
        } else {
          $month = date('m');
          $year = date('Y');
          $start_date = date($year . '-' . $month . '-01');
          $end_date = date($year . '-' . $month . '-t');

          $attendanceEmployee->whereBetween(
            'date',
            [
              $start_date,
              $end_date,
            ]
          );
        }
        $attendanceEmployee = $attendanceEmployee->get();
      } else {

        $employee = Employee::select('id')->where('created_by', \Auth::user()->creatorId());
        if (!empty($request->branch)) {
          $employee->where('branch_id', $request->branch);
        }

        if (!empty($request->department)) {
          $employee->where('department_id', $request->department);
        }

        $employee = $employee->get()->pluck('id');

        $attendanceEmployee = AttendanceEmployee::whereIn('employee_id', $employee);
        if ($request->type == 'monthly' && !empty($request->month)) {

          $month = date('m', strtotime($request->month));
          $year = date('Y', strtotime($request->month));
          $start_date = date($year . '-' . $month . '-01');
          $end_date = date('Y-m-t', strtotime('01-' . $month . '-' . $year));


          $attendanceEmployee->whereBetween(
            'date',
            [
              $start_date,
              $end_date,
            ]
          );
        } elseif ($request->type == 'daily' && !empty($request->date)) {
          $attendanceEmployee->where('date', $request->date);
        } else {

          $month = date('m');
          $year = date('Y');
          $start_date = date($year . '-' . $month . '-01');
          $end_date = date('Y-m-t', strtotime('01-' . $month . '-' . $year));


          $attendanceEmployee->whereBetween(
            'date',
            [
              $start_date,
              $end_date,
            ]
          );
        }

        $attendanceEmployee = $attendanceEmployee->get();
      }

      return view('attendance.index', compact('attendanceEmployee', 'branch', 'department'));
    } else {
      return redirect()->back()->with('error', __('Permission denied.'));
    }
  }

  public function create()
  {
    if (\Auth::user()->can('create attendance')) {
      $employees = User::where('created_by', '=', \Auth::user()->creatorId())->where('type', '=', "employee")->get()->pluck('name', 'id');

      return view('attendance.create', compact('employees'));
    } else {
      return redirect()->back()->with('error', __('Permission denied.'));
    }
  }

  public function store(Request $request)
  {
    if (\Auth::user()->can('create attendance')) {
      $validator = \Validator::make(
        $request->all(),
        [
          'employee_id' => 'required',
          'date' => 'required',
          'clock_in' => 'required',
          'clock_out' => 'required',
        ]
      );
      if ($validator->fails()) {
        $messages = $validator->getMessageBag();

        return redirect()->back()->with('error', $messages->first());
      }

      $startTime = Utility::getValByName('company_start_time');
      $endTime = Utility::getValByName('company_end_time');
      $attendance = AttendanceEmployee::where('employee_id', '=', $request->employee_id)->where('date', '=', $request->date)->where('clock_out', '=', '00:00:00')->get()->toArray();
      if ($attendance) {
        return redirect()->route('attendanceemployee.index')->with('error', __('Employee Attendance Already Created.'));
      } else {
        $date = date("Y-m-d");

        $totalLateSeconds = strtotime($request->clock_in) - strtotime($date . $startTime);

        $hours = floor($totalLateSeconds / 3600);
        $mins = floor($totalLateSeconds / 60 % 60);
        $secs = floor($totalLateSeconds % 60);

        $late = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);

        //early Leaving
        $totalEarlyLeavingSeconds = strtotime($date . $endTime) - strtotime($request->clock_out);
        $hours = floor($totalEarlyLeavingSeconds / 3600);
        $mins = floor($totalEarlyLeavingSeconds / 60 % 60);
        $secs = floor($totalEarlyLeavingSeconds % 60);
        $earlyLeaving = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);

        if (strtotime($request->clock_out) > strtotime($date . $endTime)) {
          //Overtime
          $totalOvertimeSeconds = strtotime($request->clock_out) - strtotime($date . $endTime);
          $hours = floor($totalOvertimeSeconds / 3600);
          $mins = floor($totalOvertimeSeconds / 60 % 60);
          $secs = floor($totalOvertimeSeconds % 60);
          $overtime = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);
        } else {
          $overtime = '00:00:00';
        }

        $employeeAttendance = new AttendanceEmployee();
        $employeeAttendance->employee_id = $request->employee_id;
        $employeeAttendance->date = $request->date;
        $employeeAttendance->status = 'Present';
        $employeeAttendance->clock_in = $request->clock_in . ':00';
        $employeeAttendance->clock_out = $request->clock_out . ':00';
        $employeeAttendance->late = $late;
        $employeeAttendance->early_leaving = $earlyLeaving;
        $employeeAttendance->overtime = $overtime;
        $employeeAttendance->total_rest = '00:00:00';
        $employeeAttendance->created_by = \Auth::user()->creatorId();
        $employeeAttendance->save();

        return redirect()->route('attendanceemployee.index')->with('success', __('Employee attendance successfully created.'));
      }
    } else {
      return redirect()->back()->with('error', __('Permission denied.'));
    }
  }

  public function show()
  {
    return redirect()->route('attendanceemployee.index');
  }

  public function edit($id)
  {
    if (\Auth::user()->can('edit attendance')) {
      $attendanceEmployee = AttendanceEmployee::where('id', $id)->first();
      $employees = Employee::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');

      return view('attendance.edit', compact('attendanceEmployee', 'employees'));
    } else {
      return redirect()->back()->with('error', __('Permission denied.'));
    }
  }

  public function update(Request $request, $id)
  {
    $employee = \Auth::user()->employee;
    if ($employee) {
      $employee->load(['branch', 'workShifts.workShiftDays']);
    }

    if (!$employee) {
      return redirect()->back()->with('error', __('Employee not found.'));
    }

    $branch = $employee->branch;
    if (!$branch) {
      return redirect()->back()->with('error', __('Branch not found.'));
    }

    $employeeId = $employee->id ?? 0;
    $workShifts = $employee->workShifts;
    if (!$workShifts || $workShifts->isEmpty()) {
      return redirect()->back()->with('error', __('No work shift assigned.'));
    }

    $today = date('l');
    $yesterday = date('l', strtotime('-1 day'));
    $now = date('H:i:s');
    $currentShift = null;

    // Find the current work shift for today
    foreach ($workShifts as $workShift) {
      $shiftDays = [];
      foreach ($workShift->workShiftDays as $shiftDay) {
        $shiftDays[] = WorkShiftDays::getDayName($shiftDay->day);
      }
      $shiftStart = $workShift->from;
      $shiftEnd = $workShift->to;
      $isCrossMidnightShift = $shiftEnd < $shiftStart;
      if ($isCrossMidnightShift) {
        if (in_array($today, $shiftDays) && $now >= $shiftStart) {
          $currentShift = $workShift;
          break;
        }
        if (in_array($yesterday, $shiftDays) && $now <= $shiftEnd) {
          $currentShift = $workShift;
          break;
        }
      } else {
        if (in_array($today, $shiftDays) && $now >= $shiftStart) {
          $currentShift = $workShift;
          break;
        }
      }
    }

    if (!$currentShift) {
      return redirect()->back()->with('error', __('You can only clock out during your scheduled work shift time and day.'));
    }

    $date = date("Y-m-d");
    $time = date("H:i:s");

    // Find the last open attendance record for today
    $attendance = AttendanceEmployee::where('employee_id', $employeeId)
      ->where('date', $date)
      ->where('clock_out', '00:00:00')
      ->orderBy('id', 'desc')
      ->first();

    if (!$attendance) {
      return redirect()->back()->with('error', __('No open attendance record found. Please clock in first.'));
    }

    // Calculate early leaving and overtime
    $shiftEndTime = $date . ' ' . $currentShift->to;
    $clockOutTime = $date . ' ' . $time;

    // Early leaving
    $totalEarlyLeavingSeconds = strtotime($shiftEndTime) - strtotime($clockOutTime);
    $earlyLeaving = $totalEarlyLeavingSeconds > 0
      ? sprintf('%02d:%02d:%02d', floor($totalEarlyLeavingSeconds / 3600), floor($totalEarlyLeavingSeconds / 60 % 60), floor($totalEarlyLeavingSeconds % 60))
      : '00:00:00';

    // Overtime
    $overtime = '00:00:00';
    if (strtotime($clockOutTime) > strtotime($shiftEndTime)) {
      $totalOvertimeSeconds = strtotime($clockOutTime) - strtotime($shiftEndTime);
      $overtime = sprintf('%02d:%02d:%02d', floor($totalOvertimeSeconds / 3600), floor($totalOvertimeSeconds / 60 % 60), floor($totalOvertimeSeconds % 60));
    }

    // Update attendance record
    $attendance->clock_out = $time;
    $attendance->early_leaving = $earlyLeaving;
    $attendance->overtime = $overtime;
    $attendance->save();

    return redirect()->back()->with('success', __('Employee attendance successfully updated.'));
  }

  public function destroy($id)
  {
    if (\Auth::user()->can('delete attendance')) {
      $attendance = AttendanceEmployee::where('id', $id)->first();

      $attendance->delete();

      return redirect()->route('attendanceemployee.index')->with('success', __('Attendance successfully deleted.'));
    } else {
      return redirect()->back()->with('error', __('Permission denied.'));
    }
  }

  public function attendance(Request $request)
  {

    $request->validate([
      'latitude' => 'required|numeric',
      'longitude' => 'required|numeric',
    ]);

    $latitude = $request->input('latitude');
    $longitude = $request->input('longitude');

    $settings = Utility::settings();

    if ($settings['ip_restrict'] == 'on') {
      $userIp = request()->ip();
      $ip = IpRestrict::where('created_by', \Auth::user()->creatorId())->whereIn('ip', [$userIp])->first();
      if (empty($ip)) {
        return redirect()->back()->with('error', __('This ip is not allowed to clock in & clock out.'));
      }
    }

    $employee = Auth::user()->employee()->with(['branch', 'workShifts.workShiftDays'])->first();

    if (!$employee) {
      return redirect()->back()->with('error', __('Employee not found.'));
    }

    $branch = $employee->branch;

    $loginDistance = Helpers::haversineDistance($latitude, $longitude, $branch->latitude, $branch->longitude);
    if ($loginDistance > $branch->login_range) {
      return redirect()->back()->with('error', __('You are not within the allowed location to check in.'));
    }

    $employeeId = $employee->id ?? 0;

    $workShifts = $employee->workShifts;
    if (!$workShifts || $workShifts->isEmpty()) {
      return redirect()->back()->with('error', __('No work shift assigned.'));
    }

    $today = date('l');
    $yesterday = date('l', strtotime('-1 day'));
    $now = date('H:i:s');
    $currentShift = null;

    // Find the current work shift for today
    foreach ($workShifts as $workShift) {
      $shiftDays = [];
      foreach ($workShift->workShiftDays as $shiftDay) {
        $shiftDays[] = WorkShiftDays::getDayName($shiftDay->day);
      }

      $shiftStart = $workShift->from;
      $shiftEnd = $workShift->to;

      // Check if this is a cross-midnight shift (end time is less than start time)
      $isCrossMidnightShift = $shiftEnd < $shiftStart;

      if ($isCrossMidnightShift) {
        // For cross-midnight shifts, we need to check two scenarios:

        // Scenario 1: Current time is after shift start (same day as shift start)
        // Example: Shift 22:00-06:00, current time is 23:00 on Monday
        if (in_array($today, $shiftDays) && $now >= $shiftStart) {
          $currentShift = $workShift;
          break;
        }

        // Scenario 2: Current time is before shift end (day after shift start)
        // Example: Shift 22:00-06:00, current time is 03:00 on Tuesday (shift started Monday)
        if (in_array($yesterday, $shiftDays) && $now <= $shiftEnd) {
          $currentShift = $workShift;
          break;
        }
      } else {
        // Normal shift within the same day
        if (in_array($today, $shiftDays) && $now >= $shiftStart && $now <= $shiftEnd) {
          $currentShift = $workShift;
          break;
        }
      }
    }

    if (!$currentShift) {
      return redirect()->back()->with('error', __('You can only clock in during your scheduled work shift time and day.'));
    }

    $date = date("Y-m-d");
    $time = date("H:i:s");

    // Find ALL attendance records for today
    $todayAttendances = AttendanceEmployee::where('employee_id', $employeeId)
      ->where('date', $date)
      ->orderBy('id', 'asc')
      ->get();

    $lastAttendance = $todayAttendances->last();

    if ($lastAttendance && $lastAttendance->clock_out == '00:00:00') {
      return redirect()->back()->with('error', __('You are already clocked in. Please clock out before clocking in again.'));
    }

    $isFirstCheckIn = $todayAttendances->isEmpty();

    $late = '00:00:00';
    if ($isFirstCheckIn) {
      $expectedStartTime = $date . ' ' . $currentShift->from;
      $actualClockInTime = $date . ' ' . $time;

      $totalLateSeconds = strtotime($actualClockInTime) - strtotime($expectedStartTime);
      $totalLateSeconds = max($totalLateSeconds, 0);

      $hours = floor($totalLateSeconds / 3600);
      $mins = floor($totalLateSeconds / 60 % 60);
      $secs = floor($totalLateSeconds % 60);
      $late = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);
    }

    $employeeAttendance = new AttendanceEmployee();
    $employeeAttendance->employee_id = $employeeId;
    $employeeAttendance->date = $date;
    $employeeAttendance->status = 'Present';
    $employeeAttendance->clock_in = $time;
    $employeeAttendance->clock_out = '00:00:00';
    $employeeAttendance->late = $late;
    $employeeAttendance->early_leaving = '00:00:00';
    $employeeAttendance->overtime = '00:00:00';
    $employeeAttendance->total_rest = '00:00:00';
    $employeeAttendance->created_by = \Auth::user()->id;

    $employeeAttendance->save();

    $workDays = DB::selectOne('SELECT work_days FROM roles WHERE name = ? AND created_by = ?',[Auth::user()->type,Auth::user()->creatorId()]);
    $dailyEarning = $employee->salary / $workDays;
    $employee->increment('earned_salary',$dailyEarning);

    return redirect()->back()->with('success', __('Employee Successfully Clock In.'));
  }

  public function bulkAttendance(Request $request)
  {
    if (\Auth::user()->can('create attendance')) {

      $branch = Branch::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
      $branch->prepend('Select Branch', '');

      $department = Department::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
      $department->prepend('Select Department', '');

      $employees = [];
      if (!empty($request->branch) && !empty($request->department)) {
        $employees = Employee::where('created_by', \Auth::user()->creatorId())->where('branch_id', $request->branch)->where('department_id', $request->department)->get();
      } else {
        $employees = Employee::where('created_by', \Auth::user()->creatorId())->where('branch_id', 1)->where('department_id', 1)->get();
      }

      return view('attendance.bulk', compact('employees', 'branch', 'department'));
    } else {
      return redirect()->back()->with('error', __('Permission denied.'));
    }
  }

  public function bulkAttendanceData(Request $request)
  {

    if (\Auth::user()->can('create attendance')) {
      if (!empty($request->branch) && !empty($request->department)) {
        $startTime = Utility::getValByName('company_start_time');
        $endTime = Utility::getValByName('company_end_time');
        $date = $request->date;

        $employees = $request->employee_id;
        $atte = [];

        if (!empty($employees)) {
          foreach ($employees as $employee) {
            $present = 'present-' . $employee;
            $in = 'in-' . $employee;
            $out = 'out-' . $employee;
            $atte[] = $present;
            if ($request->$present == 'on') {

              $in = date("H:i:s", strtotime($request->$in));
              $out = date("H:i:s", strtotime($request->$out));

              $totalLateSeconds = strtotime($in) - strtotime($startTime);

              $hours = floor($totalLateSeconds / 3600);
              $mins = floor($totalLateSeconds / 60 % 60);
              $secs = floor($totalLateSeconds % 60);
              $late = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);

              //early Leaving
              $totalEarlyLeavingSeconds = strtotime($endTime) - strtotime($out);
              $hours = floor($totalEarlyLeavingSeconds / 3600);
              $mins = floor($totalEarlyLeavingSeconds / 60 % 60);
              $secs = floor($totalEarlyLeavingSeconds % 60);
              $earlyLeaving = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);

              if (strtotime($out) > strtotime($endTime)) {
                //Overtime
                $totalOvertimeSeconds = strtotime($out) - strtotime($endTime);
                $hours = floor($totalOvertimeSeconds / 3600);
                $mins = floor($totalOvertimeSeconds / 60 % 60);
                $secs = floor($totalOvertimeSeconds % 60);
                $overtime = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);
              } else {
                $overtime = '00:00:00';
              }
              $attendance = AttendanceEmployee::where('employee_id', '=', $employee)->where('date', '=', $request->date)->first();

              if (!empty($attendance)) {
                $employeeAttendance = $attendance;
              } else {
                $employeeAttendance = new AttendanceEmployee();
                $employeeAttendance->employee_id = $employee;
                $employeeAttendance->created_by = \Auth::user()->creatorId();
              }
              $employeeAttendance->date = $request->date;
              $employeeAttendance->status = 'Present';
              $employeeAttendance->clock_in = $in;
              $employeeAttendance->clock_out = $out;
              $employeeAttendance->late = $late;
              $employeeAttendance->early_leaving = ($earlyLeaving > 0) ? $earlyLeaving : '00:00:00';
              $employeeAttendance->overtime = $overtime;
              $employeeAttendance->total_rest = '00:00:00';
              $employeeAttendance->save();
            } else {
              $attendance = AttendanceEmployee::where('employee_id', '=', $employee)->where('date', '=', $request->date)->first();

              if (!empty($attendance)) {
                $employeeAttendance = $attendance;
              } else {
                $employeeAttendance = new AttendanceEmployee();
                $employeeAttendance->employee_id = $employee;
                $employeeAttendance->created_by = \Auth::user()->creatorId();
              }

              $employeeAttendance->status = 'Leave';
              $employeeAttendance->date = $request->date;
              $employeeAttendance->clock_in = '00:00:00';
              $employeeAttendance->clock_out = '00:00:00';
              $employeeAttendance->late = '00:00:00';
              $employeeAttendance->early_leaving = '00:00:00';
              $employeeAttendance->overtime = '00:00:00';
              $employeeAttendance->total_rest = '00:00:00';
              $employeeAttendance->save();
            }
          }
        } else {
          return redirect()->back()->with('error', __('Employee not found.'));
        }

        return redirect()->back()->with('success', __('Employee attendance successfully created.'));
      } else {
        return redirect()->back()->with('error', __('Branch & department field required.'));
      }
    } else {
      return redirect()->back()->with('error', __('Permission denied.'));
    }
  }

  //for attendance employee report

  public function importFile()
  {
    return view('attendance.import');
  }

  public function attendanceImportdata(Request $request)
  {
    session_start();
    $html = '<h3 class="text-danger text-center">Below data is not inserted</h3></br>';
    $flag = 0;
    $html .= '<table class="table table-bordered"><tr>';
    try {
      $request = $request->data;
      $file_data = $_SESSION['file_data'];

      unset($_SESSION['file_data']);
    } catch (\Throwable $th) {
      $html = '<h3 class="text-danger text-center">Something went wrong, Please try again</h3></br>';
      return response()->json([
        'html' => true,
        'response' => $html,
      ]);
    }
    $user = \Auth::user();

    $startTime = Utility::getValByName('company_start_time');
    $endTime = Utility::getValByName('company_end_time');

    foreach ($file_data as $key => $row) {
      $employeeData = Employee::Where('email', 'like', $row[$request['employee_email']])->where('created_by', \Auth::user()->creatorId())->first();

      if (!empty($employeeData)) {
        try {

          $employeeId = $employeeData->id;

          $clockIn = $row[$request['clock_in']];
          $clockOut = $row[$request['clock_out']];

          if ($clockIn) {
            $status = "present";
          } else {
            $status = "leave";
          }

          $totalLateSeconds = strtotime($clockIn) - strtotime($startTime);

          $hours = floor($totalLateSeconds / 3600);
          $mins = floor($totalLateSeconds / 60 % 60);
          $secs = floor($totalLateSeconds % 60);
          $late = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);

          $totalEarlyLeavingSeconds = strtotime($endTime) - strtotime($clockOut);
          $hours = floor($totalEarlyLeavingSeconds / 3600);
          $mins = floor($totalEarlyLeavingSeconds / 60 % 60);
          $secs = floor($totalEarlyLeavingSeconds % 60);
          $earlyLeaving = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);

          if (strtotime($clockOut) > strtotime($endTime)) {
            //Overtime
            $totalOvertimeSeconds = strtotime($clockOut) - strtotime($endTime);
            $hours = floor($totalOvertimeSeconds / 3600);
            $mins = floor($totalOvertimeSeconds / 60 % 60);
            $secs = floor($totalOvertimeSeconds % 60);
            $overtime = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);
          } else {
            $overtime = '00:00:00';
          }

          $check = AttendanceEmployee::where('employee_id', $employeeId)->where('date', $row[$request['date']])->first();
          if ($check) {
            $check->update([
              'late' => $late,
              'early_leaving' => ($earlyLeaving > 0) ? $earlyLeaving : '00:00:00',
              'overtime' => $overtime,
              'clock_in' => $row[$request['clock_in']],
              'clock_out' => $row[$request['clock_out']],
            ]);
          } else {
            $time_sheet = AttendanceEmployee::create([
              'employee_id' => $employeeId,
              'date' => $row[$request['date']],
              'status' => $status,
              'late' => $late,
              'early_leaving' => ($earlyLeaving > 0) ? $earlyLeaving : '00:00:00',
              'overtime' => $overtime,
              'clock_in' => $row[$request['clock_in']],
              'clock_out' => $row[$request['clock_out']],
              'created_by' => \Auth::user()->id,
            ]);
          }
        } catch (\Exception $e) {
          $flag = 1;
          $html .= '<tr>';

          $html .= '<td>' . (isset($row[$request['employee_email']]) ? $row[$request['employee_email']] : '-') . '</td>';
          $html .= '<td>' . (isset($row[$request['date']]) ? $row[$request['date']] : '-') . '</td>';
          $html .= '<td>' . (isset($row[$request['clock_in']]) ? $row[$request['clock_in']] : '-') . '</td>';
          $html .= '<td>' . (isset($row[$request['clock_out']]) ? $row[$request['clock_out']] : '-') . '</td>';

          $html .= '</tr>';
        }
      } else {
        $flag = 1;
        $html .= '<tr>';

        $html .= '<td>' . (isset($row[$request['employee_email']]) ? $row[$request['employee_email']] : '-') . '</td>';
        $html .= '<td>' . (isset($row[$request['date']]) ? $row[$request['date']] : '-') . '</td>';
        $html .= '<td>' . (isset($row[$request['clock_in']]) ? $row[$request['clock_in']] : '-') . '</td>';
        $html .= '<td>' . (isset($row[$request['clock_out']]) ? $row[$request['clock_out']] : '-') . '</td>';

        $html .= '</tr>';
      }
    }

    $html .= '
                        </table>
                        <br />
                        ';
    if ($flag == 1) {

      return response()->json([
        'html' => true,
        'response' => $html,
      ]);
    } else {
      return response()->json([
        'html' => false,
        'response' => 'Data Imported Successfully',
      ]);
    }
  }
}
