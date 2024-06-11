<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\User;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index() {
    	$users = User::where('is_admin', 0)
                      ->orWhereNull('is_admin')
                      ->get();
    	
    	return view('admin.dashboard',compact('users'));
	}
	public function addPayment(Request $request){

	$file = $request->file('csv');
        $data = array_map('str_getcsv', file($file));

        $header = array_shift($data); 

        $employees = [];
        foreach ($data as $row) {
            $row = array_combine($header, $row);

            $uanNo = $row['UAN NO'];
            $esiNo = $row['ESI No.'];
            $name = $row['NAME'];
            $department = $row['Department'];
            $designation = $row['Designation'];
            $doj = $row['D.O.J.'];
            $employee_code = $row['Employee Code'];
            $pan_no = $row['PAN No.'];
            $account_no = $row['Account No.'];
            $ctc = $row['CTC'];
            $basic = $row['BASIC'];
            $hra = $row['HRA'];
            $ca = $row['C.A.'];
            $spl_all = $row['SPL. ALL.'];
            $month_days = $row['MONTH DAYS'];
            $monthly_working_hours = $row['Monthly Working Hours'];
            $employee_working_hours = $row["Employee's Working Hours"];
            $payable_days = $row['Payable Days'];
            $payable_conv_allow = $row['Conv. Allow.'];
            $total_earned_salary = $row['TOTAL EARNED SALARY'];
            $total_hourly_earned_salary = $row['Total Hourly Earned Salary'];
            $epf_salary = $row['EPF SALARY'];
            $epf= $row['EPF 24%'];
            $edls_0_50= $row['EDLS 0.50%'];
            $epf_admin_charges_0_50= $row['EPF ADMIN CHARGES 0.50%'];
            $esi_salary= $row['ESI SALARY'];
            $employer_count= $row['EMPLOYER CONT. @ 4%'];
            $salary_payable= $row[' SALARY PAYABLE'];
            $loan_if_any= $row['LOAN IF ANY/Trip Adjustment'];
            $bonus_if_any= $row['Bonus if any'];
            $over_time= $row['Over Time'];
            $tds_2024_2025= $row['TDS (2024-2025)'];
            $medical_insurance= $row['Insurance Perium']??'';
            $professional_tax= $row['Professional Tax'];
            $net_payable= $row['NET Payable'];
            $email= $row['email']??'';

            $employees[] = [
            	'uanNo' => $uanNo,
            	'esiNo' => $esiNo,
            	'name' => $name,
            	'department' => $department,
            	'designation' => $designation,
            	'doj' => $doj,
            	'employee_code' => $employee_code,
            	'pan_no' => $pan_no,
            	'account_no' => $account_no,
            	'ctc' => $ctc,
            	'basic' => $basic,
            	'hra' => $hra,
            	'ca' => $ca,
            	'spl_all' => $spl_all,
            	'month_days' => $month_days,
            	'monthly_working_hours' => $monthly_working_hours,
            	'employee_working_hours' => $employee_working_hours,
            	'payable_days' => $payable_days,
            	'payable_conv_allow' => $payable_conv_allow,
            	'total_earned_salary' => $total_earned_salary,
            	'total_hourly_earned_salary' => $total_hourly_earned_salary,
            	'epf_salary' => $epf_salary,
            	'epf' => $epf,
            	'edls_0_50' => $edls_0_50,
            	'epf_admin_charges_0_50' => $epf_admin_charges_0_50,
            	'esi_salary' => $esi_salary,
            	'employer_count' => $employer_count,
            	'salary_payable' => $salary_payable,
            	'loan_if_any' => $loan_if_any,
            	'bonus_if_any' => $bonus_if_any,
            	'over_time' => $over_time,
            	'tds_2024_2025' => $tds_2024_2025,
            	'medical_insurance' => $medical_insurance,
            	'professional_tax' => $professional_tax,
            	'net_payable' => $net_payable,
            	'email' => $email
            ];

        } 
        foreach ($employees as $employeeData) {
 
            $employeeData['doj'] = \Carbon\Carbon::createFromFormat('m/d/Y', $employeeData['doj'])->format('Y-m-d');
            $employeeData['medical_insurance'] = $employeeData['medical_insurance'] === '' ? 0.0 : $employeeData['medical_insurance'];
            $employeeData['professional_tax'] = $employeeData['professional_tax'] === '' ? 0.0 : $employeeData['professional_tax'];


            Employee::create($employeeData);
            if (!empty($employeeData['email'])) {
                $pdfData = [
                    'employee' => $employee,
                ];

                Mail::to($employeeData['email'])->send(new EmployeePDFMail($pdfData));
    }
        }
        
        return redirect()->back()->with('status', 'Payments uploaded successfully.');
	}
	public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return response()->json(['status' => true]);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->all());
        return response()->json(['status' => true]);
    }

}
