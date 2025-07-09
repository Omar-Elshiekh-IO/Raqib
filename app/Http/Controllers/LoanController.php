<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Loan;
use App\Models\LoanOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoanController extends Controller
{
  public function index()
  {
    if (Auth::user()->can('manage loan')) {
      if (Auth::user()->type == 'company' || Auth::user()->type == 'HR') {
        $loans = Loan::where('created_by', Auth::user()->creatorId())->with(['employee', 'loanOption'])->get();
      } else {
        $employee = Employee::where('employee_id', Auth::user()->id)->first();
        $loans = Loan::where('created_by', $employee->id)->with(['employee', 'loanOption'])->get();
      }

      return view('loan.index', compact('loans'));
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
      $loan->created_by = \Auth::user()->creatorId();
      $loan->save();

      return redirect()->back()->with('success', __('Loan  successfully created.'));
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

}
