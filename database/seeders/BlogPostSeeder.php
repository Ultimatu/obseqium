<?php

namespace Database\Seeders;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class BlogPostSeeder extends Seeder
{
    public function run(): void
    {
        $author = User::query()->first() ?? User::query()->firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Administrateur',
                'password' => 'password',
                'is_active' => true,
            ]
        );

        $cat = fn (string $slug) => BlogCategory::where('slug', $slug)->value('id');

        $posts = [
            [
                'blog_category_id' => $cat('reglementation'),
                'title' => 'DUERP 2024 : les nouvelles obligations depuis le décret du 18 avril 2022',
                'slug' => 'duerp-2024-nouvelles-obligations-decret-2022',
                'excerpt' => 'Depuis le décret du 18 avril 2022, les entreprises de plus de 11 salariés doivent mettre à jour leur Document Unique chaque année et l\'archiver pendant au moins 40 ans. Tour d\'horizon des nouvelles obligations.',
                'content' => '<h2>Ce qui a changé en 2022</h2><p>Le décret n°2022-395 du 18 mars 2022 a profondément remanié les obligations relatives au Document Unique d\'Évaluation des Risques Professionnels (DUERP). Désormais, les entreprises de plus de 11 salariés sont soumises à une mise à jour annuelle obligatoire et à une conservation dématérialisée du document sur une durée de 40 ans minimum.</p><h2>Principales modifications</h2><ul><li><strong>Mise à jour annuelle obligatoire</strong> pour les entreprises ≥ 11 salariés</li><li><strong>Programme annuel de prévention</strong> obligatoire pour les entreprises ≥ 50 salariés</li><li><strong>Archivage numérique</strong> sécurisé pendant 40 ans</li><li><strong>Consultation du CSE</strong> renforcée sur le document et ses mises à jour</li></ul><h2>Les risques en cas de non-conformité</h2><p>Un DUERP absent, incomplet ou non mis à jour constitue une faute inexcusable de l\'employeur en cas d\'accident du travail. Les sanctions peuvent aller de la condamnation civile à des amendes pénales significatives.</p><h2>Comment se mettre en conformité</h2><p>Notre cabinet vous accompagne dans la réalisation ou la mise à jour de votre DUERP selon une méthodologie éprouvée : identification des unités de travail, évaluation des risques par cotation probabilité × gravité, rédaction du programme de prévention et archivage conforme.</p>',
                'status' => 'published',
                'published_at' => Carbon::now()->subDays(5),
                'is_featured' => true,
                'views' => 247,
                'meta_title' => 'DUERP 2024 : obligations et mise en conformité',
                'meta_description' => 'Tout savoir sur les nouvelles obligations du Document Unique depuis le décret de 2022 : mise à jour annuelle, archivage 40 ans, programme de prévention.',
            ],
            [
                'blog_category_id' => $cat('qualite'),
                'title' => 'ISO 9001 v2015 : les 7 points clés pour réussir votre audit de renouvellement',
                'slug' => 'iso-9001-v2015-points-cles-audit-renouvellement',
                'excerpt' => 'Votre certification ISO 9001 arrive à échéance ? Préparez efficacement votre audit de renouvellement grâce à notre guide des 7 exigences les plus scrutées par les auditeurs.',
                'content' => '<h2>Pourquoi l\'audit de renouvellement est différent</h2><p>Contrairement à l\'audit initial, l\'audit de renouvellement (triennal) évalue non seulement la conformité du système, mais surtout sa <strong>maturité et son amélioration continue</strong> sur 3 ans. Les auditeurs recherchent des preuves tangibles d\'évolution.</p><h2>Les 7 points les plus scrutés</h2><ol><li><strong>Contexte de l\'organisation (clause 4)</strong> : votre analyse SWOT et la liste des parties intéressées sont-elles à jour ?</li><li><strong>Leadership (clause 5)</strong> : la direction est-elle impliquée de façon visible et documentée ?</li><li><strong>Planification des risques (clause 6)</strong> : votre registre des risques et opportunités reflète-t-il la réalité actuelle ?</li><li><strong>Indicateurs de performance (clause 9)</strong> : vos KPI sont-ils pertinents, mesurés et analysés régulièrement ?</li><li><strong>Audits internes (clause 9.2)</strong> : programme réalisé intégralement avec des non-conformités traitées ?</li><li><strong>Revue de direction (clause 9.3)</strong> : compte-rendu formalisé avec décisions et ressources allouées ?</li><li><strong>Actions correctives (clause 10)</strong> : efficacité des corrections vérifiée par des indicateurs de résultat ?</li></ol><h2>Notre conseil</h2><p>Planifiez un audit blanc 6 semaines avant votre audit de renouvellement. Notre équipe réalise une simulation complète dans les mêmes conditions qu\'un auditeur certificateur, avec un rapport détaillé des points à consolider.</p>',
                'status' => 'published',
                'published_at' => Carbon::now()->subDays(12),
                'is_featured' => true,
                'views' => 183,
                'meta_title' => 'ISO 9001 : réussir son audit de renouvellement',
                'meta_description' => 'Guide pratique pour préparer votre audit de renouvellement ISO 9001 : les 7 points incontournables vérifiés par les auditeurs certificateurs.',
            ],
            [
                'blog_category_id' => $cat('securite'),
                'title' => 'Risques psychosociaux en entreprise : obligations légales et outils de prévention',
                'slug' => 'risques-psychosociaux-obligations-legales-prevention',
                'excerpt' => 'Les RPS sont devenus un axe prioritaire des inspecteurs du travail. Quelles sont les obligations de l\'employeur et comment mettre en place une démarche de prévention efficace ?',
                'content' => '<h2>Les RPS : un risque professionnel comme les autres</h2><p>Depuis l\'arrêt "Snecma" du 5 mars 2008, la Cour de cassation confirme que l\'employeur est tenu à une <strong>obligation de résultat en matière de santé mentale</strong> des salariés. Les risques psychosociaux (stress, burn-out, harcèlement) doivent figurer dans le DUERP au même titre que les risques physiques.</p><h2>Cadre réglementaire</h2><ul><li>Article L.4121-1 du Code du travail : obligation générale de protection de la santé</li><li>Accord national interprofessionnel sur le stress au travail (2008)</li><li>Accord sur le harcèlement et la violence au travail (2010)</li><li>Recommandation INRS R.462 sur la prévention des RPS</li></ul><h2>Comment construire votre démarche RPS</h2><p>Une démarche RPS efficace repose sur 4 piliers : <strong>diagnostic partagé</strong> (questionnaire anonyme, entretiens), <strong>analyse des facteurs de risque</strong> (6 familles selon le modèle Gollac), <strong>plan d\'action</strong> avec mesures collectives prioritaires, et <strong>évaluation de l\'efficacité</strong> à 6 et 12 mois.</p>',
                'status' => 'published',
                'published_at' => Carbon::now()->subDays(20),
                'is_featured' => false,
                'views' => 312,
                'meta_title' => 'RPS : obligations et prévention pour les employeurs',
                'meta_description' => 'Guide complet sur les obligations légales des employeurs face aux risques psychosociaux et les outils pour une prévention efficace.',
            ],
            [
                'blog_category_id' => $cat('environnement'),
                'title' => 'Bilan carbone obligatoire : qui est concerné et comment s\'y préparer en 2024 ?',
                'slug' => 'bilan-carbone-obligatoire-2024-qui-concerne',
                'excerpt' => 'La loi Énergie-Climat rend le Bilan de Gaz à Effet de Serre (BEGES) obligatoire pour un nombre croissant d\'entreprises. Découvrez les seuils, les délais et la méthode pour réaliser votre premier bilan.',
                'content' => '<h2>Qui est obligé de réaliser un BEGES ?</h2><p>L\'article L.229-25 du Code de l\'environnement impose un Bilan de Gaz à Effet de Serre aux :</p><ul><li>Personnes morales de droit privé de plus de <strong>500 salariés</strong></li><li>Personnes morales de droit public de plus de <strong>250 agents</strong></li><li>Sociétés anonymes cotées en bourse</li></ul><p>La mise à jour doit être réalisée tous les <strong>4 ans</strong>.</p><h2>Les 3 scopes du bilan carbone</h2><p><strong>Scope 1</strong> : émissions directes liées à la combustion d\'énergie fossile sur site.<br><strong>Scope 2</strong> : émissions indirectes liées à la consommation d\'électricité, chaleur ou vapeur.<br><strong>Scope 3</strong> : autres émissions indirectes (achats, déplacements, déchets…) - non obligatoire mais fortement recommandé.</p><h2>Notre accompagnement</h2><p>Notre cabinet réalise votre bilan carbone en utilisant la méthode Bilan Carbone® de l\'ADEME et le référentiel GHG Protocol. Nous vous fournissons un rapport complet avec plan de réduction et axes de progrès prioritaires.</p>',
                'status' => 'published',
                'published_at' => Carbon::now()->subDays(28),
                'is_featured' => false,
                'views' => 196,
                'meta_title' => 'Bilan carbone obligatoire 2024 : qui est concerné ?',
                'meta_description' => 'Tout savoir sur l\'obligation de réaliser un Bilan GES en 2024 : seuils, délais, méthode et accompagnement.',
            ],
            [
                'blog_category_id' => $cat('formation'),
                'title' => 'Pourquoi former vos managers à la culture QHSE change tout',
                'slug' => 'former-managers-culture-qhse-pourquoi',
                'excerpt' => 'Les accidents du travail et les non-conformités qualité surviennent rarement là où on les attend. Souvent, c\'est le comportement des encadrants qui fait la différence. Notre retour d\'expérience sur 5 ans.',
                'content' => '<h2>Le facteur humain au cœur de la performance QHSE</h2><p>Les études montrent que <strong>plus de 80 % des accidents du travail ont une composante organisationnelle ou managériale</strong>. Former les opérateurs sans impliquer les encadrants, c\'est bâtir sur du sable.</p><h2>Ce que les managers doivent comprendre</h2><p>Un manager QHSE n\'est pas un expert technique - c\'est un animateur de culture sécurité. Son rôle est de :</p><ul><li>Donner l\'exemple par ses comportements visibles</li><li>Reconnaître et valoriser les comportements sûrs</li><li>Mener des visites terrain régulières et bienveillantes (VTS)</li><li>Traiter chaque incident comme une opportunité d\'apprentissage</li></ul><h2>Notre programme "Manager QHSE"</h2><p>En 2 jours, nos formateurs transmettent aux encadrants les fondamentaux de la culture sécurité, les techniques de communication positive et les outils de pilotage au quotidien. Résultat observé chez nos clients : -34 % d\'accidents bénins sur 12 mois.</p>',
                'status' => 'published',
                'published_at' => Carbon::now()->subDays(35),
                'is_featured' => false,
                'views' => 142,
                'meta_title' => 'Former ses managers à la culture QHSE : pourquoi c\'est indispensable',
                'meta_description' => 'Retour d\'expérience sur l\'impact de la formation managériale sur la performance QHSE : moins d\'accidents, meilleure conformité.',
            ],
            [
                'blog_category_id' => $cat('reglementation'),
                'title' => 'Réforme de la formation professionnelle 2024 : impact sur les actions QHSE éligibles au CPF',
                'slug' => 'reforme-formation-professionnelle-2024-cpf-qhse',
                'excerpt' => 'La réforme du CPF introduit une participation financière de 100 € à la charge du salarié. Quelles formations QHSE restent éligibles et quelles alternatives pour financer vos projets de montée en compétences ?',
                'content' => '<h2>La réforme CPF en bref</h2><p>Depuis le 2 mai 2024, une participation forfaitaire de <strong>100 € reste à la charge du titulaire du CPF</strong>, sauf exceptions (demandeurs d\'emploi, formations imposées par l\'employeur, reconversion professionnelle).</p><h2>Les formations QHSE encore finançables à 100 % via CPF</h2><ul><li>Formations liées à une reconversion professionnelle (ex : responsable QHSE)</li><li>Certifications RNCP dans les métiers QHSE</li><li>Bilan de compétences pour une réorientation vers les métiers de la sécurité</li></ul><h2>Les alternatives de financement</h2><p>Pour contourner la participation de 100 €, plusieurs leviers existent :</p><ul><li><strong>Plan de développement des compétences (PDC)</strong> : financement employeur sur fonds propres ou via OPCO</li><li><strong>Projet de transition professionnelle (PTP)</strong> : pour les reconversions certifiantes</li><li><strong>OPCO de branche</strong> : certains OPCO couvrent intégralement les formations QHSE prioritaires</li></ul>',
                'status' => 'published',
                'published_at' => Carbon::now()->subDays(45),
                'is_featured' => false,
                'views' => 89,
                'meta_title' => 'CPF 2024 et formations QHSE : ce qui change',
                'meta_description' => 'Comprendre l\'impact de la réforme CPF sur les formations QHSE éligibles et découvrir les alternatives de financement.',
            ],
        ];

        foreach ($posts as $data) {
            $data['author_id'] = $author->id;
            BlogPost::updateOrCreate(['slug' => $data['slug']], $data);
        }
    }
}
