<?php

namespace App\Http\Livewire;

use Livewire\Component;
use DB;
use PDF;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Jobs\SentInvoiceToWhatsapp;
use App\Jobs\MailInvoice;

class Invoice extends Component
{
    public $invoice_url;
    public $errMsg='';
    public $successMsg='';

    public function mount($invoice_url) {
        $this->invoice_url = $invoice_url;
    }

    public function render()
    {
        $data = DB::table('fees')
        ->join('users','users.id','fees.user_id')
        ->where('fees.invoice_url',$this->invoice_url)
        ->select('fees.amount','fees.invoice_url', 'fees.date','fees.expiry','fees.amount','fees.club_id','users.name','users.phone', 'users.email','users.image')
        ->first();
        $setting = DB::table('clubs')->where('id',$data->club_id)->first();

        try {
            $uploadedInvoicePath = public_path('pdf/'.$data->invoice_url.'.pdf');
            if (Storage::exists($uploadedInvoicePath)) {
                // The file exists
            } else {
                $pdf = PDF::loadView('invoice_pdf', ['clubSetting' => $setting, 'data' => $data]);
                $filename = $data->invoice_url.'.pdf';
                $pdf->save(public_path('pdf/' . $filename));
            }
        } catch (\Throwable $th) {
            $this->errMsg='Something went wrong while generating the PDF try again by refreshing the page!';
            // Handle the error in some way, such as logging it or displaying a message to the user
        }

        return view('livewire.invoice', ['clubSetting' => $setting, 'data' => $data])->extends('layouts.empty_master')->section('content');
    }

    public function generatePDF() {

        $data = DB::table('fees')
        ->join('users','users.id','fees.user_id')
        ->where('fees.invoice_url',$this->invoice_url)
        ->select('fees.amount','fees.invoice_url', 'fees.date','fees.expiry','fees.amount','fees.club_id','users.name','users.phone', 'users.email', 'users.image')
        ->first();
        $setting = DB::table('clubs')->where('id',$data->club_id)->first();

        try {
            $uploadedInvoicePath = public_path('pdf/'.$data->invoice_url.'.pdf');
            if (Storage::exists($uploadedInvoicePath)) {
                // The file exists
            } else {
                $pdf = PDF::loadView('invoice_pdf', ['clubSetting' => $setting, 'data' => $data]);
                $filename = $data->invoice_url.'.pdf';
                $pdf->save(public_path('pdf/' . $filename));
            }
        } catch (\Throwable $th) {
            $this->errMsg='Something went wrong while generating the PDF try again!';
            // Handle the error in some way, such as logging it or displaying a message to the user
        }
       
        try {
            $emailData=[];
            $emailData['date'] = $data->date;
            $emailData['name'] = $data->name;
            $emailData['email'] = $data->email;
            $emailData['uploadedInvoicePath'] = $uploadedInvoicePath;  
            MailInvoice::dispatch($emailData)->onQueue('invoice-sending-mail');
            $this->successMsg='Invoice has been successfully mailed to the member email.';
        } catch (\Throwable $th) {
            $this->errMsg='Something went wrong while sending an email try again!';
        }
    }

    public function sendInvoiceToWhatsapp(){
        
        $data = DB::table('fees')
        ->join('users','users.id','fees.user_id')
        ->where('fees.invoice_url',$this->invoice_url)
        ->select('fees.amount','fees.invoice_url', 'fees.date','fees.expiry','fees.amount','fees.club_id','users.name','users.phone', 'users.email', 'users.image')
        ->first();
        $setting = DB::table('clubs')->where('id',$data->club_id)->first();
        try {
            $uploadedInvoicePath = public_path('pdf/'.$data->invoice_url.'.pdf');
            if (Storage::exists($uploadedInvoicePath)) {
                // The file exists
            } else {
                $pdf = PDF::loadView('invoice_pdf', ['clubSetting' => $setting, 'data' => $data]);
                $filename = $data->invoice_url.'.pdf';
                $pdf->save(public_path('pdf/' . $filename));
            }
        } catch (\Throwable $th) {
            $this->errMsg='Something went wrong while generating the PDF try again!';
            // Handle the error in some way, such as logging it or displaying a message to the user
        }

        try {
            $whatsAppApiData=[];
            $whatsAppApiData['whatsappAccessToken'] = $setting->whatsapp_access_token;
            $whatsAppApiData['instantId'] =  $setting->whatsapp_instant_id;
            $whatsAppApiData['filePaths'] = asset('pdf/'.$data->invoice_url.'.pdf');
            $whatsAppApiData['phone_no']  = $data->phone;
            $whatsAppApiData['user_name']  = $data->name;
            SentInvoiceToWhatsapp::dispatch($whatsAppApiData)->onQueue('invoice-sending-whatsapp');
            $this->successMsg = 'The invoice has been sent successfully to the member\'s WhatsApp number.';
        } catch (\Throwable $th) {
            $this->errMsg = 'Something went wrong while sending the invoice. Please try again later.';
        }
    }
}

