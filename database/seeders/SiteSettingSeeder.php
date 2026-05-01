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
            ['key' => 'brand_name',    'value' => 'Cabinet QHSE',          'group' => 'identity'],
            ['key' => 'brand_tagline', 'value' => 'Conseil & Formation',    'group' => 'identity'],
            ['key' => 'founded_year',  'value' => '2010',                   'group' => 'identity'],

            // contact
            ['key' => 'contact_email',   'value' => 'contact@cabinet-qhse.fr', 'group' => 'contact'],
            ['key' => 'contact_phone',   'value' => '+33 1 23 45 67 89',        'group' => 'contact'],
            ['key' => 'contact_address', 'value' => '',                         'group' => 'contact'],
            ['key' => 'contact_hours',   'value' => 'Lun–Ven : 9h – 18h',      'group' => 'contact'],
            ['key' => 'linkedin_url',    'value' => '#',                        'group' => 'contact'],

            // hero
            ['key' => 'hero_badge',       'value' => 'Cabinet expert en QHSE depuis 2010',      'group' => 'hero'],
            ['key' => 'hero_title',       'value' => 'Votre partenaire QHSE de confiance',      'group' => 'hero'],
            ['key' => 'hero_description', 'value' => "Conseil, audit, formation et accompagnement en Qualité, Hygiène, Sécurité et Environnement. Nous vous aidons à atteindre vos objectifs de conformité et d'amélioration continue.", 'group' => 'hero'],

            // stats
            ['key' => 'stat_clients',      'value' => '150+', 'group' => 'stats'],
            ['key' => 'stat_formations',   'value' => '500+', 'group' => 'stats'],
            ['key' => 'stat_years',        'value' => '15+',  'group' => 'stats'],
            ['key' => 'stat_satisfaction', 'value' => '98%',  'group' => 'stats'],

            // about
            ['key' => 'about_intro',         'value' => 'Depuis plus de 15 ans, nous accompagnons les entreprises dans leur démarche QHSE avec expertise, proximité et pragmatisme.', 'group' => 'about'],
            ['key' => 'about_description_1', 'value' => "Notre cabinet est spécialisé dans le conseil, l'audit et la formation en matière de Qualité, Hygiène, Sécurité et Environnement. Nous intervenons auprès des PME et grandes entreprises de tous secteurs d'activité.", 'group' => 'about'],
            ['key' => 'about_description_2', 'value' => "Notre approche est résolument pragmatique : nous construisons avec vous des solutions adaptées à votre contexte, votre culture d'entreprise et vos contraintes opérationnelles.", 'group' => 'about'],
            ['key' => 'about_description_3', 'value' => "Au-delà de la conformité réglementaire, nous vous aidons à transformer la démarche QHSE en véritable levier de performance et de différenciation.", 'group' => 'about'],

            // footer
            ['key' => 'footer_description', 'value' => "Votre partenaire expert en Qualité, Hygiène, Sécurité et Environnement pour accompagner votre mise en conformité et l'amélioration continue.", 'group' => 'footer'],
        ];

        foreach ($settings as $setting) {
            SiteSetting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
