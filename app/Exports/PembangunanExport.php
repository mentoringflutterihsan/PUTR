<?php

namespace App\Exports;

use App\pembangunan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;

class PembangunanExport implements FromCollection,WithHeadings,WithMapping,ShouldAutoSize,WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return pembangunan::all();
    }
    public function headings(): array
    {
        return[
            'nama',
            'nilai kontrak',
            'latitude',
            'longtitude',
            'lokasi',
            'panjang pekerjaan',
            'volume'
        ];
    }
    public function map($pembangunan): array
    {
        return[
            $pembangunan->name,
            $pembangunan->nilai_kontrak,
            $pembangunan->latitude,
            $pembangunan->longtitude,
            $pembangunan->lokasi,
            $pembangunan->panjang_pekerjaan,
            $pembangunan->volume
        ];
    }
    public function registerEvents(): array
    {
        return[
            AfterSheet::class=>function(AfterSheet $event){
                $event->sheet->getStyle('A1:G1')->applyFromArray([
                    'font'=>[
                        'bold'=>true
                    ]
                ]);
            }
        ];
    }
}

