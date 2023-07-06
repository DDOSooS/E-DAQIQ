<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TableExport implements FromCollection, WithMapping, ShouldAutoSize,WithHeadings
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data;
    }

    public function map($row): array
    {
        // Modify the mapping logic according to your table structure
        return [
            $row->nReference,
            $row->vReference,
            $row->ice,
            $row->adresse,
            $row->telephone,
            // Add more columns as needed
        ];
    }

    public function headings(): array
    {
        // Modify the headings array according to your table structure
        return [
            ' مرجعنا',
            ' مرجعكم',
            ' ice',
            ' العنوان',
            ' الهاتف',

            // Add more column headings as needed
        ];
    }
}
