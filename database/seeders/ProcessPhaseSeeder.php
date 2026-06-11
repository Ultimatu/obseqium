<?php

namespace Database\Seeders;

use App\Models\ProcessPhase;
use Illuminate\Database\Seeder;

class ProcessPhaseSeeder extends Seeder
{
    public function run(): void
    {
        $phases = [
            [
                'order' => 1,
                'title' => 'Audit Diagnostic',
                'badge' => 'GRATUIT',
                'description' => 'Évaluation de votre situation actuelle face aux exigences des normes. Identification des forces, faiblesses et opportunités. Vous repartez avec un rapport diagnostic et des recommandations concrètes - sans engagement.',
                'highlights' => ['Évaluation gap initial', 'Rapport diagnostic complet', 'Recommandations priorisées'],
                'icon' => 'clipboard-document-check',
            ],
            [
                'order' => 2,
                'title' => 'Restitution, Cotation et Planning',
                'description' => "Présentation du rapport diagnostic, cotation précise de la mission en fonction des écarts identifiés et établissement du planning d'accompagnement personnalisé.",
                'highlights' => ['Cotation transparente', 'Planning sur-mesure'],
                'icon' => 'presentation-chart-line',
            ],
            [
                'order' => 3,
                'title' => 'Cadrage et Engagement',
                'description' => "Réunion de cadrage avec la direction, démonstration de l'engagement de la direction et constitution du comité de pilotage.",
                'highlights' => ['Engagement direction', 'Comité de pilotage'],
                'icon' => 'users',
            ],
            [
                'order' => 4,
                'title' => 'Analyse Contextuelle',
                'description' => "Analyse du contexte interne et externe de l'organisation, identification des parties intéressées, évaluation des enjeux et risques.",
                'highlights' => ['Contexte interne/externe', 'Parties intéressées', 'Enjeux & risques'],
                'icon' => 'magnifying-glass',
            ],
            [
                'order' => 5,
                'title' => 'Définition de la Stratégie',
                'description' => 'Élaboration des objectifs qualité liés aux enjeux stratégiques, définition de la politique qualité, environnementale ou QHSE, création de la cartographie des processus.',
                'highlights' => ['Politique', 'Objectifs', 'Cartographie processus'],
                'icon' => 'map',
            ],
            [
                'order' => 6,
                'title' => 'Structuration du Système',
                'description' => "Formalisation des responsabilités (nomination des pilotes de processus), création des fiches d'identité de chaque processus, élaboration des procédures de travail, mise en place des enregistrements et indicateurs.",
                'highlights' => ['Pilotes de processus', 'Procédures', 'Indicateurs'],
                'icon' => 'folder-open',
            ],
            [
                'order' => 7,
                'title' => 'Déploiement et Formation',
                'description' => "Formation du personnel sur les normes, à l'approche processus et à la gestion des risques. Mise en place de la veille réglementaire et légale. Enquêtes de satisfaction du personnel et des clients.",
                'highlights' => ['Formations', 'Veille réglementaire', 'Enquêtes satisfaction'],
                'icon' => 'academic-cap',
            ],
            [
                'order' => 8,
                'title' => 'Audits Internes et Revues',
                'description' => 'Formation et accompagnement des auditeurs internes, réalisation des audits internes, revue de processus et revue de direction.',
                'highlights' => ['Auditeurs internes formés', 'Audits internes', 'Revue de direction'],
                'icon' => 'shield-check',
            ],
            [
                'order' => 9,
                'title' => 'Préparation à la Certification',
                'description' => "Réunion de fin de mission, aide à l'identification d'un organisme de certification approprié, préparation du dossier complet pour l'audit de certification.",
                'highlights' => ['Organisme certificateur', 'Dossier de certification'],
                'icon' => 'trophy',
            ],
        ];

        foreach ($phases as $phase) {
            ProcessPhase::updateOrCreate(
                ['order' => $phase['order']],
                $phase
            );
        }
    }
}
