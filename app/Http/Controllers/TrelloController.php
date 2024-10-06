<?php

namespace App\Http\Controllers;

use App\Services\Telegram\TelegramService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TrelloController extends Controller
{
    public function handleWebhook(Request $request)
    {

        if (isset($request['action']['type']) && $request['action']['type'] === 'updateCard') {
            $card = $request['action']['data']['card'];

            if (isset($request['action']['data']['listBefore']) && isset($request['action']['data']['listAfter'])) {
                $listBefore = $request['action']['data']['listBefore'];
                $listAfter = $request['action']['data']['listAfter'];

                if (
                    ($listBefore['name'] === 'InProgress' && $listAfter['name'] === 'done') ||
                    ($listBefore['name'] === 'done' && $listAfter['name'] === 'InProgress')
                ) {
                    $message = 'Card ' . $card['name'] . ' Was moved from ' . $listBefore['name'] . ' to ' . $listAfter['name'];
                    app(TelegramService::class)->sendMessage($message);
                }
            } else {
                Log::info('Card updated but not moved between lists.', ['card' => $card]);
            }
        }

        return response()->json(['status' => 'success'], 200);
    }

}
