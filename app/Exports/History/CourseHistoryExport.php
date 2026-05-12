<?php

namespace App\Exports\History;

use App\Models\History\CourseHistory;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CourseHistoryExport implements FromCollection,WithMapping,WithHeadings,WithStyles{
    public function collection(){
        return CourseHistory::all();
    }

    public function map($course_history) :array{
        return[
            $course_history->id,
            $course_history->title,
            $course_history->status,
            $course_history->created_at->format('d/m/Y'),
            $course_history->updated_at->format('d/m/Y'),
        ];
    }

    public function headings():array
    {
        return[
            'Id',
            'Τίτλος',
            'Κατάσταση Μαθήματος',
            'Ημερομηνία Δημιουργίας',
            'Ημερομηνία Επεξεργασίας',
        ];
    }

    public function styles(Worksheet $sheet){
        $rows = CourseHistory::count() + 1;

        for($number = 2; $number <= $rows; $number++){
            $status = $sheet->getCell("C$number")->getValue();

            if($status === 'Ενεργό'){
                $sheet->getStyle("C$number")->getFont()->getColor()->setRGB('00AA00');
            }

            if($status === 'Διεγεγραμένο'){
                $sheet->getStyle("C$number")->getFont()->getColor()->setRGB('FF0000');
            }

            if($status === 'Μη Ενεργό'){
                $sheet->getStyle("C$number")->getFont()->getColor()->setRGB('0dcaf0');
            }
        }

        $sheet->getStyle('A1:E1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => [
                    'rgb' => '000000',
                ],
            ]
        ]);
    }
}
