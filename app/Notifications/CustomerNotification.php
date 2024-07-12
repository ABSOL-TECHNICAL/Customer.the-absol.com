<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Support\Facades\Log;

class CustomerNotification extends Notification
{
    use Queueable;

    protected $record;
    protected $comment;
    protected $type;

    public function __construct($record, $comment, $type)
    {
        $this->record = $record;
        $this->comment = $comment;
        $this->type = $type;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        $title = $this->type == 'rejected' ? 'Application Rejected' : 'New Comment Added';
        $message = $this->type == 'rejected' ? 'Your application has been rejected. Comment: ' . $this->comment : 'A new comment has been added to your approval request. Comment: ' . $this->comment;
        Log::info('Notification created: ', ['title' => $title, 'message' => $message]);
        return [
            'title' => $title,
            'message' => $message,
            'record_id' => $this->record->id,
        ];
    }   
}
