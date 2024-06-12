<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use Illuminate\Http\Request;

class PDFController extends Controller
{
    public function generatePDF()
    {
        $data = ['title' => 'domPDF in Laravel 10'];
        $pdf = Purchase::loadView('pdf.document', $data);
        return $pdf->download('document.pdf');
    }
}
