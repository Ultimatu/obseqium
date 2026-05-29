<?php

namespace Database\Seeders;

use App\Models\HeroSlide;
use Illuminate\Database\Seeder;

class HeroSlideSeeder extends Seeder
{
    public function run(): void
    {
        HeroSlide::truncate();

        $slides = [
            [
                'badge' => 'Audit diagnostic OFFERT',
                'title' => 'Votre certification ISO commence par un diagnostic gratuit',
                'description' => "OBSEQUIUM évalue gratuitement votre situation face aux exigences ISO 9001, 14001, 45001. Vous repartez avec un rapport diagnostic, des recommandations concrètes et un plan d'action priorisé.",
                'cta_primary_label' => 'Demander mon diagnostic gratuit',
                'cta_primary_href' => '/devis',
                'cta_secondary_label' => 'Découvrir notre processus',
                'cta_secondary_href' => '/notre-processus',
                'gradient' => 'from-brand-950 via-brand-800 to-brand-600',
                'image' => 'hero/qhsee.png',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'badge' => 'Accompagnement intégral ISO',
                'title' => 'Du diagnostic à la certification, un accompagnement structuré',
                'description' => "Nous pilotons l'ensemble de votre projet de certification ISO 9001, 14001 ou 45001 en 9 phases progressives sur 6 à 12 mois — méthodologie, formation, documentation, audits internes, préparation à l'audit de certification.",
                'cta_primary_label' => 'Nos offres ISO',
                'cta_primary_href' => '/services',
                'cta_secondary_label' => 'Prendre rendez-vous',
                'cta_secondary_href' => '/rendez-vous',
                'gradient' => 'from-brand-950 via-brand-900 to-brand-700',
                'image' => 'hero/audit.jpg',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'badge' => 'Pour votre conformité, pour votre performance',
                'title' => 'La conformité comme levier de performance durable',
                'description' => "OBSEQUIUM transforme vos exigences réglementaires et normatives en outils d'organisation, d'efficacité et de compétitivité. CHU Treichville (certifié ISO 9001), KAZAM (triple certification 9001+14001+45001), METEA, RICHKOFF, ANAGED nous font confiance.",
                'cta_primary_label' => 'Voir nos références',
                'cta_primary_href' => '/references',
                'cta_secondary_label' => 'Nos formations',
                'cta_secondary_href' => '/formations',
                'gradient' => 'from-brand-900 via-brand-700 to-emerald-600',
                'image' => 'hero/contrats-de-formation.jpg',
                'order' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($slides as $slide) {
            HeroSlide::create($slide);
        }
    }
}
