<?php

namespace App\Exports;

use App\Models\EventRegistration;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class EventAttendeesExport implements FromCollection, WithHeadings, WithStyles
{
    protected $eventId;

    public function __construct($eventId)
    {
        $this->eventId = $eventId;
    }

    public function collection()
    {
        $attendees = EventRegistration::where('event_id', $this->eventId)
            ->with('user:id,mobile') // Eager load user relation with only the phone field
            ->select('id', 'user_id', 'prefered_name', 'email', 'receipt_number', 'amount_paid', 'created_at')
            ->orderBy('created_at', 'asc')
            ->get();

        // Add user phone number to each row
        return $attendees->map(function ($attendee) {
            return [
                'ID'            => $attendee->id,
                'User ID'       => $attendee->user_id,
                'Preferred Name'=> $attendee->prefered_name,
                'Email'         => $attendee->email,
                'Receipt Number'=> $attendee->receipt_number,
                'Amount Paid'   => $attendee->amount_paid,
                'Phone'         => $attendee->user?->mobile ?? 'N/A', // Handle cases where user may not exist
                'Created At'    => $attendee->created_at,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID', 'User ID', 'Preferred Name', 'Email', 'Receipt Number', 'Amount Paid', 'Phone', 'Created At'
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
