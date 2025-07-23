<?php

namespace App\Exports;

use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExportCustomers implements FromArray, WithHeadings, WithMapping, WithStyles
{

    protected $users;

    public function __construct(array $users)
    {
        $this->users = $users;
    }

    public function array(): array
    {
        return $this->users;
    }

    public function headings(): array
    {
        // Sabit başlıklar
        $defaultHeaders = [
            'ID',
            'Üyelik Tarihi',
            'İsim',
            'Email',
            'Telefon',
        ];

        return $defaultHeaders;
    }

    public function map($row): array
    {
        // Sabit veriler
        $mappedRow = [
            $row['id'],
            Carbon::parse($row['created_at'])->setTimezone('Europe/Istanbul'),
            $row['name'],
            $row['email'],
            $row['phone'],
        ];

        return $mappedRow;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1 => [
                'font' => [
                    'bold' => true,
                    'size' => 13
                ]
            ],

            // Styling a specific cell by coordinate.
            //'B2' => ['font' => ['italic' => true]],

            // Styling an entire column.
            //'C'  => ['font' => ['size' => 16]],
        ];
    }
}
