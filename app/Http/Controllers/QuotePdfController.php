<?php

namespace App\Http\Controllers;

use App\Helpers\NumberToWords;
use App\Models\Quote;
use App\Models\SiteSetting;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class QuotePdfController extends Controller
{
    public function download(string $token): Response
    {
        $quote = Quote::with('items')->where('token', $token)->firstOrFail();
        $settings = SiteSetting::getAllCached();

        $logoPath = $settings->get('quote_logo')
            ? Storage::disk('public')->path($settings->get('quote_logo'))
            : public_path('logos/Logo-Obsequium Fond blanc.png');
        $signaturePath = $settings->get('quote_signature') ? Storage::disk('public')->path($settings->get('quote_signature')) : null;

        $logoBase64 = ($logoPath && file_exists($logoPath)) ? $this->toBase64($logoPath) : null;
        $signatureBase64 = ($signaturePath && file_exists($signaturePath)) ? $this->toBase64($signaturePath) : null;

        $pdf = Pdf::loadView('pdfs.quote', [
            'quote' => $quote,
            'settings' => $settings,
            'logoBase64' => $logoBase64,
            'signatureBase64' => $signatureBase64,
            'totalInWords' => NumberToWords::convert((float) $quote->total),
            'currency' => $settings->get('quote_currency', 'XOF'),
        ])->setPaper('a4');

        return $pdf->download("devis-{$quote->reference}.pdf");
    }

    private function toBase64(string $path): string
    {
        $mime = mime_content_type($path);
        $data = base64_encode(file_get_contents($path));

        return "data:{$mime};base64,{$data}";
    }
}
