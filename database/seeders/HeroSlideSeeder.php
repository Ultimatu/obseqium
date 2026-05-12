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
                'badge' => 'Cabinet expert en QHSE',
                'title' => 'Votre partenaire QHSE de confiance',
                'description' => 'Conseil, formation et accompagnement sur mesure pour répondre à tous vos enjeux qualité, hygiène, sécurité et environnement.',
                'cta_primary_label' => 'Demander un devis gratuit',
                'cta_primary_href' => '/devis',
                'cta_secondary_label' => 'Découvrir nos services',
                'cta_secondary_href' => '/services',
                'gradient' => 'from-brand-950 via-brand-800 to-brand-600',
                'image' => 'hero/qhsee.png',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'badge' => 'Audit & Conseil',
                'title' => 'Mise en conformité réglementaire QHSE',
                'description' => "Nous analysons vos pratiques, identifions les écarts et co-construisons vos plans d'action pour une conformité durable et sans surprise.",
                'cta_primary_label' => "Nos services d'audit",
                'cta_primary_href' => '/services?type=audit',
                'cta_secondary_label' => 'Prendre rendez-vous',
                'cta_secondary_href' => '/rendez-vous',
                'gradient' => 'from-brand-950 via-brand-900 to-brand-700',
                'image' => 'hero/audit.jpg',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'badge' => 'Formation certifiante',
                'title' => 'Formez vos équipes aux standards QHSE',
                'description' => 'Des formations sur mesure, dispensées par des experts terrain, pour monter en compétences et obtenir les certifications qui font la différence.',
                'cta_primary_label' => 'Voir le catalogue',
                'cta_primary_href' => '/formations',
                'cta_secondary_label' => 'Calendrier des sessions',
                'cta_secondary_href' => '/formations/calendrier',
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
