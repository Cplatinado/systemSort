<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Promotion extends Mailable
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
        return  $this->view('Mail.winner', [
            'name' => $this->data['reply_name'],
            'sorteio' => $this->data['sorteio'],

        ])
            ->replyTo($this->data['reply_email'])
            ->to($this->data['reply_email'])
            ->subject('Parabéns '.$this->data['reply_name']. ' você foi o ganhador do Soterio ou Promoção :)');
    }
}
