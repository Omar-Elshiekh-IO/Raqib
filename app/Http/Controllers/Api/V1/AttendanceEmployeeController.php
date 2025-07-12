<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Models\AttendanceEmployee;
use App\Models\IpRestrict;
use App\Models\Utility;
use App\Models\WorkShiftDays;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceEmployeeController extends Controller
{
  public function checkIn(Request $request)
  {
    $request->validate([
      'latitude' => 'required|numeric',
      'longitude' => 'required|numeric'
    ]);

    $employee = Auth::user()->employee()->with(['branch', 'workShifts.workShiftDays'])->first();

    if (!$employee) {
      return response()->json([
        'status' => false,
        'message' => 'Employee not found.'
      ], 404);
    }

    $branch = $employee->branch;

    if (!$branch) {
      return response()->json([
        'status' => false,
        'message' => 'Branch not found.'
      ], 404);
    }

    $latitude = $request->input('latitude');
    $longitude = $request->input('longitude');
    $loginDistance = Helpers::haversineDistance($latitude, $longitude, $branch->latitude, $branch->longitude);

    $branchData = [
      'latitude' => $branch->latitude,
      'longitude' => $branch->longitude,
      'login_range' => $branch->login_range,
    ];

    $settings = Utility::settings();
    if ($settings['ip_restrict'] == 'on') {
      $userIp = request()->ip();
      $ip = IpRestrict::where('created_by', Auth::user()->creatorId())
        ->whereIn('ip', [$userIp])->first();
      if (empty($ip)) {
        return response()->json([
          'status' => false,
          'message' => 'This IP is not allowed to clock in.',
          'branch' => $branchData,
        ], 403);
      }
    }

    if ($loginDistance > $branch->login_range) {
      return response()->json([
        'status' => false,
        'message' => 'You are not within the allowed location to check in.',
        'branch' => $branchData,
      ], 403);
    }

    $employeeId = $employee->id ?? 0;

    $workShifts = $employee->workShifts;
    if (!$workShifts || $workShifts->isEmpty()) {
      return response()->json([
        'status' => false,
        'message' => 'No work shift assigned.',
        'branch' => $branchData,
      ], 403);
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
        if (in_array($today, $shiftDays) && $now >= $shiftStart) {
          $currentShift = $workShift;
          break;
        }

        // Scenario 2: Current time is before shift end (day after shift start)
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
      return response()->json([
        'status' => false,
        'message' => 'You can only clock in during your scheduled work shift time and day.',
        'branch' => $branchData,
      ], 403);
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
      return response()->json([
        'status' => false,
        'message' => 'You are already clocked in. Please clock out before clocking in again.',
        'branch' => $branchData,
      ], 409);
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
    $employeeAttendance->created_by = Auth::user()->id;

    $employeeAttendance->save();

    return response()->json([
      'status' => true,
      'message' => 'Employee Successfully Clocked In.',
      'branch' => $branchData,
    ], 201);
  }

  public function checkOut(Request $request)
  {
    $request->validate([
      'latitude' => 'required|numeric',
      'longitude' => 'required|numeric',
    ]);

    $employee = Auth::user()->employee()->with(['branch', 'workShifts.workShiftDays'])->first();

    if (!$employee) {
      return response()->json([
        'status' => false,
        'message' => 'Employee not found.'
      ], 404);
    }

    $branch = $employee->branch;

    if (!$branch) {
      return response()->json([
        'status' => false,
        'message' => 'Branch not found.'
      ], 404);
    }

    $latitude = $request->input('latitude');
    $longitude = $request->input('longitude');
    $loginDistance = Helpers::haversineDistance($latitude, $longitude, $branch->latitude, $branch->longitude);

    $branchData = [
      'latitude' => $branch->latitude,
      'longitude' => $branch->longitude,
      'login_range' => $branch->login_range,
    ];

    if ($loginDistance > $branch->login_range) {
      return response()->json([
        'status' => false,
        'message' => 'You are not within the allowed location to check out.',
        'branch' => $branchData,
      ], 403);
    }

    $settings = Utility::settings();
    if ($settings['ip_restrict'] == 'on') {
      $userIp = request()->ip();
      $ip = IpRestrict::where('created_by', Auth::user()->creatorId())
        ->whereIn('ip', [$userIp])->first();
      if (empty($ip)) {
        return response()->json([
          'status' => false,
          'message' => 'This IP is not allowed to clock out.',
          'branch' => $branchData,
        ], 403);
      }
    }

    $employeeId = $employee->id ?? 0;
    $workShifts = $employee->workShifts;
    if (!$workShifts || $workShifts->isEmpty()) {
      return response()->json([
        'status' => false,
        'message' => 'No work shift assigned.',
        'branch' => $branchData,
      ], 403);
    }

    $today = date('l');
    $yesterday = date('l', strtotime('-1 day'));
    $now = date('H:i:s');
    $currentShift = null;

    // Find the current work shift for today (same as check-in)
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
      return response()->json([
        'status' => false,
        'message' => 'You can only clock out during your scheduled work shift time and day.',
        'branch' => $branchData,
      ], 403);
    }

    $date = date("Y-m-d");
    $time = date("H:i:s");

    $attendance = AttendanceEmployee::where('employee_id', $employeeId)
      ->where('date', $date)
      ->where('clock_out', '00:00:00')
      ->orderBy('id', 'desc')
      ->first();

    if (!$attendance) {
      return response()->json([
        'status' => false,
        'message' => 'No open attendance record found. Please clock in first.',
        'branch' => $branchData,
      ], 409);
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

    return response()->json([
      'status' => true,
      'message' => 'Employee successfully clocked out.',
      'branch' => $branchData,
    ], 200);
  }
}
