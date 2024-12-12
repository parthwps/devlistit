<?php
namespace App\Mail;

use Illuminate\Mail\Mailable;

class MyReportMail extends Mailable
{
    public $messageContent;

    public function __construct($messageContent)
    {
        $this->messageContent = $messageContent;
    }

    public function build()
    {
         $subject = 'Weekly report'; // Set your email subject here
        $pdfPath = storage_path('app/temp.pdf');

        return $this->subject($subject)
            ->view('emails.email-subscription-report')
            ->attach($pdfPath, [
                'as' => 'report.pdf',
                'mime' => 'application/pdf',
            ]);
    }
}
