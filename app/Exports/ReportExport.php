<?php

namespace App\Exports;

use App\Models\ReportWeek;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class ReportExport implements FromQuery, WithHeadings, WithMapping, WithDrawings
{
    private $rowNumber = 2;

    /**
     * @return \Illuminate\Support\Collection
     */
    public function query()
    {
        return ReportWeek::where('internship_id', Auth::user()->internship->id);
    }

    public function headings(): array
    {
        return [
            'Tanggal dibuat',
            'Deskripsi',
            'Foto',
        ];
    }

    public function map($report): array
    {
        return [
            $report->created_at->format('d-M-Y'),
            strip_tags($report->deskripsi),
            // $report->foto
        ];
    }

    public function drawings()
    {
        $drawings = [];
        $reports = ReportWeek::where('internship_id', Auth::user()->internship->id)->get();
        foreach ($reports as $report) {
            $drawing = new Drawing();
            $drawing->setName('Photo');
            $drawing->setDescription('User Photo');
            $drawing->setPath(Storage::disk('public')->path($report->foto)); // Adjust the path as needed
            $drawing->setHeight(50);
            $drawing->setCoordinates('C' . $this->rowNumber);
            $drawings[] = $drawing;
            $this->rowNumber++;
        }

        return $drawings;
    }
}
