<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;
use App\Models\AttendanceEmployee;

class DashboardController extends Controller
{

  public function index()
  {

    if (Auth::user()->can('show hrm dashboard')) {

      $employee = Employee::where('user_id', Auth::id())
        ->with(['workShifts'])
        ->first();

      $announcements = Announcement::orderBy('announcements.id', 'desc')
        ->take(5)
        ->leftJoin('announcement_employees', 'announcements.id', '=', 'announcement_employees.announcement_id')
        ->where('announcement_employees.employee_id', '=', $employee->id)
        ->orWhere(function ($q) use ($employee) {
          $q->where('announcements.department_id', '["0"]')
            ->where('announcements.employee_id', '["0"]')
            ->where('announcement_employees.employee_id', $employee->id);
        })
        ->get(['announcements.*']);

      $date = date('Y-m-d');
      $employeeAttendance = AttendanceEmployee::orderBy('id', 'desc')
        ->where('employee_id', $employee->id)
        ->where('date', $date)
        ->first();

      $allowances = $employee->allowances()->get()->map(function ($item) {
        return [
          'type' => 'allowance',
          'title' => $item->title,
          'amount' => +$item->amount,
          'date' => $item->created_at,
        ];
      });

      $commissions = $employee->commissions()->get()->map(function ($item) {
        return [
          'type' => 'commission',
          'title' => $item->title,
          'amount' => +$item->amount,
          'date' => $item->created_at,
        ];
      });

      $overtimes = $employee->overtimes()->get()->map(function ($item) {
        $total = $item->number_of_days * $item->hours * $item->rate;
        return [
          'type' => 'overtime',
          'title' => $item->title,
          'amount' => +$total,
          'date' => $item->created_at,
        ];
      });

      $addtions = [
        'allowances' => $allowances,
        'commissions' => $commissions,
        'overtimes' => $overtimes,
      ];

      $loanDeductions = $employee->loans()->where('with_deduction', 1)->get()->map(function ($item) {
        return [
          'type' => 'loan_deduction',
          'title' => $item->title,
          'amount' => -abs($item->deduction_amount),
          'date' => $item->start_deduction_date ?? $item->created_at,
        ];
      });

      $excuseDeductions = $employee->excuses()->where('with_deduction', 1)->get()->map(function ($item) {
        return [
          'type' => 'excuse_deduction',
          'title' => $item->reason,
          'amount' => -abs($item->deduction_amount),
          'date' => $item->excuse_date ?? $item->created_at,
        ];
      });

      $leaveDeductions = $employee->leave()->where('with_deduction', 1)->get()->map(function ($item) {
        return [
          'type' => 'leave_deduction',
          'title' => $item->leave_reason,
          'amount' => -abs($item->deduction_amount),
          'date' => $item->start_deduction_date ?? $item->start_date ?? $item->created_at,
        ];
      });

      $deductions = [
        'loan_deductions' => $loanDeductions,
        'excuse_deductions' => $excuseDeductions,
        'leave_deductions' => $leaveDeductions,
      ];

      return response()->json([
        'employee' => $employee,
        'addtions' => $addtions,
        'deductions' => $deductions,
        'announcements' => $announcements,
        'attendance_today' => $employeeAttendance,
      ]);
    }
    return response()->json(['error' => 'Unauthorized'], 403);
  }
}
