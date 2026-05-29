<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // identity
            ['key' => 'brand_name',    'value' => 'OBSEQUIUM',                                                  'group' => 'identity'],
            ['key' => 'brand_tagline', 'value' => 'Cabinet de Conseil en Management Qualité et Conformité',     'group' => 'identity'],
            ['key' => 'brand_slogan',  'value' => 'Pour votre conformité, pour votre performance',              'group' => 'identity'],
            ['key' => 'founded_year',  'value' => '2026',                                                       'group' => 'identity'],
            ['key' => 'rccm',          'value' => 'CI-ABJ-03-2026-B13-06180',                                   'group' => 'identity'],

            // contact
            ['key' => 'contact_email',         'value' => 'accueil@obsequium-ci.com',          'group' => 'contact'],
            ['key' => 'contact_email_manager', 'value' => 'ehounouwilem@obsequium-ci.com',     'group' => 'contact'],
            ['key' => 'contact_phone',         'value' => '+225 07 79 18 17 67',               'group' => 'contact'],
            ['key' => 'contact_phone_alt',     'value' => '+225 07 00 38 85 70',               'group' => 'contact'],
            ['key' => 'contact_address',       'value' => 'Cocody, Abidjan — Côte d’Ivoire',   'group' => 'contact'],
            ['key' => 'contact_postal',        'value' => '08 BP 2940 ABIDJAN 08',             'group' => 'contact'],
            ['key' => 'contact_hours',         'value' => 'Lun–Ven : 8h – 17h',                'group' => 'contact'],
            ['key' => 'linkedin_url',          'value' => '#',                                  'group' => 'contact'],

            // hero
            ['key' => 'hero_badge',       'value' => 'Cabinet de conseil en management QHSE — Côte d’Ivoire', 'group' => 'hero'],
            ['key' => 'hero_title',       'value' => 'Votre partenaire pour la certification ISO',            'group' => 'hero'],
            ['key' => 'hero_description', 'value' => 'OBSEQUIUM accompagne les organisations publiques et privées dans la mise en place et la certification de systèmes de management ISO 9001, 14001, 45001 et autres normes. Audit diagnostic offert.', 'group' => 'hero'],

            // stats (réalistes pour un cabinet créé en 2026)
            ['key' => 'stat_clients',      'value' => '5',    'group' => 'stats'], // organisations accompagnées
            ['key' => 'stat_formations',   'value' => '3',    'group' => 'stats'], // normes ISO maîtrisées
            ['key' => 'stat_years',        'value' => '6-12', 'group' => 'stats'], // durée typique en mois
            ['key' => 'stat_satisfaction', 'value' => '100%', 'group' => 'stats'], // diagnostic gratuit

            // labels associés
            ['key' => 'stat_clients_label',      'value' => 'Organisations accompagnées', 'group' => 'stats'],
            ['key' => 'stat_formations_label',   'value' => 'Normes ISO maîtrisées',      'group' => 'stats'],
            ['key' => 'stat_years_label',        'value' => 'Mois d’accompagnement',      'group' => 'stats'],
            ['key' => 'stat_satisfaction_label', 'value' => 'Audit diagnostic offert',    'group' => 'stats'],

            // about
            ['key' => 'about_intro',         'value' => 'OBSEQUIUM, qui signifie « conformité » en latin, est un cabinet de conseil spécialisé en management de la qualité et de la conformité, créé en 2026 en Côte d’Ivoire.', 'group' => 'about'],
            ['key' => 'about_description_1', 'value' => 'Nous accompagnons les organisations publiques et privées dans la mise en place, le pilotage et l’amélioration de systèmes de management conformes aux normes ISO internationales, avec une expertise particulière en Qualité, Santé, Sécurité et Environnement (QHSE).', 'group' => 'about'],
            ['key' => 'about_description_2', 'value' => 'Notre conviction est simple : la conformité ne doit pas être perçue comme une contrainte administrative, mais comme un véritable levier de performance durable, de maîtrise des risques et de crédibilité.', 'group' => 'about'],
            ['key' => 'about_description_3', 'value' => 'À travers nos missions d’accompagnement, d’audit, de conseil et de formation, nous aidons nos clients à transformer leurs exigences réglementaires et normatives en outils d’organisation, d’efficacité et de compétitivité.', 'group' => 'about'],
            ['key' => 'about_description_4', 'value' => 'Chez OBSEQUIUM, nous privilégions une approche rigoureuse, pragmatique et adaptée aux réalités opérationnelles de chaque structure. De l’évaluation initiale jusqu’à la certification, nous faisons le choix d’un accompagnement structuré, humain et orienté vers l’amélioration continue.', 'group' => 'about'],
            ['key' => 'manager_name',        'value' => 'M. EHOUNOU Wilem',                                          'group' => 'about'],
            ['key' => 'manager_role',        'value' => 'Gérant — OBSEQUIUM',                                        'group' => 'about'],

            // footer
            ['key' => 'footer_description', 'value' => 'Cabinet de conseil spécialisé en management de la qualité et de la conformité. Accompagnement intégral à la certification ISO 9001, 14001, 45001 et autres normes.', 'group' => 'footer'],
        ];

        foreach ($settings as $setting) {
            SiteSetting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
