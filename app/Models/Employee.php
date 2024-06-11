<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
     protected $fillable = [ 
        'uanNo', 'esiNo', 'name', 'department', 'designation', 'doj', 
        'employee_code', 'pan_no', 'account_no', 'ctc', 'basic', 'hra', 
        'ca', 'spl_all', 'month_days', 'monthly_working_hours', 
        'employee_working_hours', 'payable_days', 'payable_conv_allow', 
        'total_earned_salary', 'total_hourly_earned_salary', 'epf_salary', 
        'epf', 'edls_0_50', 'epf_admin_charges_0_50', 'esi_salary', 
        'employer_count', 'salary_payable', 'loan_if_any', 'bonus_if_any', 
        'over_time', 'tds_2024_2025', 'medical_insurance', 
        'professional_tax', 'net_payable', 'email'
    ];
}
