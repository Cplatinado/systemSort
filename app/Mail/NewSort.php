<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewSort extends Mailable
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
        return  $this->view('Mail.newSort', [
            'name' => $this->data['reply_name'],
            'sorteio' => $this->data['sorteio'],
            'link'=>$this->data['link'],
            'call'=>$this->data['call'],

        ])
            ->replyTo($this->data['reply_email'])
            ->to($this->data['reply_email'])
            ->subject('Olá '.$this->data['reply_name']. ' venha conferir mais um novo sorteio ou Promoção :)');
    }
}
