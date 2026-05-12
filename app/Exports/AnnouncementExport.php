<?php

namespace App\Exports;

use App\Models\Announcement;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AnnouncementExport implements FromCollection,WithMapping,WithHeadings,WithStyles{
    public function collection(){
        return Announcement::with(['user','course'])->get();
    }

    public function map($announcement):array
    {
        return[
            $announcement->id,
            $announcement->title,
            $announcement->user->name,
            $announcement->course->title,
            $announcement->created_at->format('m/d/Y'),
            $announcement->updated_at->format('m/d/Y'),
        ];
    }

    public function headings(): array
    {
        return[
            'Id',
            'Τίτλος',
            'Καθηγητής',
            'Μάθημα',
            'Ημερομηνία Δημιουργίας',
            'Ημερομηνία Επεξεργασίας'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:E1')->applyFromArray([
            'font'=>[
                'bold' => true,
                'color' => [
                    'rgb' => '000000',
                ],
            ]
        ]);
    }
}
