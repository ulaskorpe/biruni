<?php

namespace App\Exports;

use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExportFormEntries implements FromArray, WithHeadings, WithMapping, WithStyles
{

    protected $entries;
    protected $jsonHeads;

    public function __construct(array $entries, $jsonHeads)
    {
        $this->entries = $entries;
        $this->jsonHeads = $jsonHeads;
    }

    public function array(): array
    {
        return $this->entries;
    }

    public function headings(): array
    {
        // Sabit başlıklar
        $defaultHeaders = [
            'ID',
            'IP',
            'Tarih',
        ];

        $dynamicHeaders = [];

        foreach ($this->jsonHeads as $key => $item) {

            $dynamicHeaders[] = $item['itemLabel'];
        }

        $dynamicHeaders[] = "RAW DATA";

        // Sabit başlıklar ile dinamik JSON başlıklarını birleştiriyoruz
        return array_merge($defaultHeaders, $dynamicHeaders);
    }

    public function map($row): array
    {
        // Sabit veriler
        $mappedRow = [
            $row['id'],
            $row['ip_address'],
            Carbon::parse($row['created_at'])->setTimezone('Europe/Istanbul'),
        ];

        // Dinamik JSON kolonlarını işlemek
        foreach ($this->jsonHeads as $jsonHead) {

            $rowJsonValue = null;
            if (isset($jsonHead['itemInputName'])) {
                $rowJsonValue = Arr::first($row['json_data'], function ($value, $key) use ($jsonHead) {
                    return $value['name'] === $jsonHead['itemInputName'];
                });
            }

            $mappedRow[] = $rowJsonValue ? $rowJsonValue['value'] : null;
        }

        $mappedRow[] = json_encode($row['json_data'], JSON_UNESCAPED_UNICODE);

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
