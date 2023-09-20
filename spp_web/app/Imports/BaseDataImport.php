<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BaseDataImport implements WithHeadingRow, ToCollection
{
    public $data;
    /**
     * @param Collection $collection
     */
    public function collection(Collection $rows)
    {
        $datas = [];
        $currentDistrict = '';
        $currentVillage = '';
        foreach ($rows as $row) {
            $data = $row;

            if (!empty($data['kecamatan'])) {
                $currentDistrict = $data['kecamatan'];
            }

            if (!empty($data['nama_desa'])) {
                // Remove the unwanted string from the village name
                $currentVillage = $data['nama_desa'];
            }

            if (!(empty($data['kecamatan']) && empty($data['nama_desa']) && empty($data['nama_poktan']) && empty($data['nama_ketua']) && empty($data['alamat_sekretariat']))) {
                $datas[$currentDistrict][$currentVillage][] = [
                    'name' => str($data['nama_poktan'])->title()->value(),
                    'pic' => str($data['nama_ketua'])->title()->value(),
                    'address' => str($data['alamat_sekretariat'])->title()->value(),
                ];
            }
        }
        $this->data = $datas;
    }
}
