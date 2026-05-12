<?php

namespace App\Exports\History;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\History\AnnouncementHistory;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AnnouncementHistoryExport implements WithHeadings,WithMapping,WithStyles,FromCollection{
    public function collection(){
        return AnnouncementHistory::all();
    }

    public function headings() :array
    {
        return[
            'ID',
            'Τίτλος',
            'Καθηγητής',
            'Μάθημα',
            'Κατάσταση Ανακοίνωσης',
            'Ημερομηνία Δημιουργίας',
            'Ημερομηνία Ενημέρωσης',
        ];
    }

    public function map($anouncement_histoy) :array
    {
        return [
            $anouncement_histoy->id,
            $anouncement_histoy->title,
            $anouncement_histoy->user,
            $anouncement_histoy->course,
            $anouncement_histoy->status,
            $anouncement_histoy->created_at->format('d-m-Y'),
            $anouncement_histoy->updated_at->format('d-m-Y')
        ];
    }

    public function styles(Worksheet $sheet){
        $anouncement_histor_count = AnnouncementHistory::count() +1;

        for($number = 2; $number <= $anouncement_histor_count; $number++){
            $status = $sheet->getCell("E$number")->getValue();

            if($status == 'Ενεργή'){
                $sheet->getStyle("E$number")->getFont()->getColor()->setRGB('00AA00');
            }

            if($status == 'Διαγραμμένη'){
                $sheet->getStyle("E$number")->getFont()->getColor()->setRGB('FF0000');
            }
        }

        $sheet->getStyle('A1:G1')->applyFromArray([
            'font'=>[
                'bold' => true,
                'color'=>[
                    'rgb' => '000000',
                ]
            ]
        ]);
    }
}
