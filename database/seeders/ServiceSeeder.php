<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            // ── Conseil & Audit ──────────────────────────────────────────
            [
                'title'        => 'Audit QHSE & diagnostic réglementaire',
                'slug'         => 'audit-qhse-diagnostic-reglementaire',
                'icon'         => '🔍',
                'type'         => 'audit',
                'order'        => 1,
                'description'  => 'Évaluation complète de vos pratiques QHSE, identification des écarts réglementaires et rédaction d\'un plan d\'action priorisé pour mettre votre organisation en conformité.',
                'content'      => '<p>Notre audit QHSE débute par une phase de collecte documentaire, suivie d\'entretiens avec les acteurs clés et d\'observations terrain. Le rapport final synthétise les points de conformité, les non-conformités et les pistes d\'amélioration classées par niveau de criticité.</p><h3>Déroulement</h3><ul><li>Analyse documentaire (procédures, registres, DUERP)</li><li>Entretiens dirigés avec la direction et les responsables</li><li>Visite des installations et observations terrain</li><li>Rédaction du rapport d\'audit avec plan d\'action</li><li>Restitution et présentation aux parties prenantes</li></ul>',
                'deliverables' => "Rapport d'audit détaillé\nPlan d'action priorisé\nTableau de bord de suivi",
                'is_active'    => true,
            ],
            [
                'title'        => 'Conseil en management intégré QSE',
                'slug'         => 'conseil-management-integre-qse',
                'icon'         => '🏗️',
                'type'         => 'strategic',
                'order'        => 2,
                'description'  => 'Conception et déploiement d\'un système de management intégré Qualité-Sécurité-Environnement, harmonisé avec les référentiels ISO et adapté à votre secteur d\'activité.',
                'content'      => '<p>Un système de management intégré (SMI) permet de piloter simultanément vos enjeux qualité, sécurité et environnement au travers d\'une démarche cohérente, évitant la redondance des documents et des audits.</p><h3>Notre approche</h3><p>Nous co-construisons avec vos équipes un système documentaire pragmatique, ancré dans vos réalités terrain et aligné sur les exigences ISO 9001, ISO 14001 et ISO 45001.</p>',
                'deliverables' => "Cartographie des processus\nManuel QSE\nProcédures opérationnelles\nIndicateurs de pilotage",
                'is_active'    => true,
            ],

            // ── Formation ────────────────────────────────────────────────
            [
                'title'        => 'Formation HACCP & hygiène alimentaire',
                'slug'         => 'formation-haccp-hygiene-alimentaire',
                'icon'         => '🍽️',
                'type'         => 'training',
                'order'        => 3,
                'description'  => 'Maîtrisez les principes HACCP, les bonnes pratiques d\'hygiène (BPH) et les exigences réglementaires applicables à la filière alimentaire, en présentiel ou à distance.',
                'content'      => '<p>Cette formation couvre les 7 principes HACCP selon le Codex Alimentarius et les exigences du règlement (CE) n°852/2004.</p><h3>Programme</h3><ul><li>Contexte réglementaire (règlements CE, paquet hygiène)</li><li>Analyse des dangers biologiques, chimiques, physiques</li><li>Construction d\'un diagramme de fabrication</li><li>Maîtrise des CCP et des PRPo</li><li>Système documentaire et traçabilité</li></ul>',
                'deliverables' => "Support de formation\nAtelier pratique (étude de cas)\nQCM de validation\nAttestation de formation",
                'is_active'    => true,
            ],
            [
                'title'        => 'Formation Document Unique & prévention des risques',
                'slug'         => 'formation-document-unique-prevention-risques',
                'icon'         => '🛡️',
                'type'         => 'training',
                'order'        => 4,
                'description'  => 'Apprenez à construire ou mettre à jour votre DUERP selon les nouvelles obligations issues du décret du 18 avril 2022, avec méthode et outils pratiques.',
                'content'      => '<p>Depuis le décret du 18 avril 2022, la mise à jour annuelle du DUERP est obligatoire pour toutes les entreprises. Cette formation vous donne les outils méthodologiques pour réaliser ou actualiser votre document unique de façon rigoureuse et opposable.</p><h3>Contenu pédagogique</h3><ul><li>Cadre légal et nouveautés réglementaires 2022</li><li>Méthode d\'identification et de cotation des risques</li><li>Élaboration du programme de prévention</li><li>Conservation et mise à disposition du DUERP</li></ul>',
                'deliverables' => "Trame DUERP personnalisable\nGuide méthodologique\nAttestation de formation",
                'is_active'    => true,
            ],

            // ── Accompagnement ───────────────────────────────────────────
            [
                'title'        => 'Accompagnement certification ISO 9001',
                'slug'         => 'accompagnement-certification-iso-9001',
                'icon'         => '✅',
                'type'         => 'qhse',
                'order'        => 5,
                'description'  => 'Pilotage complet de votre projet de certification ISO 9001 v2015 : de la conception du système documentaire jusqu\'à l\'audit de certification, avec suivi post-audit.',
                'content'      => '<p>Nous prenons en charge l\'ensemble du chemin vers votre certification ISO 9001 : état des lieux initial, construction du système qualité, formation de vos équipes, audits internes blancs et accompagnement le jour J.</p><h3>Notre engagement</h3><p>Taux de certification dès le premier audit : 96 %. Nous restons à vos côtés jusqu\'à l\'obtention du certificat.</p>',
                'deliverables' => "Système documentaire complet\nFormation auditeurs internes\nAudit blanc\nPréparation à l'audit de certification",
                'is_active'    => true,
            ],
            [
                'title'        => 'Accompagnement ISO 14001 & bilan carbone',
                'slug'         => 'accompagnement-iso-14001-bilan-carbone',
                'icon'         => '🌿',
                'type'         => 'qhse',
                'order'        => 6,
                'description'  => 'Déployez votre système de management environnemental ISO 14001 et réalisez votre bilan carbone pour répondre aux exigences réglementaires et aux attentes clients.',
                'content'      => '<p>La norme ISO 14001 vous offre un cadre structuré pour maîtriser vos impacts environnementaux. Nous associons cet accompagnement à la réalisation de votre bilan GES (scopes 1, 2 et 3) pour une approche globale de votre responsabilité environnementale.</p>',
                'deliverables' => "Analyse environnementale initiale\nPolitique et objectifs environnementaux\nBilan carbone (scopes 1 & 2)\nPlan de réduction des émissions",
                'is_active'    => true,
            ],
        ];

        foreach ($services as $data) {
            Service::updateOrCreate(['slug' => $data['slug']], $data);
        }
    }
}
