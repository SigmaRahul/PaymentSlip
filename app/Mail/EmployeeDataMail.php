<?php

namespace App\Mail;


use App\Models\Employee; 
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class EmployeeDataMail extends Mailable
{
    use Queueable, SerializesModels;

    public $employee; // Declare a public property to hold the employee data

    /**
     * Create a new message instance.
     */
    public function __construct(Employee $employee)
    {
        $this->employee = $employee; // Assign the employee data to the property
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Employee Data Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'employee-data', // Specify the view name for the email content
            with: [
                'employee' => $this->employee, // Pass the employee data to the view
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}