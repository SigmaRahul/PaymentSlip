<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Mail\EmployeeDataMail;
use Barryvdh\DomPDF\Facade as Pdf;
use Illuminate\Support\Facades\Mail;
use App\Models\Employee; 
use Carbon\Carbon; 

class SendPdf extends Command
{

    protected $signature = 'app:send-pdf';

    protected $description = 'Command description';


    public function handle()
    {
        try {
            
            $currentDate = Carbon::today();
           
            $employee = Employee::whereDate('created_at', $currentDate)->get(); 

            if ($employee->isEmpty()) {
                $this->info('No employee data found for the current date.');
                return;
            }

            $pdf = Pdf::loadView('employee-data', compact('employee'));

            Mail::to('rahulsinha@techmarbles.com')->send(new EmployeeDataMail($employee, $pdf->output()));

            $this->info('Employee data PDF generated and email sent successfully!');
        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
        }
    }
}
