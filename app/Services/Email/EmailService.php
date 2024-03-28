<?php

namespace App\Services\Email;


use App\Jobs\SendNotificationEmailJob;
use App\Mail\NotificationEmail;
use App\Models\TelegramChat;

class EmailService
{
    public function sendEmail(string $email,string $content)
    {
        SendNotificationEmailJob::dispatch($email, $content)->onQueue('emails');
        return 1;
    }
}
