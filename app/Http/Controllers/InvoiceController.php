<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fees;
use App\Models\User;
use App\Models\Club;
use Illuminate\Support\Facades\DB;
use Dompdf\Dompdf;
use Dompdf\Options;

use App\Jobs\SentInvoiceToWhatsapp;
use App\Jobs\MailInvoice;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class InvoiceController extends Controller
{
    public function show($invoice_url)
    {
        $data = Fees::join('users', 'users.id', 'fees.user_id')
            ->where('fees.invoice_url', $invoice_url)
            ->select('fees.amount', 'fees.invoice_url', 'fees.date', 'fees.expiry', 'fees.amount', 'fees.club_id', 'users.name', 'users.phone', 'users.email', 'users.image')
            ->first();
        $setting = Club::find($data->club_id);
        try {
            $pdfPath = public_path('pdf/' . $data->invoice_url . '.pdf');
            if (!file_exists($pdfPath)) {
                $dompdf = new Dompdf();
                $dompdf->loadHtml(view('invoice_pdf', ['clubSetting' => $setting, 'data' => $data])->render());
                $dompdf->setPaper('A4', 'portrait');
                $dompdf->render();          
                // file_put_contents($pdfPath, $dompdf->output());
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Failed to generate the PDF. Error: ' . $th->getMessage());
        }

        return view('invoice.show', ['clubSetting' => $setting, 'data' => $data]);
    }

    public function generatePDF($invoice_url)
    {
        $data = Fees::join('users', 'users.id', 'fees.user_id')
            ->where('fees.invoice_url', $invoice_url)
            ->select('fees.amount', 'fees.invoice_url', 'fees.date', 'fees.expiry', 'fees.amount', 'fees.club_id', 'users.name', 'users.phone', 'users.email', 'users.image')
            ->first();
        $setting = Club::find($data->club_id);

        try {
            $pdfPath = public_path('pdf/' . $data->invoice_url . '.pdf');
            if (!file_exists($pdfPath)) {
                $dompdf = new Dompdf();
                $dompdf->loadHtml(view('invoice_pdf', ['clubSetting' => $setting, 'data' => $data])->render());
                $dompdf->setPaper('A4', 'portrait');
                $dompdf->render();
                // file_put_contents($pdfPath, $dompdf->output());
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Failed to generate the PDF. Error: ' . $th->getMessage());
        }

        try {
            $emailData = [
                'date' => $data->date,
                'name' => $data->name,
                'email' => $data->email,
                'uploadedInvoicePath' => $pdfPath
            ];
            MailInvoice::dispatch($emailData)->onQueue('invoice-sending-mail');
            return redirect()->back()->with('success', 'Invoice has been successfully mailed to the member email.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Failed to send email. Error: ' . $th->getMessage());
        }
    }

    public function sendInvoiceToWhatsapp($invoice_url)
    {
        $data = Fees::join('users', 'users.id', 'fees.user_id')
            ->where('fees.invoice_url', $invoice_url)
            ->select('fees.amount', 'fees.invoice_url', 'fees.date', 'fees.expiry', 'fees.amount', 'fees.club_id', 'users.name', 'users.phone', 'users.email', 'users.image')
            ->first();
        $setting = Club::find($data->club_id);

        try {
            $pdfPath = public_path('pdf/' . $data->invoice_url . '.pdf');
            if (!file_exists($pdfPath)) {
                $dompdf = new Dompdf();
                $dompdf->loadHtml(view('invoice_pdf', ['clubSetting' => $setting, 'data' => $data])->render());
                $dompdf->setPaper('A4', 'portrait');
                $dompdf->render();
                file_put_contents($pdfPath, $dompdf->output());
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Failed to generate the PDF. Error: ' . $th->getMessage());
        }

        try {
            $whatsAppApiData = [
                'whatsappAccessToken' => $setting->whatsapp_access_token,
                'instantId' =>  $setting->whatsapp_instant_id,
                'filePaths' => asset('pdf/' . $data->invoice_url . '.pdf'),
                'phone_no'  => $data->phone,
                'user_name'  => $data->name
            ];
            SentInvoiceToWhatsapp::dispatch($whatsAppApiData)->onQueue('invoice-sending-whatsapp');
            return redirect()->back()->with('success', 'The invoice has been sent successfully to the member\'s WhatsApp number.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Failed to send invoice via WhatsApp. Error: ' . $th->getMessage());
        }
    }
}
