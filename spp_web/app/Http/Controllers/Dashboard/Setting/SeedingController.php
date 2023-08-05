<?php

namespace App\Http\Controllers\Dashboard\Setting;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Http\Requests\Seeding\StoreSeedingDataRequest;
use App\Models\District;
use App\Models\Farmer;
use App\Models\Village;

class SeedingController extends Controller
{
    //

    public function index()
    {
        return view('pages.dashboard.seeding.index');
    }

    public function storeComplete(StoreSeedingDataRequest $request)
    {
        $validated = $request->validated();
        $spreadsheet = IOFactory::load($validated['file']->getPathname());
        $sheet = $spreadsheet->getActiveSheet();

        $datas = [];
        $currentDistrict = '';
        $currentVillage = '';
        $isFirstRow = true;
        foreach ($sheet->getRowIterator() as $row) {
            if ($isFirstRow) {
                $isFirstRow = false;
                continue; // Skip the first row (header row)
            }

            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false);

            $data = [];
            foreach ($cellIterator as $cell) {
                $data[] = $cell->getValue();
            }
            if (!empty($data[1])) {
                $currentDistrict = $data[1];
            }
            if (!empty($data[2])) {
                $currentVillage = $data[2];
            }
            if (!(empty($data[1]) && empty($data[2]) && empty($data[3]) && empty($data[4]) && empty($data[5]))) {
                $datas[$currentDistrict][$currentVillage][] = [
                    'name'      =>  $data[3],
                    'pic'       =>  $data[4],
                    'address'   =>  $data[5],
                ];
            }
        }
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
                foreach ($farmers as $key => $farmer) {
                    $farmer['village_id'] = $village->id;
                    Farmer::create($farmer);
                }
            }
        }
        return response()->json($datas);
    }
}
