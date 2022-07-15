<?php

namespace App\Jobs;

use Mail;
use App\Mail\MailNotify;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;
    protected $mails;

    /**
     * Create a new job instance.
     *
     * @param $data
     */
    public function __construct($data, $mails)
    {
        $this->data = $data;
        $this->mails = $mails;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->mails as $mail) {
            Mail::to($mail)->send(new MailNotify($this->data));
        }
        // Mail::to('tao.nq173356@gmail.com')
        //     ->send(new MailNotify($this->data));
    }
}
