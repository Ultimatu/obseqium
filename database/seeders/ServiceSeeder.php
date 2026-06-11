<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ServiceSeeder extends Seeder
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
        $methodology = [
            ['title' => 'Audit diagnostic (GRATUIT)', 'description' => 'Évaluation de votre situation actuelle face aux exigences de la norme. Identification des forces, faiblesses et opportunités. Rapport diagnostic avec recommandations.'],
            ['title' => 'Restitution, cotation et planning', 'description' => 'Présentation du rapport diagnostic, cotation précise de la mission selon les écarts identifiés et établissement du planning d’accompagnement personnalisé.'],
            ['title' => 'Cadrage et engagement', 'description' => 'Réunion de cadrage avec la direction, démonstration de l’engagement de la direction et constitution du comité de pilotage.'],
            ['title' => 'Analyse contextuelle', 'description' => 'Analyse du contexte interne et externe, identification des parties intéressées, évaluation des enjeux et risques.'],
            ['title' => 'Définition de la stratégie', 'description' => 'Élaboration des objectifs liés aux enjeux stratégiques, définition de la politique et création de la cartographie des processus.'],
            ['title' => 'Structuration du système', 'description' => 'Formalisation des responsabilités (pilotes de processus), fiches d’identité, procédures de travail, enregistrements et indicateurs.'],
            ['title' => 'Déploiement et formation', 'description' => 'Formation du personnel sur la norme, l’approche processus, la gestion des risques. Mise en place de la veille réglementaire et enquêtes de satisfaction.'],
            ['title' => 'Audits internes et revues', 'description' => 'Formation et accompagnement des auditeurs internes, réalisation des audits internes, revues de processus et revue de direction.'],
            ['title' => 'Préparation à la certification', 'description' => 'Réunion de fin de mission, aide à l’identification d’un organisme de certification approprié, préparation du dossier complet pour l’audit de certification.'],
        ];

        $services = [
            // ── 3 Offres principales ─────────────────────────────────────
            [
                'title' => 'Accompagnement ISO 9001 - Management de la Qualité',
                'slug' => 'accompagnement-iso-9001',
                'icon' => null,
                'type' => 'qhse',
                'order' => 1,
                'description' => 'ISO 9001 établit les exigences pour un système de management de la qualité. Nous vous accompagnons de la phase de diagnostic jusqu’à la préparation de l’audit de certification, sur 6 à 12 mois.',
                'content' => '<p>La norme <strong>ISO 9001</strong> aide les organisations à améliorer la satisfaction de leurs clients, à augmenter leur efficacité opérationnelle et à gérer les risques. Notre accompagnement intégral couvre toutes les étapes de votre démarche qualité.</p><h3>Inclus dans l’offre</h3><ul><li>Audit diagnostic <strong>GRATUIT</strong></li><li>Accompagnement complet sur 6 à 12 mois</li><li>Formations intégrées : norme, approche processus, gestion des risques</li><li>Documentation complète : politique qualité, procédures, enregistrements</li><li>Audit interne préparatoire</li><li>Support pour la sélection d’un organisme certificateur</li></ul><h3>Pour qui ?</h3><p>Toute organisation publique ou privée souhaitant structurer sa démarche qualité, améliorer sa performance opérationnelle et obtenir une certification reconnue internationalement.</p>',
                'methodology' => $methodology,
                'deliverables' => [
                    'Rapport diagnostic initial gratuit',
                    'Politique et objectifs qualité',
                    'Cartographie des processus',
                    'Manuel qualité et procédures',
                    'Indicateurs de pilotage',
                    'Formation des auditeurs internes',
                    'Audit interne préparatoire',
                    'Dossier complet pour l’audit de certification',
                ],
                'meta_title' => 'Accompagnement ISO 9001 - OBSEQUIUM Côte d’Ivoire',
                'meta_description' => 'Cabinet OBSEQUIUM : accompagnement intégral à la certification ISO 9001 en Côte d’Ivoire. Audit diagnostic gratuit, 6 à 12 mois, formations incluses.',
                'is_active' => true,
            ],
            [
                'title' => 'Accompagnement ISO 14001 - Management Environnemental',
                'slug' => 'accompagnement-iso-14001',
                'icon' => null,
                'type' => 'qhse',
                'order' => 2,
                'description' => 'ISO 14001 fournit un cadre pour minimiser les impacts environnementaux négatifs, améliorer la conformité réglementaire et renforcer la responsabilité sociétale. Accompagnement complet incluant le Plan de Gestion Environnementale et Sociale (PGES).',
                'content' => '<p>La norme <strong>ISO 14001</strong> permet de structurer votre démarche environnementale, de maîtriser vos impacts et de répondre aux exigences réglementaires de plus en plus strictes en Côte d’Ivoire et à l’international.</p><h3>Inclus dans l’offre</h3><ul><li>Audit diagnostic <strong>GRATUIT</strong></li><li>Accompagnement complet sur 6 à 12 mois</li><li>Formations intégrées : normes environnementales, élaboration d’un plan environnemental, conformité réglementaire</li><li>Plan de Gestion Environnementale et Sociale (<strong>PGES</strong>)</li><li>Audit interne préparatoire</li><li>Support pour la sélection d’un organisme certificateur</li></ul>',
                'methodology' => $methodology,
                'deliverables' => [
                    'Rapport diagnostic initial gratuit',
                    'Analyse environnementale initiale',
                    'Politique et objectifs environnementaux',
                    'Plan de Gestion Environnementale et Sociale (PGES)',
                    'Veille réglementaire environnementale',
                    'Procédures de maîtrise opérationnelle',
                    'Audit interne préparatoire',
                    'Dossier complet pour l’audit de certification',
                ],
                'meta_title' => 'Accompagnement ISO 14001 & PGES - OBSEQUIUM',
                'meta_description' => 'Mise en place de votre système de management environnemental ISO 14001 et PGES. Cabinet OBSEQUIUM, Abidjan.',
                'is_active' => true,
            ],
            [
                'title' => 'Accompagnement ISO 45001 - Santé & Sécurité au Travail',
                'slug' => 'accompagnement-iso-45001',
                'icon' => null,
                'type' => 'qhse',
                'order' => 3,
                'description' => 'ISO 45001 établit un cadre pour gérer les risques et opportunités liés à la sécurité et la santé au travail. Elle aide à créer des lieux de travail plus sûrs et plus sains, et à réduire les accidents.',
                'content' => '<p>La norme <strong>ISO 45001</strong> remplace l’OHSAS 18001 et offre un cadre internationalement reconnu pour la prévention des risques professionnels. Nous vous aidons à construire une véritable culture de sécurité.</p><h3>Inclus dans l’offre</h3><ul><li>Audit diagnostic <strong>GRATUIT</strong></li><li>Accompagnement complet sur 6 à 12 mois</li><li>Formations intégrées : norme QHSE, évaluation des risques, culture de sécurité</li><li>Évaluation des risques QHSE</li><li>Audit interne préparatoire</li><li>Support pour la sélection d’un organisme certificateur</li></ul>',
                'methodology' => $methodology,
                'deliverables' => [
                    'Rapport diagnostic initial gratuit',
                    'Évaluation des risques santé & sécurité',
                    'Politique et objectifs SST',
                    'Procédures et instructions SST',
                    'Plan de prévention',
                    'Programme de formation et sensibilisation',
                    'Audit interne préparatoire',
                    'Dossier complet pour l’audit de certification',
                ],
                'meta_title' => 'Accompagnement ISO 45001 - OBSEQUIUM',
                'meta_description' => 'Système de management de la santé et sécurité au travail ISO 45001. Cabinet OBSEQUIUM, Abidjan.',
                'is_active' => true,
            ],

            // ── Offres complémentaires ───────────────────────────────────
            [
                'title' => 'Accompagnement ISO 22000 - Sécurité des Denrées Alimentaires',
                'slug' => 'accompagnement-iso-22000',
                'icon' => null,
                'type' => 'qhse',
                'order' => 4,
                'description' => 'Mise en place d’un système de management de la sécurité des denrées alimentaires conforme à ISO 22000, intégrant les principes HACCP et les exigences de la chaîne alimentaire.',
                'content' => '<p>ISO 22000 s’adresse à toute organisation de la chaîne alimentaire - production, transformation, distribution, restauration. Elle intègre les principes HACCP dans une démarche structurée de management.</p>',
                'methodology' => $methodology,
                'deliverables' => [
                    'Rapport diagnostic initial gratuit',
                    'Analyse des dangers (HACCP)',
                    'Plan PRP / PRPo / CCP',
                    'Procédures de traçabilité et rappel',
                    'Programme de formation hygiène',
                    'Audit interne préparatoire',
                ],
                'is_active' => true,
            ],
            [
                'title' => 'Accompagnement ISO 27001 - Sécurité de l’Information',
                'slug' => 'accompagnement-iso-27001',
                'icon' => null,
                'type' => 'qhse',
                'order' => 5,
                'description' => 'Mise en place d’un système de management de la sécurité de l’information (SMSI) conforme à ISO 27001 pour protéger vos données et celles de vos clients.',
                'content' => '<p>ISO 27001 fournit un cadre rigoureux pour identifier, évaluer et maîtriser les risques liés à la sécurité de l’information. Indispensable pour les organisations manipulant des données sensibles.</p>',
                'methodology' => $methodology,
                'deliverables' => [
                    'Rapport diagnostic initial gratuit',
                    'Analyse des risques (méthode adaptée)',
                    'Politique de sécurité de l’information',
                    'Déclaration d’applicabilité (SoA)',
                    'Procédures et plans de continuité',
                    'Audit interne préparatoire',
                ],
                'is_active' => true,
            ],

            // ── Audit & Formation transverses ───────────────────────────
            [
                'title' => 'Audit diagnostic ISO - GRATUIT',
                'slug' => 'audit-diagnostic-iso-gratuit',
                'icon' => null,
                'type' => 'audit',
                'order' => 6,
                'description' => 'L’audit diagnostic est la 1ère phase de tout accompagnement OBSEQUIUM. Il est entièrement gratuit et sans engagement. Vous repartez avec un rapport et un plan d’action priorisé.',
                'content' => '<p>Notre <strong>audit diagnostic est gratuit</strong> : c’est notre conviction qu’une bonne mission commence par une évaluation honnête de la situation. Aucun engagement de votre part à l’issue de cette phase.</p><h3>Ce que vous obtenez</h3><ul><li>Évaluation de votre maturité face à la norme ciblée (ISO 9001, 14001, 45001, etc.)</li><li>Cartographie des forces et faiblesses</li><li>Identification des écarts (gaps)</li><li>Recommandations concrètes priorisées</li><li>Estimation de la durée et de la charge de travail</li></ul><p>Sur la base de ce diagnostic, nous établissons une cotation précise et un planning d’accompagnement adapté à votre contexte.</p>',
                'deliverables' => [
                    'Rapport diagnostic complet',
                    'Cartographie des écarts',
                    'Plan d’action priorisé',
                    'Estimation de mission personnalisée',
                ],
                'is_active' => true,
            ],
            [
                'title' => 'Formations QHSE & approche processus',
                'slug' => 'formations-qhse-approche-processus',
                'icon' => null,
                'type' => 'training',
                'order' => 7,
                'description' => 'Programmes de formation sur les normes ISO, l’approche processus, la gestion des risques, l’audit interne et la culture qualité-sécurité - en présentiel à Abidjan ou à distance.',
                'content' => '<p>Nos formations sont systématiquement <strong>intégrées</strong> dans nos missions d’accompagnement, mais aussi disponibles en sessions inter ou intra-entreprise.</p><h3>Thématiques couvertes</h3><ul><li>Sensibilisation aux normes ISO 9001, 14001, 45001, 22000, 27001</li><li>Approche processus & cartographie</li><li>Gestion des risques (méthodes et outils)</li><li>Formation auditeurs internes</li><li>Veille réglementaire</li><li>Culture qualité et culture sécurité</li></ul>',
                'deliverables' => [
                    'Supports pédagogiques personnalisés',
                    'Études de cas adaptées à votre secteur',
                    'QCM de validation',
                    'Attestation de formation',
                ],
                'is_active' => true,
            ],
        ];

        // Image mapping
        $images = [
            'accompagnement-iso-9001' => 'assets/images/acomp-iso-9001-manag-quali.jpg',
            'accompagnement-iso-14001' => 'assets/images/acomp-bilan-carbone.jpg',
            'accompagnement-iso-45001' => 'assets/images/prevention-risque.jpg',
            'accompagnement-iso-22000' => 'assets/images/haccp-hygene-alimentaire.jpg',
            'accompagnement-iso-27001' => 'assets/images/service-conseil-management.jpg',
            'audit-diagnostic-iso-gratuit' => 'assets/images/audit.png',
            'formations-qhse-approche-processus' => 'assets/images/contrats-de-formation.jpg',
        ];

        foreach ($services as $data) {
            $slug = $data['slug'];

            // Copy image if exists
            if (isset($images[$slug])) {
                $imagePath = $this->copyImageToStorage($images[$slug], 'services');
                if ($imagePath) {
                    $data['image'] = $imagePath;
                }
            }

            Service::updateOrCreate(['slug' => $slug], $data);
        }
    }
}
