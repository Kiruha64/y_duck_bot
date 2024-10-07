<?php

namespace App\Telegram;

use App\Models\TelegramChat;
use App\Models\User;
use App\Services\Telegram\TelegramService;
use App\Services\Trello\TrelloService;
use DefStudio\Telegraph\Facades\Telegraph;
use DefStudio\Telegraph\Handlers\WebhookHandler;
use DefStudio\Telegraph\Keyboard\Button;
use DefStudio\Telegraph\Keyboard\Keyboard;
use DefStudio\Telegraph\Keyboard\ReplyButton;
use DefStudio\Telegraph\Keyboard\ReplyKeyboard;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;

class Handler extends WebhookHandler
{

    protected function getChatId()
    {
        return $this->message->chat()->id();
    }

    public function start()
    {
        Log::info('Chat data: ', $this->message->toArray());

        $data = $this->message->toArray();
//        Log::info('Chat data: ', $this->toArray());


        // Check if 'from' and 'username' keys exist
        $username = $data['from']['username'];

        // Register or update PM in the database
        User::firstOrCreate(
            ['telegram_id' => $data['from']['id']],
            [
                'name' => $username,
                'password' => Hash::make(Str::random(10)), // Generate and hash a random password
            ]
        );

        // Greet the PM
        Telegraph::message('HI ' . $username . "! Please provide your Trello email for authorization:")->send();
    }

    public function handleTrelloAuthorization(string $email)
    {
        // Log the received Trello email
        Log::info("Trello email received: " . $email);

        $data = $this->message->toArray();
        $tgId = $data['from']['id'];
        $user = User::where('telegram_id', $tgId)->first();
        if ($user['email'] === null) {
            $user->update(['email' => $email]);
        }


        // Invite the user to Trello
        $response = app(TrelloService::class)->inviteMember($email, $user['name']);

        // Provide feedback to the user
        if ($response['success']) {
            // Example: Send Trello board link back to the PM
            $boardLink = "https://trello.com/b/pBEkVwRB/yllducktest";
            Telegraph::message('Your Trello invitation was sent successfully! Here is the link to your Trello board: ' . $boardLink)->send();
        } else {
            // Handle errors and inform the user
            Telegraph::message($response['message'])->send();
        }
    }


    protected function handleUnknownCommand(Stringable $text): void
    {
        if ($text->value() !== '/start') {
            $this->reply('Unknown command');
        }
    }

    protected function handleChatMessage(Stringable $text): void
    {
//        // If the user provides a phone number (through a contact request)
//        if ($this->message?->contact()) {
//            $phone = $this->message->contact()->phoneNumber();
//
//            // Assuming there's a chat record for this conversation
//            $chat = \DefStudio\Telegraph\Models\TelegraphChat::where('chat_id', $this->getChatId())->first();
//            $chat->update(['phone' => $phone]);
//
//            // Inform user about successful phone number capture
//            $this->sendMessage($this->getChatId(), "Thank you for providing your phone number!");
//        }
//

        // Validate email input and trigger Trello authorization flow
        if (filter_var($text->value(), FILTER_VALIDATE_EMAIL)) {

            // Call the Trello authorization handler with the provided email
            $this->handleTrelloAuthorization($text->value());
        } else {
            // Optionally handle other types of messages if needed
            Log::info("Received non-email message: " . $text->value());
        }
    }
//kyryl.verbukhowskyi@gmail.com

}
