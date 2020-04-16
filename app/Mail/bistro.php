<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class bistro extends Mailable
{
    use Queueable, SerializesModels;
    private $data;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(array  $data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
       return  $this->view('Mail.activate', [
           'name' => $this->data['reply_name'],
           'email' => $this->data['reply_email'],
           'cel' => $this->data['tel'],
           'link'=> $this->data['link']
       ])
           ->replyTo($this->data['reply_email'])
           ->to($this->data['reply_email'])
           ->subject('Olá '.$this->data['reply_name']. ' Confirme seu e-mail para participar do Soterio ou Promoção :)');


    }
}
