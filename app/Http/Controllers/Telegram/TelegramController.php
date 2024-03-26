<?php

namespace App\Http\Controllers\Telegram;

use App\Http\Controllers\Controller;
use App\Http\Requests\Telegram\SendTelegramMessageRequest;
use App\Services\Telegram\TelegramService;
use Illuminate\Http\Request;

class TelegramController extends Controller
{
    public function __construct(protected TelegramService $service)
    {
    }

    public function send(Request $request)
    {
        return $this->service->sendMessage($request['phone'], $request['message']);
    }

}
