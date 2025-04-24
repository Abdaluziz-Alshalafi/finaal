<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TeamAddedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $studentName;
    public $teamName;
    public $researchTitle;
    public $researchdescription;
    public $additionalMessage;
    public $requestId;


    public function __construct($studentName,$teamName, $researchTitle, $researchdescription, $additionalMessage = null,$requestId)
    {
        $this->studentName = $studentName;
        $this->teamName = $teamName;
        $this->researchTitle = $researchTitle;
        $this->researchdescription = $researchdescription;
        $this->additionalMessage = $additionalMessage;
        $this->requestId = $requestId;
    }

    public function build()
    {
        return $this->subject('تمت دعوتك  لتكوين فريق!')
                    ->view('static.emails.team_added')
                    ->with([
                        'studentName' => $this->studentName,
                        'teamName' => $this->teamName,
                        'researchTitle' => $this->researchTitle,
                        'researchdescription' => $this->researchdescription,
                        'additionalMessage' => $this->additionalMessage,
                        'requestId' => $this->requestId,



                    ]);
    }
}
