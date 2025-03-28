<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UsersExport implements FromCollection, WithHeadings, WithStyles
{
    public function collection()
    {
        $users = User::orderBy('created_at', 'desc')->get();

        return $users->map(function ($user) {
            return [
                'ID'               => $user->id,
                'Name'             => $user->name,
                'Email'            => $user->email,
                'Email Verified At'=> $user->email_verified_at ?? 'Not Verified',
                'Mobile'           => $user->mobile,
                'Reg Number'       => $user->reg_number,
                'Registered'       => $user->registered ?? 'Not Registered',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID', 'Name', 'Email', 'Email Verified At', 'Mobile', 'Reg Number', 'Registered'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $headerRange = 'A1:' . $sheet->getHighestColumn() . '1';

        // Bold header row
        $sheet->getStyle($headerRange)->getFont()->setBold(true);

        // Center header text
        $sheet->getStyle($headerRange)->getAlignment()
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
            ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

        // Auto-size columns
        foreach (range('A', $sheet->getHighestColumn()) as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        return [];
    }
}
