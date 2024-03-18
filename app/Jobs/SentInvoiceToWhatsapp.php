<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SentInvoiceToWhatsapp implements ShouldQueue
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
        try{
            $accessToken = $this->data['whatsappAccessToken'];
            $instanceId = $this->data['instantId'];
            $filePath =  $this->data['filePaths'];
            $phone_number = $this->data['phone_no'];
            $name = $this->data['user_name'];

            $message = "Dear $name , to inform you that your subscription to GYM-SOL has been successfully processed. Attached to this message, you will find a copy of the invoice for your records. Please keep it with you as proof of your subscription. If you have any questions or concerns regarding your membership, please do not hesitate to reach out to us. Thank you for choosing GYM-SOL, and we look forward to seeing you soon.";
            $url = "https://get.wsender.net/api/send.php?number=$phone_number&type=media&message=". urlencode($message) ."&media_url=https://www.k12blueprint.com/sites/default/files/Learning-Management-System-Guide.pdf&filename=invoice.pdf&instance_id=". $instanceId ."&access_token=". $accessToken;
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
