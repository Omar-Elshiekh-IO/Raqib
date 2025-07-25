<?php

namespace App\Models;

use App\Helpers\FormulaValidator;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use NXP\Exception\DivisionByZeroException;
use NXP\MathExecutor;
use Spatie\Permission\Models\Role;

class Employee extends Model
{
  protected $fillable = [
    'user_id',
    'name',
    'dob',
    'gender',
    'phone',
    'address',
    'email',
    'password',
    'employee_id',
    'branch_id',
    'department_id',
    'designation_id',
    'company_doj',
    'documents',
    'account_holder_name',
    'account_number',
    'bank_name',
    'bank_identifier_code',
    'branch_location',
    'tax_payer_id',
    'salary_type',
    'biometric_emp_id',
    'account',
    'salary',
    'created_by',
    'employment_type_id',
    'manager_id',
    'has_insurance',
    'insurance_amount',
  ];

  public function documents()
  {
    return $this->hasMany('App\Models\EmployeeDocument', 'employee_id', 'employee_id')->get();
  }

  public function salary_type()
  {
    return $this->hasOne('App\Models\PayslipType', 'id', 'salary_type')->pluck('name')->first();
  }

  public function allowances()
  {
    return $this->hasMany(Allowance::class);
  }

  public function commissions()
  {
    return $this->hasMany(Commission::class);
  }

  public function loans()
  {
    return $this->hasMany(Loan::class);
  }
  public function leave()
  {
    return $this->hasMany(Leave::class);
  }

  public function saturationDeductions()
  {
    return $this->hasMany(SaturationDeduction::class);
  }

  public function otherPayments()
  {
    return $this->hasMany(OtherPayment::class);
  }

  public function overtimes()
  {
    return $this->hasMany(Overtime::class);
  }

  public function workShifts()
  {
    return $this->belongsToMany(WorkShift::class);
  }
  public function employmentType()
  {
    return $this->belongsTo(EmploymentType::class);
  }
  public function get_net_salary()
  {

    $net_salary = 0;

    $base_salary = $this->salary ?? 0;

    $this->loadMissing(['allowances', 'commissions', 'loans', 'saturationDeductions', 'otherPayments', 'overtimes']);

    $total_allowance = $this->allowances->sum(fn($a) => $a->type === 'fixed' ? $a->amount : ($a->amount * $base_salary / 100));
    $total_commission = $this->commissions->sum(fn($c) => $c->type === 'fixed' ? $c->amount : ($c->amount * $base_salary / 100));
    // $total_loan = $this->loans->sum(fn($l) => $l->type === 'fixed' ? $l->amount : ($l->amount * $base_salary / 100));
    $total_saturation_deduction = $this->saturationDeductions->sum(fn($d) => $d->type === 'fixed' ? $d->amount : ($d->amount * $base_salary / 100));
    $total_other_payment = $this->otherPayments->sum(fn($p) => $p->type === 'fixed' ? $p->amount : ($p->amount * $base_salary / 100));
    $total_over_time = $this->overtimes->sum(fn($o) => $o->number_of_days * $o->hours * $o->rate);
    $total_loan_deduction = $this->loans->where('with_deduction', 1)->where('status', 'Approved')->sum(fn($l) => $l->total_deduction_months == 1 ? $l->deduction_amount : ($l->deduction_amount / $l->total_deduction_months));
    $total_excuse_deduction = $this->excuses->where('with_deduction', 1)->where('status', 'Approved')->sum('deduction_amount');
    $total_leave_deduction = $this->leave->where('with_deduction', 1)->where('status', 'Approved')->sum(fn($l) => $l->total_deduction_months == 1 ? $l->deduction_amount : ($l->deduction_amount / $l->total_deduction_months));

    $lateMinutes = AttendanceEmployee::where('employee_id', $this->id)->sum('late');
    $insuranceAmount = $this->insurance_amount ?? 0;

    $role = $this->user->type;

    $roleData = Role::where('name', $role)->where('created_by', Auth::user()->creatorId())->first();
    $salaryFormula = $roleData->salary_function ?: '0';


    $variables = [
      'base_salary' => $base_salary,
      'allowances' => $total_allowance,
      'commission' => $total_commission,
      'late_minutes' => $lateMinutes,
      'insurance' => $insuranceAmount,
      'overtime' => $total_over_time,
      'excuse_deductions' => $total_excuse_deduction,
      'loan_deductions' => $total_loan_deduction,
      'leave_deductions' => $total_leave_deduction,
      'saturation_deductions' => $total_saturation_deduction,
      'other_payments' => $total_other_payment
    ];

    // Check for potential division by zero variables
      $runtimeValidation = $this->validateRuntimeDivision($salaryFormula, $variables);
    if ($runtimeValidation !== true) {
      // You can either throw an exception or return an error response
      throw new Exception("Salary calculation error: " . $runtimeValidation);
    }

    
    $executor = new MathExecutor();
    try {
      foreach ($variables as $key => $value) {
          $executor->setVar($key, $value);
      }
      $net_salary = $executor->execute($salaryFormula);
    } catch (DivisionByZeroException $dbze) {
      $errorMessage = "Cannot calculate salary: Division by zero detected in formula";
      throw new Exception($errorMessage);
    } catch (Exception $e) {
      $errorMessage = "Salary calculation failed: " . $e->getMessage();
      throw new Exception($errorMessage);
    }

    return $net_salary;
  }

  private function validateRuntimeDivision(string $formula, array $variables): bool|string
  {
    // Find all division operations in the formula
    preg_match_all('/\/\s*([a-zA-Z_][a-zA-Z0-9_]*)/', $formula, $matches);

    if (!empty($matches[1])) {
      foreach ($matches[1] as $variable) {
        if (isset($variables[$variable]) && $variables[$variable] == 0) {
          return "Cannot divide by variable '{$variable}' because its value is 0";
        }
      }
    }

    // Also check for direct numeric divisions that might be zero
    preg_match_all('/\/\s*(\d*\.?\d+)/', $formula, $numMatches);
    if (!empty($numMatches[1])) {
      foreach ($numMatches[1] as $number) {
        if ((float) $number == 0) {
          return "Cannot divide by zero (literal value: {$number})";
        }
      }
    }

    return true;
  }

  public function businessMissions()
  {
    return $this->hasMany(BusinessMission::class);
  }
  public function excuses()
  {
    return $this->hasMany(Excuse::class);
  }

  public static function allowance($id)
  {

    //allowance
    $allowances = Allowance::where('employee_id', '=', $id)->get();
    $total_allowance = 0;
    foreach ($allowances as $allowance) {
      $total_allowance = $allowance->amount + $total_allowance;
    }

    $allowance_json = json_encode($allowances);

    return $allowance_json;
  }

  public static function commission($id)
  {
    //commission
    $commissions = Commission::where('employee_id', '=', $id)->get();
    $total_commission = 0;
    foreach ($commissions as $commission) {
      $total_commission = $commission->amount + $total_commission;
    }
    $commission_json = json_encode($commissions);

    return $commission_json;
  }

  public static function loan($id)
  {
    //Loan
    $loans = Loan::where('employee_id', '=', $id)->get();
    $total_loan = 0;
    foreach ($loans as $loan) {
      $total_loan = $loan->amount + $total_loan;
    }
    $loan_json = json_encode($loans);

    return $loan_json;
  }

  public static function saturation_deduction($id)
  {
    //Saturation Deduction
    $saturation_deductions = SaturationDeduction::where('employee_id', '=', $id)->get();
    $total_saturation_deduction = 0;
    foreach ($saturation_deductions as $saturation_deduction) {
      $total_saturation_deduction = $saturation_deduction->amount + $total_saturation_deduction;
    }
    $saturation_deduction_json = json_encode($saturation_deductions);

    return $saturation_deduction_json;
  }

  public static function other_payment($id)
  {
    //OtherPayment
    $other_payments = OtherPayment::where('employee_id', '=', $id)->get();
    $total_other_payment = 0;
    foreach ($other_payments as $other_payment) {
      $total_other_payment = $other_payment->amount + $total_other_payment;
    }
    $other_payment_json = json_encode($other_payments);

    return $other_payment_json;
  }

  public static function overtime($id)
  {
    //Overtime
    $over_times = Overtime::where('employee_id', '=', $id)->get();
    $total_over_time = 0;
    foreach ($over_times as $over_time) {
      $total_work = $over_time->number_of_days * $over_time->hours;
      $amount = $total_work * $over_time->rate;
      $total_over_time = $amount + $total_over_time;
    }
    $over_time_json = json_encode($over_times);

    return $over_time_json;
  }

  public static function employee_id()
  {
    $employee = Employee::latest()->first();

    return !empty($employee) ? $employee->id + 1 : 1;
  }

  public function branch()
  {
    return $this->hasOne('App\Models\Branch', 'id', 'branch_id');
  }

  public function department()
  {
    return $this->hasOne('App\Models\Department', 'id', 'department_id');
  }

  public function designation()
  {
    return $this->hasOne('App\Models\Designation', 'id', 'designation_id');
  }

  public function salaryType()
  {
    return $this->hasOne('App\Models\PayslipType', 'id', 'salary_type');
  }

  public function user()
  {
    return $this->hasOne('App\Models\User', 'id', 'user_id');
  }

  public function paySlip()
  {
    return $this->hasOne('App\Models\PaySlip', 'id', 'employee_id');
  }

  public function bankAccount()
  {
    return $this->hasOne('App\Models\BankAccount', 'id', 'account');
  }


  public function present_status($employee_id, $data)
  {
    return AttendanceEmployee::where('employee_id', $employee_id)->where('date', $data)->first();
  }


  public static function employee_salary($salary)
  {
    $employee = Employee::where("salary", $salary)->first();
    if ($employee->salary == '0' || $employee->salary == '0.0') {
      return "-";
    } else {
      return $employee->salary;
    }
  }

  public function manager()
  {
    return $this->belongsTo(Employee::class, 'manager_id');
  }

  public function subordinates()
  {
    return $this->hasMany(Employee::class, 'manager_id');
  }

  public function excuseApprovals()
  {
    return $this->hasMany(ExcuseApproval::class, 'approver_id', 'user_id');
  }
  public function leaveApprovals()
  {
    return $this->hasMany(LeaveApproval::class, 'approver_id', 'user_id');
  }
  public function businessApprovals()
  {
    return $this->hasMany(BusinessMissionApproval::class, 'approver_id', 'user_id');
  }
}
