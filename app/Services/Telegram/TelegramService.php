<?php

namespace App\Services\Telegram;


use App\Models\TelegramChat;
use Illuminate\Support\Facades\Log;

class TelegramService
{


    public function sendMessage($message)
    {
        $chat = TelegramChat::first();
        if ($chat) {
            $chat->html($message)->send();
            return true;
        }
        return false;
    }


}
