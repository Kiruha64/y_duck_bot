<?php

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('api/trello/webhook', [\App\Http\Controllers\TrelloController::class, 'handleWebhook']);

Route::get('/', function () {
    $apiKey = config('services.trello.api_key');
    $accessToken = config('services.trello.access_token');

    // Define the callback URL where Trello will send webhook events
    $callbackUrl = "https://b819-178-137-18-62.ngrok-free.app/api/trello/webhook"; // Make sure this is correct and publicly accessible

    // The ID of the Trello board you want to monitor
    $boardId = '66fede13ecf3f0dbd7df0128';

    // The URL for creating a Trello webhook
    $webhookUrl = "https://api.trello.com/1/webhooks/";

    // The data that needs to be sent with the request
    $data = [
        'description' => 'Webhook for card movement notifications',
        'callbackURL' => $callbackUrl,
        'idModel' => $boardId,
        'key' => $apiKey,
        'token' => $accessToken
    ];

    // Send a POST request to Trello API to register the webhook
    $response = Http::withHeaders([
        'Accept' => 'application/json'
    ])->post($webhookUrl, $data);

    // Log or dump the response for debugging
    if ($response->successful()) {
        dd($response->json());
    } else {
        dd('Error:', $response->status(), $response->body());
    }
    return view('welcome');
});
