<?php

namespace Database\Seeders;

use App\Models\Camp;
use Illuminate\Database\Seeder;

class CampsSeeder extends Seeder
{

    public function run()
    {
        $data = [
            [
                'bootcamp_name'         => 'Gila Belajar',
                'slug'          => 'gila-belajar',
                'price'         => 280,
                'created_at'    => date('y-m-d H:i:s', time()),
                'updated_at'    => date('Y-m-d H:i:s', time())
            ],
            [
                'bootcamp_name'         => 'Baru Mulai',
                'slug'          => 'baru-mulai',
                'price'         => 140,
                'created_at'    => date('Y-m-d H:i:s', time()),
                'updated_at'    => date('Y-m-d H:i:s', time())
            ],
        ];

        Camp::insert($data);
    }
}
