<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CasesExport implements FromCollection, WithMapping, ShouldAutoSize,WithHeadings
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
            $row->numJuridiction,
            $row->votreReference,
            $row->typeJuridiction,
            $row->villeJuridiction,
            $row->sectionJuridiction,
            $row->etatProcedurale,
            $row->dateEtatProcedurale,
            $row->client,
            $row->adversaire,
            // Add more columns as needed
        ];
    }

    public function headings(): array
    {
        // Modify the headings array according to your table structure
        return [
            ' ملف عدد',
            ' مرجعكم',
            ' النوع',
            ' المدينة',
            ' القسم',
            ' الحالة الإجرائية',
            ' تاريخ الحالة الإجرائية',
            ' المدعي',
            ' المدعى عليه',



            // Add more column headings as needed
        ];
    }
}
