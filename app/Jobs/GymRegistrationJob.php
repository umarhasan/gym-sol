<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\GYM_Registration_Mail;
use Illuminate\Support\Facades\Mail;

class GymRegistrationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $jobDetails;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($jobData)
    {
        $this->jobDetails = $jobData;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $emailData = [];
        $emailData['title'] = $this->jobDetails['title'];
        $emailData['body'] = $this->jobDetails['body'];
        try {
            Mail::to($this->jobDetails['email'])->send(new GYM_Registration_Mail($emailData));
        } catch (\Throwable $th) {
            return false;
        }

       try {
        $phone_number = $this->jobDetails['phone']; 
        $name = $this->jobDetails['name'];

        $message = "Dear '.$name.', We hope this message finds you well. This is to inform you that your account has been successfully created with GYM-SOL. However, we have noticed that your account is currently inactive. To activate your account and start using our services, kindly contact us via our official WhatsApp number +923344181020. Our customer service representatives will be available to assist you with the activation process. Thank you for choosing GYM-SOL, and we look forward to serving you soon. Best regards, GYM-SOL Team"; // replace with your desired message            
        $url = "https://get.wsender.net/api/send.php?number=$phone_number&type=text&message=" . urlencode($message) . "&instance_id=63FF3F3153FEC&access_token=3b07c84afca3e47e805d83ec23e7f1f8";
        
        // Initialize cURL session
        $ch = curl_init();
        // Set cURL options
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Execute the cURL request
        $response = curl_exec($ch);
        // Close cURL session
        curl_close($ch); 
    } catch (\Throwable $th) {
       return false;
    }

    }
}
