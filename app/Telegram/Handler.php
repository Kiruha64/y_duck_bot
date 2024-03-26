<?php

namespace App\Telegram;

use App\Models\TelegramChat;
use App\Services\Telegram\TelegramService;
use DefStudio\Telegraph\Facades\Telegraph;
use DefStudio\Telegraph\Handlers\WebhookHandler;
use DefStudio\Telegraph\Keyboard\Button;
use DefStudio\Telegraph\Keyboard\Keyboard;
use DefStudio\Telegraph\Keyboard\ReplyButton;
use DefStudio\Telegraph\Keyboard\ReplyKeyboard;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Stringable;

class Handler extends WebhookHandler
{

    protected function getChatId()
    {
        return $this->message->chat()->id();
    }
    protected function sendMessage($chatId,$message)
    {
        app(TelegramService::class)->sendMessageFromRequest($chatId,$message);
    }
    public function start()
    {
//        $keyboard = ReplyKeyboard::make()
//            ->button('Text')
//            ->button('Send Contact')->requestContact()
//            ->button('Send Location')->requestLocation()
//            ->button('Create Quiz')->requestQuiz()
//            ->button('Create Poll')->requestPoll()
//            ->button('Start WebApp')->webApp('https://web.app.dev')
//            ->chunk(2);
//        Telegraph::message('Выбери какое-то действие')
//            ->keyboard(
//                $keyboard
//            )->send();
//        $keyboard = ReplyKeyboard::make()
//            ->button('Send Contact')->requestContact()
//            ->oneTime();
//
//        $message = Telegraph::message('For subscribe on notifications please provide your phone number')
//            ->replyKeyboard($keyboard);
        $keyboard = ReplyKeyboard::make()
            ->button('Send Contact')->requestContact()
            ->oneTime();

        $chat = app(TelegramService::class)->findChatById($this->getChatId());
// Create the message with the custom keyboard
        $message = $chat->message('For subscribe on notifications please provide your phone number')
            ->replyKeyboard($keyboard);

        $message->send();
// Send the message to the specified chat ID
//        $response = Telegraph::sendToChat($this->getChatId(), $message);

//        $this->sendMessage($this->getChatId(),$message);

    }


    public function help(): void
    {
        $this->sendMessage($this->getChatId(),'This is CDL notifications bot');
    }

//    public function actions(): void
//    {
//        Telegraph::message('Choose an action')
//            ->keyboard(
//                Keyboard::make()->buttons([
////                    Button::make('Перейти на сайт')->url('https://areaweb.su'),
////                    Button::make('Поставить лайк')->action('like'),
//                    Button::make('Subscribe')
//                        ->action('subscribe')
//                        ->param('channel_name', '@areaweb'),
//                ])
//            )->send();
//    }

//    public function subscribe(): void
//    {
//        $this->reply("Спасибо за подписку на {$this->data->get('channel_name')}");
//    }

    protected function handleUnknownCommand(Stringable $text): void
    {
        if ($text->value() !== '/start') {
            $this->reply('Unknown command');
        }
    }

    protected function handleChatMessage(Stringable $text): void
    {
//        Log::info('This is the value: ' . $this->request);

//        app(TelegramService::class)->sendMessage('380971955120','helelo rfo serivce');
//        $contactPhone = $this->message->contact()->phoneNumber();
        if ($this->message?->contact()){
            $phone = $this->message?->contact()->phoneNumber();

            $chat = \DefStudio\Telegraph\Models\TelegraphChat::where('chat_id',$this->getChatId());
            $chat->update(['phone'=>$phone]);

        }
//       $this->reply($text);
    }
}