<?php

namespace Database\Seeders;

use App\Models\District;
use Database\Seeders\Trait\FetchPublicApi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DistrictSeeder extends Seeder
{
    use FetchPublicApi;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        // District::factory()->count(16)->create();
        $this->fetchDistrict();
    }
}
