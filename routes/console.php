<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('tester', function () {
    /** @var \DefStudio\Telegraph\Models\TelegraphBot $bot */
    $bot = \DefStudio\Telegraph\Models\TelegraphBot::find(1);

    $bot->registerCommands([
        'start' => 'start',
//        'actions' => 'Actions',
        'help' => 'What this bot can do'
    ])->send();
//    $chat = \DefStudio\Telegraph\Models\TelegraphChat::find(1);
//
//// this will use the default parsing method set in config/telegraph.php
//    $chat->message('hello')->send();
//
//    $chat->html("<b>hello</b>\n\nI'm a bot!")->send();
//
//    $chat->markdown('*hello*')->send();
});