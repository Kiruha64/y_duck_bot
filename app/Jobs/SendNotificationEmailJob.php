<?php

namespace App\Jobs;

use App\Mail\NotificationEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendNotificationEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email;
//    protected $subject;
    protected $content;

    /**
     * Create a new job instance.
     *
     * @param string $email
//     * @param string $subject
     * @param string $content
     */
    public function __construct(string $email, string $content)
    {
        $this->email = $email;
//        $this->subject = $subject;
        $this->content = $content;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Send the email
        Mail::to($this->email)
            ->send(new NotificationEmail($this->content));
    }
}
