<?php

namespace Database\Seeders;

use App\Models\Village;
use App\Models\District;
use App\Imports\BaseDataImport;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ProductionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $importer = new BaseDataImport;
        Excel::import($importer, database_path('seeders/PokTan_Fixed.xlsx'));
        $datas = $importer->data;
        DB::beginTransaction();
        try {
            foreach ($datas as $districtName => $villages) {
                $district = District::create([
                    'name'  =>  $districtName
                ]);
                foreach ($villages as $villageName => $farmers) {
                    $village = Village::create(
                        [
                            'name'          =>  $villageName,
                            'district_id'   =>  $district->id
                        ],
                    );
                }
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            if ($th instanceof \Exception) {
                $errorMessage = $th->getMessage();
                // Return the error message to the console
                error("An error occurred: $errorMessage");
            }
        }
        $this->call([
            RoleSeeder::class,
            RolePermissionSeeder::class,
            UnitSeeder::class,
            UserSeeder::class,
        ]);
    }
}
