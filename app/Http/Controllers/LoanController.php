<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Loan;
use App\Models\LoanApproval;
use App\Models\LoanOption;
use App\Models\User;
use App\Models\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LoanController extends Controller
{
  public function index()
  {
    if (Auth::user()->can('view loan')) {
      $pendingApprovals = null;
      if (Auth::user()->type == 'company' || Auth::user()->type == 'HR') {
        $employeeIds = User::where('created_by', Auth::user()->creatorId())->pluck('id');
        $loans = Loan::whereIn('created_by', $employeeIds)->with(['employee', 'loanOption'])->get();
        $loansBySelf = Loan::where('created_by', Auth::user()->creatorId())->with(['employee', 'loanOption'])->get();
        $loans = $loans->merge($loansBySelf);
      } else {
        // For managers, show only pending approvals for them
        $pendingApprovals = \App\Models\LoanApproval::where('approver_id', Auth::id())
          ->where('status', 'pending')
          ->with('loan.employee', 'loan.loanOption')
          ->get();

        // For employees, show their own loans
        $employee = Employee::where('user_id', Auth::user()->id)->first();
        if (!$employee) {
          return redirect()->back()->with('error', __('Employee not found.'));
        }
        $loans = Loan::where('employee_id', $employee->id)->with(['employee', 'loanOption'])->get();

        return view('loan.index', compact('loans', 'pendingApprovals'));
      }
      return view('loan.index', compact('loans', 'pendingApprovals'));
    } else {
      return redirect()->back()->with('error', __('Permission denied.'));
    }
  }

  public function create()
  {
    if (Auth::user()->can('create loan')) {
      $employeeId = 0;
      if (Auth::user()->type == 'company' || Auth::user()->type == 'HR') {
        $employees = Employee::where('created_by', Auth::user()->creatorId())->get()->pluck('name', 'id');
      } else {
        $employees = Employee::where('user_id', Auth::id())->get()->pluck('name', 'id');
        $employee = Auth::user()->employee;
        $employeeId = $employee?->id;
      }
      $loanOptions = LoanOption::where('created_by', Auth::user()->creatorId())->get();

      return view('loan.createPopUp', compact('employees', 'loanOptions', 'employeeId'));
    } else {
      return response()->json(['error' => __('Permission denied.')]);
    }
  }

  public function loanCreate($id)
  {
    $employee = Employee::find($id);
    $loan_options = LoanOption::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
    $loan = loan::$Loantypes;

    return view('loan.create', compact('employee', 'loan_options', 'loan'));
  }

  public function store(Request $request)
  {
    if (\Auth::user()->can('create loan')) {
      $validator = \Validator::make(
        $request->all(),
        [
          'employee_id' => 'required',
          'loan_option' => 'required',
          'title' => 'required',
          'amount' => 'required',
          'reason' => 'required',
          'with_deduction' => 'nullable|boolean',
          'deduction_amount' => 'nullable|numeric|min:0|required_if:with_deduction,1',
          'start_deduction_date' => 'nullable|date',
          'end_deduction_date' => 'nullable|date|after_or_equal:start_deduction_date',
        ]
      );
      if ($validator->fails()) {
        $messages = $validator->getMessageBag();

        return redirect()->back()->with('error', $messages->first());
      }

      $loan = new Loan();
      $loan->employee_id = $request->employee_id;
      $loan->loan_option = $request->loan_option;
      $loan->title = $request->title;
      $loan->amount = $request->amount;
      $loan->type = $request->type;

      $loan->with_deduction = $request->with_deduction ? 1 : 0;
      $loan->deduction_amount = $request->with_deduction ? $request->deduction_amount : null;
      $loan->start_deduction_date = $request->with_deduction ? $request->start_deduction_date . '-01' : null;
      $loan->end_deduction_date = $request->with_deduction ? $request->end_deduction_date . '-01' : null;
      if ($request->with_deduction && $request->start_deduction_date && $request->end_deduction_date) {
        $start = new \DateTime($request->start_deduction_date);
        $end = new \DateTime($request->end_deduction_date);
        $months = (($end->format('Y') - $start->format('Y')) * 12) + ($end->format('m') - $start->format('m')) + 1;
        $loan->total_deduction_months = $months;
      } else {
        $loan->total_deduction_months = null;
      }
      $loan->reason = $request->reason;
      $loan->created_by = Auth::user()->creatorId();
      $loan->save();

      $approvalType = DB::selectOne('SELECT value FROM settings WHERE name = "loan_levels" AND created_by = ?', [Auth::user()->creatorId()])->value;
      if (str_contains($approvalType, '_')) {
        $employeeId = explode('_', $approvalType)[0];
        $employee = Employee::find($employeeId);
        $approverId = $employee->user_id;
        // dd($approverId);

        LoanApproval::create([
          'loan_id' => $loan->id,
          'approver_id' => $approverId,
          'status' => 'pending',
        ]);
      } else {
        // Get the employee who submitted the request
        $employee = Employee::find($request->employee_id);

        // Create only the first approval for the direct manager
        if ($employee && $employee->manager) {
          LoanApproval::create([
            'loan_id' => $loan->id,
            'approver_id' => $employee->manager->user_id, // Use user_id of the manager
            'status' => 'pending',
          ]);
        }
      }

      return redirect()->back()->with('success', __('Loan successfully created.'));
    } else {
      return redirect()->back()->with('error', __('Permission denied.'));
    }
  }

  public function show(Loan $loan)
  {
    return redirect()->route('commision.index');
  }

  public function edit($loan)
  {
    $loan = Loan::find($loan);
    if (\Auth::user()->can('edit loan')) {
      if ($loan->created_by == \Auth::user()->creatorId()) {
        $loan_options = LoanOption::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
        $loans = loan::$Loantypes;
        return view('loan.edit', compact('loan', 'loan_options', 'loans'));
      } else {
        return response()->json(['error' => __('Permission denied.')], 401);
      }
    } else {
      return response()->json(['error' => __('Permission denied.')], 401);
    }
  }

  public function editPopUp($loan)
  {
    $loan = Loan::with('loanOption')->find($loan);
    if (\Auth::user()->can('edit loan')) {
      $employeeId = 0;
      if (Auth::user()->type == 'company' || Auth::user()->type == 'HR') {
        $employees = Employee::where('created_by', Auth::user()->creatorId())->get()->pluck('name', 'id');
      } else {
        $employees = Employee::where('user_id', Auth::id())->get()->pluck('name', 'id');
        $employee = Auth::user()->employee;
        $employeeId = $employee?->id;
      }
      $loanOptions = LoanOption::where('created_by', Auth::user()->creatorId())->get();

      return view('loan.editPopUp', compact('employees', 'loanOptions', 'employeeId', 'loan'));
    } else {
      return response()->json(['error' => __('Permission denied.')], 401);
    }
  }

  public function update(Request $request, Loan $loan)
  {
    if (\Auth::user()->can('edit loan')) {
      if ($loan->created_by == \Auth::user()->creatorId()) {
        $validator = \Validator::make(
          $request->all(),
          [
            'loan_option' => 'required',
            'title' => 'required',
            'amount' => 'required',
            'reason' => 'required',
          ]
        );
        if ($validator->fails()) {
          $messages = $validator->getMessageBag();

          return redirect()->back()->with('error', $messages->first());
        }
        $loan->loan_option = $request->loan_option;
        $loan->title = $request->title;
        $loan->type = $request->type;
        $loan->amount = $request->amount;
        //                $loan->start_date  = $request->start_date;
        //                $loan->end_date    = $request->end_date;
        $loan->reason = $request->reason;
        $loan->save();

        return redirect()->back()->with('success', __('Loan successfully updated.'));
      } else {
        return redirect()->back()->with('error', __('Permission denied.'));
      }
    } else {
      return redirect()->back()->with('error', __('Permission denied.'));
    }
  }

  public function updatePopUp(Request $request, Loan $loan)
  {
    if (\Auth::user()->can('edit loan')) {
      if ($loan->created_by == \Auth::user()->creatorId()) {
        $validated = $request->validate([
          'employee_id' => 'required',
          'loan_option' => 'required',
          'title' => 'required',
          'amount' => 'required',
          'reason' => 'required',
          'with_deduction' => 'nullable|boolean',
          'deduction_amount' => 'nullable|numeric|min:0|required_if:with_deduction,1',
          'start_deduction_date' => 'nullable|date',
          'end_deduction_date' => 'nullable|date|after_or_equal:start_deduction_date',
        ]);
        $loan->start_deduction_date = $request->with_deduction ? $request->start_deduction_date . '-01' : null;
        $loan->end_deduction_date = $request->with_deduction ? $request->end_deduction_date . '-01' : null;
        if ($request->with_deduction && $request->start_deduction_date && $request->end_deduction_date) {
          $start = new \DateTime($request->start_deduction_date);
          $end = new \DateTime($request->end_deduction_date);
          $months = (($end->format('Y') - $start->format('Y')) * 12) + ($end->format('m') - $start->format('m')) + 1;
          $loan->total_deduction_months = $months;
        } else {
          $loan->total_deduction_months = null;
        }
        $validated['total_deduction_months'] = $loan->total_deduction_months;
        $loan->update($validated);

        return redirect()->back()->with('success', __('Loan successfully updated.'));
      } else {
        return redirect()->back()->with('error', __('Permission denied.'));
      }
    } else {
      return redirect()->back()->with('error', __('Permission denied.'));
    }
  }

  public function destroy(Loan $loan)
  {
    if (\Auth::user()->can('delete loan')) {
      if ($loan->created_by == \Auth::user()->creatorId()) {
        $loan->delete();

        return redirect()->back()->with('success', __('Loan successfully deleted.'));
      } else {
        return redirect()->back()->with('error', __('Permission denied.'));
      }
    } else {
      return redirect()->back()->with('error', __('Permission denied.'));
    }
  }


  // public function approve($approvalId)
  // {
  //   $approval = LoanApproval::findOrFail($approvalId);

  //   // Check if the current user is the approver
  //   if ($approval->approver_id != Auth::id()) {
  //     return redirect()->back()->with('error', __('Permission denied.'));
  //   }

  //   $approval->update(['status' => 'approved']);

  //   $approvalType = DB::selectOne('SELECT value FROM settings WHERE name = "loan_levels" AND created_by = ?',[Auth::user()->creatorId()])->value;
  //   if(str_contains($approvalType,'_')){
  //     $approval->loan->update(['status' => 'Approved']);
  //     return redirect()->back()->with('success', __('LoanApproval approved successfully.'));
  //   }

  //   // Get the manager of the current approver
  //   $currentApprover = Employee::where('user_id', $approval->approver_id)->first();
  //   $nextManager = $currentApprover ? $currentApprover->manager : null;

  //   if ($nextManager) {
  //     // Create approval for the next manager
  //     LoanApproval::create([
  //       'loan_id' => $approval->loan_id,
  //       'approver_id' => $nextManager->user_id,
  //       'status' => 'pending',
  //     ]);
  //   } else {
  //     // No more managers, mark the loan as fully approved
  //     $approval->loan->update(['status' => 'Approved']);
  //   }

  //   return redirect()->back()->with('success', __('LoanApproval approved successfully.'));
  // }

  // public function reject($approvalId)
  // {
  //   $approval = LoanApproval::findOrFail($approvalId);

  //   // Check if the current user is the approver
  //   if ($approval->approver_id != Auth::id()) {
  //     return redirect()->back()->with('error', __('Permission denied.'));
  //   }

  //   $approval->update(['status' => 'rejected']);

  //   // Mark the loan as rejected
  //   $approval->loan->update(['status' => 'Rejected']);

  //   return redirect()->back()->with('success', __('LoanApproval rejected successfully.'));
  // }

  // Action popup method
  public function action($approvalId)
  {
    $approval = LoanApproval::findOrFail($approvalId);
    $loan = $approval->loan;
    $employee = $loan->employee;

    return view('loan.action', compact('employee', 'loan', 'approval'));
  }

  // Change action method
  public function changeaction(Request $request)
  {
    $approval = LoanApproval::findOrFail($request->approval_id);

    // Check if the current user is the approver
    if ($approval->approver_id != Auth::id()) {
      return redirect()->back()->with('error', __('Permission denied.'));
    }

    if ($request->action == 'Approve') {
      $approval->update(['status' => 'approved']);

      $approvalType = DB::selectOne('SELECT value FROM settings WHERE name = "loan_levels" AND created_by = ?', [Auth::user()->creatorId()])->value;
      if (str_contains($approvalType, '_')) {
        $approval->loan->update(['status' => 'Approved']);
        return redirect()->back()->with('success', __('Loan approved successfully.'));
      }

      $settings = Utility::settings();
      $countApproval = LoanApproval::where('status', 'approved')
        ->where('loan_id', $approval->loan_id)
        ->count();


      if ($countApproval == $settings['loan_levels']) {
        $approval->loan->update(['status' => 'Approved']);
        return redirect()->back()->with('success', __('Loan approved successfully.'));
      }

      // Get the manager of the current approver
      $currentApprover = Employee::where('user_id', $approval->approver_id)->first();
      $nextManager = $currentApprover ? $currentApprover->manager : null;

      if ($nextManager) {
        // Create approval for the next manager
        LoanApproval::create([
          'loan_id' => $approval->loan_id,
          'approver_id' => $nextManager->user_id,
          'status' => 'pending',
        ]);
      } else {
        // No more managers, mark the loan as fully approved
        $approval->loan->update(['status' => 'Approved']);
      }

      return redirect()->route('loan.index')->with('success', __('Loan approved successfully.'));
    } else {
      // dd($approval->loan);
      $approval->update(['status' => 'rejected']);
      $approval->loan->update(['status' => 'Rejected']);

      return redirect()->route('loan.index')->with('success', __('Loan rejected successfully.'));
    }
  }
}
