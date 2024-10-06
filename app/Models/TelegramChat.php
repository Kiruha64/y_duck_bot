<?php

namespace App\Models;

use DefStudio\Telegraph\Models\TelegraphChat;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TelegramChat extends TelegraphChat
{

    protected $table = 'telegraph_chats';
    protected $fillable = [
        'chat_id',
        'name',
        'phone',
    ];
}

