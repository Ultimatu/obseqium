<?php

namespace App\Http\Controllers;

use App\Models\ProcessPhase;

class ProcessController extends Controller
{
    public function __invoke()
    {
        $phases = ProcessPhase::active()->ordered()->get();

        // Fallback si pas de phases en BDD
        if ($phases->isEmpty()) {
            $phases = collect([
                    (object) [
                        'order' => 1,
                    'title' => 'Audit Diagnostic',
                    'badge' => 'GRATUIT',
                    'description' => 'Évaluation de votre situation actuelle face aux exigences des normes. Identification des forces, faiblesses et opportunités.',
                    'highlights' => ['Évaluation gap initial', 'Rapport diagnostic complet', 'Recommandations priorisées'],
                ],
                    (object) [
                        'order' => 2,
                    'title' => 'Restitution, Cotation et Planning',
                    'description' => 'Présentation du rapport diagnostic et cotation précise de la mission.',
                    'highlights' => ['Cotation transparente', 'Planning sur-mesure'],
                ],
                    (object) [
                        'order' => 3,
                    'title' => 'Cadrage et Engagement',
                    'description' => 'Réunion de cadrage avec la direction et constitution du comité de pilotage.',
                    'highlights' => ['Engagement direction', 'Comité de pilotage'],
                ],
            ]);
        }

        return view('pages.process', compact('phases'));
    }
}
