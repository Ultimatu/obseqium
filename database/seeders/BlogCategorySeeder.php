<?php

namespace Database\Seeders;

use App\Models\BlogCategory;
use Illuminate\Database\Seeder;

class BlogCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Réglementation', 'slug' => 'reglementation', 'color' => '#dc2626', 'order' => 1,
             'description' => 'Veille juridique et actualités réglementaires QHSE'],
            ['name' => 'Qualité', 'slug' => 'qualite', 'color' => '#2563eb', 'order' => 2,
             'description' => 'Management de la qualité, ISO 9001, amélioration continue'],
            ['name' => 'Sécurité', 'slug' => 'securite', 'color' => '#d97706', 'order' => 3,
             'description' => 'Prévention des risques professionnels et sécurité au travail'],
            ['name' => 'Environnement', 'slug' => 'environnement', 'color' => '#16a34a', 'order' => 4,
             'description' => 'Management environnemental, ISO 14001, RSE'],
            ['name' => 'Formation', 'slug' => 'formation', 'color' => '#7c3aed', 'order' => 5,
             'description' => 'Actualités pédagogiques et retours d\'expérience formation'],
        ];

        foreach ($categories as $data) {
            BlogCategory::updateOrCreate(['slug' => $data['slug']], $data);
        }
    }
}
