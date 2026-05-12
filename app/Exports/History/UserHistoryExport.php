<?php

namespace App\Exports\History;

use App\Models\History\UserHistory;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UserHistoryExport implements FromCollection,WithMapping,WithHeadings,WithStyles{
    public function collection(){
        return UserHistory::all();
    }

    public function map($user_history): array
    {
        return [
            $user_history->id,
            $user_history->name,
            $user_history->email,
            $user_history->role,
            $user_history->status,
            $user_history->created_at->format('m/d/Y'),
            $user_history->updated_at->format('m/d/Y')
        ];
    }

    public function headings(): array
    {
        return[
            'Id',
            'Όνομα',
            'Email',
            'Ρόλος',
            'Κατάσταση',
            'Ημερομηνία Δημιουγίας',
            'Ημερομηνία Επεξεργασίας'
        ];
    }

    public function styles(Worksheet $sheet){
        $users_histroy_count = UserHistory::count()+1;

        for($number = 2; $number<=$users_histroy_count; $number++){
            $status = $sheet->getCell("E$number")->getValue();

            if($status == 'Ενεργός'){
                $sheet->getStyle("E$number")->getFont()->getColor()->setRGB('00AA00');
            }

            if($status == 'Διεγεγραμένος'){
                $sheet->getStyle("E$number")->getFont()->getColor()->setRGB('FF0000');
            }

            if($status == 'Μη Ενεργός'){
                $sheet->getStyle("E$number")->getFont()->getColor()->setRGB('0dcaf0');
            }
        }

        $sheet->getStyle('A1:G1')->applyFromArray([
            'font' => [
              'bold' => true,
                'color' => [
                    'rgb' => '000000',
                ],
            ]
        ]);
    }
}
