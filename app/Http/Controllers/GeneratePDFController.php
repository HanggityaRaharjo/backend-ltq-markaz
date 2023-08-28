<?php

namespace App\Http\Controllers;

use App\Models\TataUsaha\DetailPembelian;
use App\Models\TataUsaha\PembayaranBarang;
use PDF;
use Illuminate\Http\Request;

class GeneratePDFController extends Controller
{
    public function generatePDF()
    {
        $data = PembayaranBarang::with('konsumen', 'detail_pembelian')->first();
        $pdf = PDF::loadView('pdf.invoice', $data);
        $pdfBinary = $pdf->output();

        return response()->json([
            'success' => true,
            'message' => 'PDF generated successfully',
            'pdf' => base64_encode($pdfBinary)
        ]);
    }
}
