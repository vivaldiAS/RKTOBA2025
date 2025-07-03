<?php

namespace Database\Seeders;

use App\Models\TiketExperience;
use Illuminate\Database\Seeder;

class TiketExperienceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TiketExperience::insert([
            [
                'nama' => 'Museum TB Silalahi',
                'lokasi' => 'Balige',
                'jenis_tiket' => 'museum',
                'jam_operasional' => 'Senin - Jumat: 09.00 - 17.00',
                'harga_anak' => 10000,
                'harga_dewasa' => 15000,
            ],
            [
                'nama' => 'Kolam Renang TB Silalahi',
                'lokasi' => 'Balige',
                'jenis_tiket' => 'kolam renang',
                'jam_operasional' => 'Senin - Jumat: 09.00 - 17.00',
                'harga_anak' => 10000,
                'harga_dewasa' => 20000,
            ],
        ]);
    }
}
