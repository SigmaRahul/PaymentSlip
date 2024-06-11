<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('uanNo')->default('NA');
            $table->string('esiNo')->default('NA');
            $table->string('name');
            $table->string('department');
            $table->string('designation');
            $table->date('doj');
            $table->string('employee_code');
            $table->string('pan_no');
            $table->string('account_no');
            $table->decimal('ctc', 10, 2);
            $table->decimal('basic', 10, 2);
            $table->decimal('hra', 10, 2);
            $table->decimal('ca', 10, 2);
            $table->decimal('spl_all', 10, 2);
            $table->decimal('month_days', 10, 2);
            $table->decimal('monthly_working_hours', 10, 2);
            $table->decimal('employee_working_hours', 10, 2);
            $table->decimal('payable_days', 10, 2);
            $table->decimal('payable_conv_allow', 10, 2);
            $table->decimal('total_earned_salary', 10, 2);
            $table->decimal('total_hourly_earned_salary', 10, 2);
            $table->decimal('epf_salary', 10, 2);
            $table->decimal('epf', 10, 2);
            $table->decimal('edls_0_50', 10, 2);
            $table->decimal('epf_admin_charges_0_50', 10, 2);
            $table->decimal('esi_salary', 10, 2);
            $table->decimal('employer_count', 10, 2);
            $table->decimal('salary_payable', 10, 2);
            $table->decimal('loan_if_any', 10, 2);
            $table->decimal('bonus_if_any', 10, 2);
            $table->decimal('over_time', 10, 2);
            $table->decimal('tds_2024_2025', 10, 2);
            $table->decimal('medical_insurance', 10, 2)->nullable();
            $table->decimal('professional_tax', 10, 2);
            $table->decimal('net_payable', 10, 2);
            $table->string('email')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
