<?php

namespace App\Http\Controllers\Dashboard\Setting;

use App\Models\Farmer;
use App\Models\Village;
use App\Models\District;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Http\Requests\Seeding\StoreSeedingDataRequest;
use App\Models\User;

class SeedingController extends Controller
{
    //

    public function index()
    {
        $districtCount = District::count();
        $villageCount = Village::count();
        $farmerCount = Farmer::count();

        // Check if any of the counts is greater than zero
        $tablesFilled = $districtCount == 0 && $villageCount == 0 && $farmerCount == 0;

        return view('pages.dashboard.seeding.index', compact('tablesFilled'));
    }

    public function storeComplete(StoreSeedingDataRequest $request)
    {
        // return $this->fixData($request);
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
                // Remove the unwanted string from the village name
                $currentVillage = $data[2];
            }

            if (!(empty($data[1]) && empty($data[2]) && empty($data[3]) && empty($data[4]) && empty($data[5]))) {
                $datas[$currentDistrict][$currentVillage][] = [
                    'name' => $data[3],
                    'pic' => $data[4],
                    'address' => $data[5],
                ];
            }
        }
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
                    if ($validated['with_village_user']) {
                        $user = User::create(
                            [
                                'name'      =>  'Desa ' . str()->title($village->name),
                                'email'     =>  str()->snake($district->name) . '.' . str()->snake($village->name) . '@sppbt.toba.gov.id',
                                'password'  =>  bcrypt('password')
                            ]
                        );
                    }
                    foreach ($farmers as $key => $farmer) {
                        $farmer['village_id'] = $village->id;
                        Farmer::create($farmer);
                    }
                }
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            if ($th instanceof \Exception) {
                $errorMessage = $th->getMessage();
            }
            return back()->with(
                [
                    'failed'            =>  'Upload massal gagal dilakukan. Periksa kembali format file yang ande upload!',
                    'additionalMessage' =>  $errorMessage,
                ]
            );
        }
        return back()->with(
            [
                'success'   =>  'Upload massal berhasil dilakukan!'
            ],
        );
    }

    public function fixData(StoreSeedingDataRequest $request)
    {
        $validated = $request->validated();
        $spreadsheet = IOFactory::load($validated['file']->getPathname());
        $sheet = $spreadsheet->getActiveSheet();
        $rowIndex = 1; // To track the current row index, starting from 1 (excluding the header)
        foreach ($sheet->getRowIterator() as $row) {
            if ($rowIndex === 1) {
                $rowIndex++;
                continue; // Skip the first row (header row)
            }

            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false);

            $columnIndex = 1; // To track the current column index
            foreach ($cellIterator as $cell) {
                // Update the cell value with the fixed data
                $cellValue = $cell->getValue();
                $cellValue = str_replace([
                    'Tambah Anggota',
                    'Tambah Bantuan',
                    'Komoditas Yang Diusahakan',
                    'Komoditas yang diusahakan',
                    'Input Jenis Kelompok',
                    'Ubah',
                    'Hapus'
                ], '', $cellValue);
                $cell->setValue($cellValue);

                $columnIndex++;
            }

            $rowIndex++;
        }

        // Save the modified file
        $fixedFilePath = storage_path('app/public/modified_file.xlsx');
        $writer = new Xlsx($spreadsheet);
        $writer->save($fixedFilePath);

        // Set the new filename for the fixed file
        $fixedFileName = 'fixed_file.xlsx';

        // Download the fixed file
        return response()->download($fixedFilePath, $fixedFileName, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }
}
