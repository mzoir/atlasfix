<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\ServiceType;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Creates 4 Service Types with 12 Services
     */
    public function run(): void
    {
        // ════════════════════════════════════════════
        // SERVICE TYPE 1: PLOMBIER (Plumbing)
        // ════════════════════════════════════════════
        $plombier = ServiceType::create([
            'name' => 'Plombier',
            'slug' => 'plombier',
            'icon' => 'https://img.icons8.com/fluency/96/000000/plumbing.png',
            'description' => 'Services de plomberie et installations',
            'is_active' => true,
        ]);

        Service::create([
            'service_type_id' => $plombier->id,
            'name' => 'Réparation de fuite',
            'description' => 'Réparation rapide et efficace des fuites d\'eau',
            'icon' => '🔧',
            'is_active' => true,
        ]);

        Service::create([
            'service_type_id' => $plombier->id,
            'name' => 'Installation de robinet',
            'description' => 'Installation professionnelle de robinets et accessoires',
            'icon' => '💧',
            'is_active' => true,
        ]);

        Service::create([
            'service_type_id' => $plombier->id,
            'name' => 'Débouchage',
            'description' => 'Débouchage de tuyauterie avec équipement professionnel',
            'icon' => '🔨',
            'is_active' => true,
        ]);

        // ════════════════════════════════════════════
        // SERVICE TYPE 2: ELECTRICIEN (Electrician)
        // ════════════════════════════════════════════
        $electricien = ServiceType::create([
            'name' => 'Electricien',
            'slug' => 'electricien',
            'icon' => 'https://img.icons8.com/fluency/96/000000/lightning-bolt.png',
            'description' => 'Services électriques et installations',
            'is_active' => true,
        ]);

        Service::create([
            'service_type_id' => $electricien->id,
            'name' => 'Installation électrique',
            'description' => 'Installation de circuits électriques et panneaux',
            'icon' => '⚡',
            'is_active' => true,
        ]);

        Service::create([
            'service_type_id' => $electricien->id,
            'name' => 'Réparation d\'électroménager',
            'description' => 'Réparation de cuisinière, four, lave-vaisselle, etc.',
            'icon' => '🔌',
            'is_active' => true,
        ]);

        Service::create([
            'service_type_id' => $electricien->id,
            'name' => 'Installation d\'ampoules LED',
            'description' => 'Conversion d\'éclairage traditionnel en LED efficace',
            'icon' => '💡',
            'is_active' => true,
        ]);

        // ════════════════════════════════════════════
        // SERVICE TYPE 3: MAÇON (Mason/Construction)
        // ════════════════════════════════════════════
        $macon = ServiceType::create([
            'name' => 'Maçon',
            'slug' => 'macon',
            'icon' => 'https://img.icons8.com/fluency/96/000000/brickwall.png',
            'description' => 'Services de construction et maçonnerie',
            'is_active' => true,
        ]);

        Service::create([
            'service_type_id' => $macon->id,
            'name' => 'Réparation de murs',
            'description' => 'Réparation et restauration des murs endommagés',
            'icon' => '🧱',
            'is_active' => true,
        ]);

        Service::create([
            'service_type_id' => $macon->id,
            'name' => 'Construction de murs',
            'description' => 'Construction de nouveaux murs et structures',
            'icon' => '🏗️',
            'is_active' => true,
        ]);

        Service::create([
            'service_type_id' => $macon->id,
            'name' => 'Carrelage',
            'description' => 'Pose et réparation de carrelage',
            'icon' => '🔲',
            'is_active' => true,
        ]);

        // ════════════════════════════════════════════
        // SERVICE TYPE 4: PEINTRE (Painter)
        // ════════════════════════════════════════════
        $peintre = ServiceType::create([
            'name' => 'Peintre',
            'slug' => 'peintre',
            'icon' => 'https://img.icons8.com/fluency/96/000000/paint-palette.png',
            'description' => 'Services de peinture et décoration',
            'is_active' => true,
        ]);

        Service::create([
            'service_type_id' => $peintre->id,
            'name' => 'Peinture intérieure',
            'description' => 'Peinture professionnelle des intérieurs',
            'icon' => '🎨',
            'is_active' => true,
        ]);

        Service::create([
            'service_type_id' => $peintre->id,
            'name' => 'Peinture extérieure',
            'description' => 'Peinture de façades et extérieurs',
            'icon' => '🏠',
            'is_active' => true,
        ]);

        Service::create([
            'service_type_id' => $peintre->id,
            'name' => 'Décoration murale',
            'description' => 'Décoration créative et papier peint',
            'icon' => '✨',
            'is_active' => true,
        ]);

        echo "✅ Seeder completed: 4 ServiceTypes + 12 Services created!\n";
    }
}