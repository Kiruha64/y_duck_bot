<?php

namespace App\Services\Telegram;


use App\Models\TelegramChat;
use Illuminate\Support\Facades\Log;

class TelegramService
{
    public function sendMessage(string $phone, string $message)
    {
        $message = str_replace(['<div>', '</div>'], '', $message);
        $message = strip_tags(str_replace('<br>', "\n", $message));
        $chat = TelegramChat::where('phone', $phone)->first();
        if ($chat) {
            return $chat->html($message)->send();
        }
        return false;
    }

    public function sendMessageFromRequest($chatId, $message)
    {
        $chat = TelegramChat::where('chat_id', $chatId)->first();
        if ($chat) {
            $chat->html($message)->send();
            return 1;
        }
        return false;
    }

    public function findChatById($chatId)
    {
        return $chat = TelegramChat::where('chat_id', $chatId)->first();
    }
}
