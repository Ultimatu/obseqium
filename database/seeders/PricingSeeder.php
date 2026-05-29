<?php

namespace Database\Seeders;

use App\Models\Pricing;
use Illuminate\Database\Seeder;

class PricingSeeder extends Seeder
{
    public function run(): void
    {
        Pricing::updateOrCreate(
            ['key' => 'default'],
            [
                'hero_title' => 'Tarifs & modalités commerciales',
                'hero_description' => 'Une tarification transparente, établie après le diagnostic gratuit, avec des modalités de paiement flexibles adaptées à votre capacité.',
                'pricing_principle_title' => 'Tarification post-diagnostic',
                'pricing_principle_content' => "<strong>L'audit diagnostic initial est entièrement GRATUIT.</strong> C'est sur la base des résultats de ce diagnostic que nous élaborons une cotation précise et adaptée à votre contexte. Nous ne pratiquons pas de tarif forfaitaire à l'aveugle. Cette approche garantit une <strong>cotation juste</strong>, alignée sur la réalité de votre organisation et des écarts effectivement constatés.",
                'criteria' => [
                    ['title' => 'Taille de l\'organisation', 'description' => 'Nombre de salariés et complexité organisationnelle.'],
                    ['title' => 'Nombre de normes ISO', 'description' => 'Mission mono-norme, double ou triple (9001+14001+45001).'],
                    ['title' => 'Gap identifié au diagnostic', 'description' => 'Niveau d\'écart : fort, moyen ou faible.'],
                    ['title' => 'Complexité de l\'activité', 'description' => 'Nature des processus et exigences sectorielles spécifiques.'],
                    ['title' => 'Situation géographique', 'description' => 'Modalités d\'intervention : présentiel, distanciel ou hybride.'],
                    ['title' => 'Durée et intensité', 'description' => 'Durée de la mission et intensité du support requis.'],
                    ['title' => 'Journées-consultations', 'description' => 'Nombre de journées-consultations nécessaires.'],
                ],
                'example_total_amount' => 6000000,
                'example_duration_months' => 6,
                'payment_terms' => "Les modalités de paiement sont <strong>flexibles et définies au cas par cas</strong> lors de la signature du contrat. Nous proposons généralement un échelonnement mensuel du prix de l'accompagnement, adapté à votre capacité de paiement.<br><br><strong>Délai :</strong> Paiement mensuel à terme échu (à la fin de chaque mois de service). Les modalités sont précisées dans le contrat d'accompagnement.",
                'includes' => [
                    'Audit diagnostic complet et rapport' => '',
                    'Accompagnement sur site et à distance' => '',
                    'Formations intégrées (groupe et individualisées)' => '',
                    'Élaboration de tous les documents' => 'Politiques, procédures, enregistrements',
                    'Support pour la mise en place des processus' => '',
                    'Audit interne préparatoire' => '',
                    'Aide à la sélection d\'un organisme de certification' => '',
                    'Dossier de certification complètement préparé' => '',
                ],
                'excludes' => [
                    'Frais de certification' => 'À charge du client',
                    'Investissements matériels ou logistiques' => '',
                    'Services externes' => 'Légal, technique spécialisé',
                ],
                'process_steps' => [
                    ['title' => 'Contact', 'description' => 'Discussion initiale de vos besoins'],
                    ['title' => 'Diagnostic', 'description' => 'Audit gratuit de votre situation'],
                    ['title' => 'Restitution', 'description' => 'Rapport et devis personnalisé'],
                    ['title' => 'Signature', 'description' => 'Contrat d\'accompagnement'],
                    ['title' => 'Lancement', 'description' => 'Démarrage de la mission'],
                ],
                'offer_title' => 'Offre de lancement',
                'offer_content' => 'Dans le cadre du lancement du cabinet OBSEQUIUM, nous proposons des <strong>remises d\'accueil</strong> sur les premières missions. Cette variable est définie au cas par cas en fonction de votre contexte.',
                'is_active' => true,
            ]
        );
    }
}
