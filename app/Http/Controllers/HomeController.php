<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\EmployeeDataMail;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\User;
use Carbon\Carbon;


class HomeController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request) {
        $user = Auth::user()->is_admin;
        if($user){
            return view('admin.dashboard');
        }else{
           $email = Auth::user()->email;
           $employees = Employee::where('email', $email)->get();
           
            return view('home', compact('employees'));
        }
    }
    public function sendEmployeeEmail(Request $request)
    {
          $createdAt = $request->input('created_at'); 
          $employeeId = $request->input('employee_id');

          try {
            $date = Carbon::createFromFormat('Y-m-d H:i:s', $createdAt);
        } catch (\Exception $e) {
            try {
                $date = Carbon::createFromFormat('Y-m-d', $createdAt);
            } catch (\Exception $e) {
                return response()->json(['error' => 'Invalid date format. Please use YYYY-MM-DD or YYYY-MM-DD HH:MM:SS format.'], 400);
            }
        }

        if ($employeeId) {
            $employee = Employee::find($employeeId);
            if (!$employee) {
                return response()->json(['error' => 'Employee not found.'], 404);
            }
            try {
                $pdf = Pdf::loadView('employee-data', compact('employee'));
                
            } catch (\Exception $e) {
                return response()->json(['error' => 'PDF generation failed: ' . $e->getMessage()], 500);
            }

            Mail::to('rahulsinha@techmarbles.com')->send(new EmployeeDataMail($employee, $pdf->output()));

            // Mail::to($employee->email)->send(new EmployeeDataMail($employee));

            return redirect()->back()->with('status', 'Email sent successfully!');
        }
    }
    public function downloadPdf(Request $request){
        $createdAt = $request->input('created_at'); 
          $employeeId = $request->input('employee_id');

          try {
            $date = Carbon::createFromFormat('Y-m-d H:i:s', $createdAt);
        } catch (\Exception $e) {
            try {
                $date = Carbon::createFromFormat('Y-m-d', $createdAt);
            } catch (\Exception $e) {
                return response()->json(['error' => 'Invalid date format. Please use YYYY-MM-DD or YYYY-MM-DD HH:MM:SS format.'], 400);
            }
        }

        if ($employeeId) {
            $employee = Employee::find($employeeId);
            if (!$employee) {
                return response()->json(['error' => 'Employee not found.'], 404);
            }
            try {
                $pdf = Pdf::loadView('employee-data', compact('employee'));
                return $pdf->download('employee_pay_slip.pdf');
            } catch (\Exception $e) {
                return response()->json(['error' => 'PDF generation failed: ' . $e->getMessage()], 500);
            }
        }
    }

}
