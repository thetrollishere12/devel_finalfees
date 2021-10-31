<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Message extends Mailable
{
    use Queueable, SerializesModels;

    protected $request;

  /**
   * Create a new message instance.
   *
   * @return void
   */
    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $email = $this->from("info@finalfees.com")
        ->view('emails.message')
        ->with([
            'inputs' => $this->request
        ]);

    }
}
