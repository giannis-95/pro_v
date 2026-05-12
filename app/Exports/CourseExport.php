<?php

namespace App\Exports;

use App\Models\Course;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithStyles;

class CourseExport implements FromCollection,WithMapping,WithHeadings,WithStyles{
    public function collection(){
        return Course::all();
    }

    public function map($course): array
    {
        return [
            $course->id,
            $course->title,
            $course->descritpion,
            $course->created_at->format('d/m/Y'),
            $course->updated_at->format('d/m/Y'),
        ];
    }

    public function headings(): array
    {
        return[
            'Id',
            'Τίτλος',
            'Περιγραφή',
            'Ημερομηνία Δημιουργίας',
            'Ημερομηνία Ενημέρωσης',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:E1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => [
                    'rgb' => '000000',
                ],
            ],
        ]);
    }
}
