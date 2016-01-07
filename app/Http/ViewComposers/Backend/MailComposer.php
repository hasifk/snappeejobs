<?php

namespace App\Http\ViewComposers\Backend;

use Illuminate\Contracts\View\View;
use App\Repositories\Backend\Mail\EloquentMailRepository;

class MailComposer
{
    protected $mail;


    public function __construct(EloquentMailRepository $mailRepository)
    {
        $this->mail = $mailRepository;
    }
    
    public function compose(View $view){
        $unread_messages = $this->mail->getUnReadMessages();
        $view->with('unread_messages_count', $unread_messages);
        if ( $unread_messages ) {
            $view->with('unread_messages', $this->mail->unReadMessages);
        }
    }
    
}