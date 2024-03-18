<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;
use App\Mail\SendFeeInvoice;
use Illuminate\Support\Facades\Mail;

class MailInvoice implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $data;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data=$data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
       try {
         $month = Carbon::parse($this->data['date'])->format('F');
         $name = $this->data['name'];
         $email = $this->data['email'];
         $uploadedInvoice = $this->data['uploadedInvoicePath'];

         $emailData=[];
         $emailData['title'] = " GYM-SOL Membership Invoice";
         $emailData['message'] = "Dear ".$name.", I hope this email finds you in good health and high spirits. This is a friendly reminder that your GYM-SOL membership invoice for the month of ".$month." is now due. Your membership includes access to our state-of-the-art gym equipment, unlimited fitness classes, and personalized workout plans designed by our certified trainers. We are committed to providing you with a top-notch fitness experience that helps you achieve your health goals. To ensure uninterrupted access to our facilities and services, please settle your invoice as soon as possible. You can make the payment online by visiting our website or through our mobile app. If you need any assistance with the payment process, please feel free to reach out to our customer service team. Thank you for being a valued member of the GYM-SOL community. We appreciate your continued support and look forward to seeing you soon at our gym.";
         $emailData['invoice'] =  $uploadedInvoice;
         $isEmailSent = Mail::to($email)->send(new SendFeeInvoice($emailData));
       } catch (\Throwable $th) {
          return false;
       }
    }
}
