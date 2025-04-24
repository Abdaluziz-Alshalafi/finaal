<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;



namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RequestStatusMail extends Mailable
{
    use SerializesModels;

    public $studentName;
    public $researchTitle;
    public $status;
    public $counts;



    /**
     * Create a new message instance.
     */
    public function __construct($studentName, $researchTitles, $status, $counts)
    {
        $this->studentName = $studentName;
        $this->researchTitle = $researchTitles;
        $this->status = $status;
        $this->counts = $counts;
     }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('تحديث حالة البحث')
            ->view('static.emails.request_status') // قم بربط القالب مع هذا البريد
            ->with([
                'studentName' => $this->studentName,
                'researchTitles' => $this->researchTitle,
                'status' => $this->status,
                'counts' => $this->counts,

            ]);
    }



    /**
     * Get the message envelope.
     */

}
