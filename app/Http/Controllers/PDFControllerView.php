<?php
namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PDFControllerView extends Controller
{
    public function show(Request $request)
    {
        $filename = $request->query('file');
        if (strlen($filename) < 40){
            abort(404, 'File not found or too many.');
        }
        $ticket = Ticket::where('qrcode_url' , 'like', $filename .'%')->get();
        if (empty($ticket) || $ticket->count() != 1) {
            abort(404, 'File not found or too many.');
        }
        return view('pdf.ticket')->with('ticket', $ticket[0]);
    }
}
//211786p556yDgEipoARxjEgmBaBhIhm1GNZaZfcBWBUoKO
