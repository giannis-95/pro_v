<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UsersExport implements FromCollection,WithMapping,WithHeadings,WithStyles{
    public function collection(){
        return User::all();
    }

    public function map($user): array
    {
        return [
            $user->id,
            $user->name,
            $user->email,
            $user->created_at->format('d/m/Y'),
            $user->updated_at->format('d/m/Y'),
        ];
    }

    public function headings(): array
    {
        return [
            'ID',
            'Όνομα',
            'Email',
            'Ημερομηνία Εγγραφής',
            'Ημερομηνία Ενημέρωσης'
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
