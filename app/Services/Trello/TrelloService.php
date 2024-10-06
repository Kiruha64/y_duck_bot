<?php

namespace App\Services\Trello;


use App\Models\TelegramChat;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TrelloService
{
    public function inviteMember(string $email, string $name)
    {
        $orgId = '66fede1340af854583e23cf6';
        $trelloApiKey = config('services.trello.api_key');
        $trelloAccessToken = config('services.trello.access_token');
        $trelloInviteUrl = 'https://trello.com/1/organizations/' . $orgId . '/members';

        $type = 'normal';

        $fields = [
            'fullName' => $name,
            'email' => $email,
            'type' => $type,
            'key' => $trelloApiKey,
            'token' => $trelloAccessToken,
        ];

        $response = Http::put($trelloInviteUrl, $fields);

        if ($response->successful()) {
            return ['success' => true];
        }

        // Log error details
        Log::error("Trello invitation failed: " . $response->body());
        return ['success' => false, 'message' => $response->body()];
    }
}
