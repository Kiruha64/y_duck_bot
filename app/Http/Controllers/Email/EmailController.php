<?php

namespace App\Http\Controllers\Email;

use App\Http\Controllers\Controller;
use App\Services\Email\EmailService;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    public function __construct(protected EmailService $service)
    {
    }

    public function send(Request $request)
    {
        return $this->service->sendEmail($request['email'],$request['content']);
    }
}
