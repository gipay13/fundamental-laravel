<?php

namespace Database\Seeders;

use App\Models\Camps;
use Illuminate\Database\Seeder;

class CampsSeeder extends Seeder
{

    public function run()
    {
        $data = [
            [
                'bootcamps_name'         => 'Gila Belajar',
                'slug'          => 'gila-belajar',
                'price'         => 280,
                'created_at'    => date('y-m-d H:i:s', time()),
                'updated_at'    => date('Y-m-d H:i:s', time())
            ],
            [
                'bootcamps_name'         => 'Baru Mulai',
                'slug'          => 'baru-mulai',
                'price'         => 140,
                'created_at'    => date('Y-m-d H:i:s', time()),
                'updated_at'    => date('Y-m-d H:i:s', time())
            ],
        ];

        Camps::insert($data);
    }
}
