<?php

namespace App\Exports;

use App\Models\Internship;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class InternshipsExport implements FromQuery, WithMapping, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    private $tahun;
    public function __construct($tahun = null)
    {
        $this->tahun = $tahun;
    }

    public function query()
    {
        if($this->tahun){
            return Internship::query()->whereYear('created_at',$this->tahun);
        }else{
            return Internship::query();
        }
    }

    public function map($internship): array
    {
        return [
            $internship->user->name,
            $internship->no_induk,
            $internship->no_telp,
            $internship->jurusan,
            $internship->asal_institusi,
            $internship->bidang_diambil,
            $internship->tanggal_awal_magang->format('d-M-Y'),
            $internship->tanggal_akhir_magang->format('d-M-Y')
        ];
    }

    public function headings(): array
    {
        return [
            'NAMA',
            'NO INDUk',
            'NO TELEPON',
            'JURUSAN',
            'ASAL INSTITUSI',
            'POSISI DIAMBIL',
            'TANGGAL AWAL MAGANG',
            'TANGGAL AKHIR MAGANG',
        ];
    }
}
