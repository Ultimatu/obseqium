<?php

namespace Database\Seeders;

use App\Models\Reference;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ReferenceSeeder extends Seeder
{
    private function copyImageToStorage(string $sourcePath, string $destinationDir): ?string
    {
        $fullSource = public_path($sourcePath);
        if (! file_exists($fullSource)) {
            return null;
        }

        $filename = basename($sourcePath);
        $destinationPath = $destinationDir.'/'.$filename;

        Storage::disk('public')->makeDirectory($destinationDir);
        Storage::disk('public')->put($destinationPath, file_get_contents($fullSource));

        return $destinationPath;
    }

    public function run(): void
    {
        $references = [
            [
                'title' => 'Certification ISO 9001 du CHU de Treichville',
                'slug' => 'chu-treichville-iso-9001',
                'client_name' => 'CHU de Treichville',
                'sector' => 'Santé — Hôpital universitaire',
                'challenge' => "Structurer le système de management de la qualité d'un centre hospitalier universitaire et obtenir la certification ISO 9001 dans un environnement complexe et multidisciplinaire.",
                'solution' => "Accompagnement intégral à la certification ISO 9001 : diagnostic, cartographie des processus, formation des équipes, mise en place du système documentaire, audits internes et préparation à l'audit de certification.",
                'results' => 'Système de management qualité opérationnel et certifié ISO 9001. Le CHU de Treichville constitue notre première référence certifiée et démontre notre capacité à intervenir dans le secteur public et hospitalier.',
                'key_figures' => [
                    'Norme' => 'ISO 9001',
                    'Statut' => 'Certifié',
                    'Secteur' => 'Santé',
                ],
                'is_featured' => true,
                'show_client_name' => true,
                'order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Triple accompagnement ISO 9001 + 14001 + 45001 — Entreprise KAZAM',
                'slug' => 'kazam-triple-iso-9001-14001-45001',
                'client_name' => 'Entreprise KAZAM',
                'sector' => 'Hydraulique & BTP',
                'challenge' => "Mettre en place simultanément trois systèmes de management ISO (qualité, environnement, santé-sécurité) pour répondre aux exigences d'un secteur où les enjeux QHSE sont critiques.",
                'solution' => 'Accompagnement multi-normes intégré : un seul cabinet, un seul comité de pilotage, des processus harmonisés. Mutualisation des audits internes, de la documentation et des formations pour optimiser le projet.',
                'results' => 'Mission en cours. KAZAM est notre premier client en tant que cabinet OBSEQUIUM et démontre notre capacité à gérer des accompagnements multi-normes complexes (système de management intégré QHSE).',
                'key_figures' => [
                    'Normes' => '9001 + 14001 + 45001',
                    'Statut' => 'En cours',
                    'Secteur' => 'Hydraulique / BTP',
                ],
                'is_featured' => true,
                'show_client_name' => true,
                'order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Accompagnement ISO 9001 — METEA GROUPE SA',
                'slug' => 'metea-groupe-iso-9001',
                'client_name' => 'METEA GROUPE SA',
                'sector' => 'Maritime',
                'challenge' => "Structurer le système qualité d'un groupe opérant dans le secteur maritime ivoirien, avec des exigences clients et réglementaires fortes.",
                'solution' => 'Accompagnement complet à la mise en place du système de management qualité ISO 9001 adapté aux spécificités du secteur maritime.',
                'results' => 'Système de management qualité opérationnel — accompagnement réalisé.',
                'key_figures' => [
                    'Norme' => 'ISO 9001',
                    'Statut' => 'Accompagné',
                    'Secteur' => 'Maritime',
                ],
                'is_featured' => true,
                'show_client_name' => true,
                'order' => 3,
                'is_active' => true,
            ],
            [
                'title' => 'Accompagnement ISO 9001 — RICHKOFF & AFRICA STEAM',
                'slug' => 'richkoff-africa-steam-iso-9001',
                'client_name' => 'RICHKOFF / AFRICA STEAM',
                'sector' => 'Services — Parfumerie & Nettoyage',
                'challenge' => "Mettre en place un système qualité ISO 9001 pour deux activités de service (parfumerie et nettoyage) avec des standards d'exigence élevés.",
                'solution' => "Accompagnement personnalisé prenant en compte les spécificités de chaque activité, formation des équipes et mise en place d'indicateurs de pilotage adaptés.",
                'results' => 'Système qualité déployé et opérationnel sur les deux activités.',
                'key_figures' => [
                    'Norme' => 'ISO 9001',
                    'Statut' => 'Accompagné',
                    'Secteur' => 'Services',
                ],
                'is_featured' => true,
                'show_client_name' => true,
                'order' => 4,
                'is_active' => true,
            ],
            [
                'title' => 'Accompagnement ISO 9001 — ANAGED',
                'slug' => 'anaged-iso-9001',
                'client_name' => 'ANAGED',
                'sector' => 'Gestion des déchets',
                'challenge' => "Structurer le système qualité d'un acteur public-privé de la gestion des déchets en Côte d'Ivoire, dans un contexte d'exigences environnementales et de service public croissantes.",
                'solution' => 'Accompagnement à la mise en place du système ISO 9001, avec une attention particulière à la maîtrise opérationnelle et à la satisfaction des bénéficiaires.',
                'results' => "Mission d'accompagnement en cours.",
                'key_figures' => [
                    'Norme' => 'ISO 9001',
                    'Statut' => 'En cours',
                    'Secteur' => 'Gestion des déchets',
                ],
                'is_featured' => true,
                'show_client_name' => true,
                'order' => 5,
                'is_active' => true,
            ],
        ];

        // Logo mapping
        $logos = [
            'chu-treichville-iso-9001' => 'assets/images/chu_treichville.png',
            'kazam-triple-iso-9001-14001-45001' => 'assets/images/entreprise-kazam.png',
            'metea-groupe-iso-9001' => 'assets/images/meta-group-sa.png',
            'richkoff-africa-steam-iso-9001' => 'assets/images/r-a-s.png',
            'anaged-iso-9001' => 'assets/images/anaged.png',
        ];

        foreach ($references as $data) {
            $slug = $data['slug'];

            // Copy logo if exists
            if (isset($logos[$slug])) {
                $logoPath = $this->copyImageToStorage($logos[$slug], 'references');
                if ($logoPath) {
                    $data['client_logo'] = $logoPath;
                }
            }

            Reference::updateOrCreate(['slug' => $slug], $data);
        }
    }
}
