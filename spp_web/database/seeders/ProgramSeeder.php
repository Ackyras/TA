<?php

namespace Database\Seeders;

use App\Models\Unit;
use App\Models\Period;
use App\Models\Program;
use App\Models\Division;
use Illuminate\Database\Seeder;
use App\Models\ProposalDictionary;

class ProgramSeeder extends Seeder
{
    protected Period $period;

    // public function __construct()
    // {
    //     $this->period = Period::where('is_active', true)->first();
    // }

    public function run()
    {
        $divisionPrograms = [
            'PSP'   => [
                [
                    'code'          => '03.27.02',
                    'name'          => 'Program Penyediaan dan Pengembangan Sarana Pertanian',
                    'subprograms'   => [
                        [
                            'code'          => '03.27.02.01',
                            'name'          => 'Pengawasan penggunaan sarana pertanian',
                            'subprograms'   => [
                                [
                                    'code'          => '03.27.02.01.01',
                                    'name'          => 'Pengawasan penggunaan sarana pendukung pertanian sesuai dengan komoditas, teknologi, dan spesifik lokasi',
                                    'subprograms'    => [
                                        [
                                            'name' => 'Pengadaan Hand Traktor',
                                        ],
                                        [
                                            'name' => 'Pengadaan Cultivator',
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ]
            ],
            'KBN'   =>  [
                [
                    'code'          => '03.27.02',
                    'name'          => 'Program Penyediaan dan Pengembangan Sarana Pertanian',
                    'subprograms'   =>  [
                        [
                            'code'          => '03.27.02.01',
                            'name'          => 'Pengawasan penggunaan sarana pertanian',
                            'subprograms'   =>  [
                                [
                                    'code'          => '03.27.02.01.01',
                                    'name'          => 'Pengawasan penggunaan sarana pendukung pertanian sesuai dengan komoditas, teknologi, dan spesifik lokasi',
                                    'subprograms'   =>  [
                                        [
                                            'name'  =>  'Pengadaan alat pasca panen perkebunan, komoditi kopi'
                                        ]
                                    ]
                                ]
                            ]
                        ],
                        [
                            'code'          =>  '03.27.02.02',
                            'name'          =>  'Pengelolaan sumber daya genetik (SDG) hewan, tumbuhan, dan mikro organisme kewenangan kabupaten/kota',
                            'subprograms'   =>  [
                                [
                                    'code'  =>  '03.27.02.02.03',
                                    'name'  =>  'Pemanfaatan SDG Hewan/Tanaman',
                                    'subprograms'   =>  [
                                        [
                                            'name'  =>  'Pengembangan tanaman kopi',
                                        ],
                                        [
                                            'name'  =>  'Pengadaan bibit tanaman kelapa sawit',
                                        ],
                                        [
                                            'name'  =>  'Pengadaan bibit kopi',
                                        ],
                                    ]
                                ]
                            ]
                        ]
                    ]
                ],
            ],
            'TPH'   =>  [
                [
                    'code'          => '03.27.02',
                    'name'          => 'Program Penyediaan dan Pengembangan Sarana Pertanian',
                    'subprograms'   =>  [
                        [
                            'code'          => '03.27.02.01',
                            'name'          => 'Pengawasan penggunaan sarana pertanian',
                            'subprograms'   =>  [
                                [
                                    'code'          => '03.27.02.01.01',
                                    'name'          => 'Pengawasan penggunaan sarana pendukung pertanian sesuai dengan komoditas, teknologi, dan spesifik lokasi',
                                    'subprograms'   =>  [
                                        [
                                            'name'  =>  'Pengadaan mesin pemipil jagung (corn sheller)',
                                        ],
                                        [
                                            'name'  =>  'Pengadaan mesin perontok padi (Power tresher)',
                                        ],
                                    ]
                                ]
                            ]
                        ],
                        [
                            'code'          =>  '03.27.02.02',
                            'name'          =>  'Pengelolaan sumber daya genetik (SDG) hewan, tumbuhan, dan mikro organisme kewenangan kabupaten/kota',
                            'subprograms'   =>  [
                                [
                                    'code'  =>  '03.27.02.02.03',
                                    'name'  =>  'Pemanfaatan SDG Hewan/Tanaman',
                                    'subprograms'   =>  [
                                        [
                                            'name'  =>  'Pengadaan bibit padi',
                                        ],
                                        [
                                            'name'  =>  'Pengadaan bibit jagung',
                                        ],
                                        [
                                            'name'  =>  'Pengembangan tanaman kacang tanah',
                                        ],
                                        [
                                            'name'  =>  'Pengembangan tanaman bawang merah',
                                        ],
                                        [
                                            'name'  =>  'Pengembangan tanaman kentang',
                                        ],
                                        [
                                            'name'  =>  'Pengembangan aneka sayuran',
                                        ],
                                        [
                                            'name'  =>  'Pengadaan bibit jeruk',
                                        ],
                                        [
                                            'name'  =>  'Pengadaan bibit durian',
                                        ],
                                        [
                                            'name'  =>  'Pengadaan bibit pokat',
                                        ],
                                        [
                                            'name'  =>  'Pengadaan bibit jahe',
                                        ],
                                    ]
                                ]
                            ]
                        ]
                    ]
                ],
            ],

            'TNK'   => [
                [
                    'code'          => '03.27.02',
                    'name'          => 'Program Penyediaan dan Pengembangan Sarana Pertanian',
                    'subprograms'   =>  [
                        [
                            'code'          => '03.27.02.06',
                            'name'          => 'Penyediaan benih/bibit ternak dan hijauan pakan ternak yang sumbernya dalam 1 (satu) daerah kabupaten/kota lain',
                            'subprograms'   =>  [
                                [
                                    'code'          => '03.27.02.06.01',
                                    'name'          => 'Pengadaan benih/bibit ternak yang sumbernya dari daerah kabupaten/kota lain',
                                    'subprograms'   =>  [
                                        [
                                            'name'  =>  'Pengadaan ternak babi',
                                        ],
                                        [
                                            'name'  =>  'Pengadaan ternak kerbau',
                                        ],
                                        [
                                            'name'  =>  'Pengadaan ternak sapi',
                                        ],
                                        [
                                            'name'  =>  'Pengadaan ternak kambing',
                                        ],
                                        [
                                            'name'  =>  'Pengadaan ternak ayam',
                                        ],
                                        [
                                            'name'  =>  'Pengadaan ternak itik',
                                        ],
                                    ]
                                ],
                                [
                                    'code'          => '03.27.02.06.02',
                                    'name'          => 'Pengadaan hijauan pakan ternak yang sumbernya dari daerah kabupaten/kota lain',
                                    'subprograms'   =>  [
                                        [
                                            'name'  =>  'Pengadaan hijauan pakan ternak (HPT)',
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ],
                ]
            ]
        ];
        $period = Period::where('is_active', true)->first();
        foreach ($divisionPrograms as $key => $programs) {
            $division = Division::query()->where('nickname', $key)->first();
            foreach ($programs as $programData) {
                $this->createProgram($division, $programData);
            }
        }
    }

    private function createProgram(Division $division, $programData, $parent = null)
    {
        if (isset($programData['subprograms'])) {
            $program = Program::firstOrCreate([
                'code' => isset($programData['code']) ? $programData['code'] : null,
                'name' => $programData['name'],
                'parent_id' => $parent ? $parent->id : null,
            ]);
            foreach ($programData['subprograms'] as $subprogramData) {
                $this->createProgram($division, $subprogramData, $program);
            }
        } else {
            $proposalDictionary = ProposalDictionary::create([
                'name' => $programData['name'],
                'parent_id' => $parent ? $parent->id : null,
                'division_id' => $division->id
            ]);
        }
    }
}
