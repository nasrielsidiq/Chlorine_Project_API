<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PDFGenerateController extends Controller
{
    public function get(){
        $certificate = Certificate::where('internship_id', Auth::guard('api')->user()->profile->internship->id)->first();


        $pdf = Pdf::loadView('pdf_view', ['certificate' => $certificate]);

        // Set ukuran kertas A4 lanskap
        $pdf->setPaper('a4', 'landscape');

        // Kembalikan respons PDF
        return $pdf->stream('sertifikat.pdf');
    }
}
