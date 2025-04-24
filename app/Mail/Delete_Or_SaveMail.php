<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;





class Delete_Or_SaveMail extends Mailable
{
    use SerializesModels;

    public $status_Record;
    public $studentnamess;



    /**
     * Create a new message instance.
     */
    public function __construct($status_Record,$studentnamess)
    {
        $this->status_Record = $status_Record;
        $this->studentnamess = $studentnamess;

    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject(' حالة المشروع')
            ->view('static.emails.status_Record') // قم بربط القالب مع هذا البريد
            ->with([
                'status_Record' => $this->status_Record,
                'studentnamess' => $this->studentnamess,

            ]);
    }



    /**
     * Get the message envelope.
     */

}
