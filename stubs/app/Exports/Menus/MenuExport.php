<?php

namespace App\Exports\Menus;

use Tripteki\Menu\Models\Menu;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class MenuExport implements FromCollection, ShouldAutoSize, WithStyles, WithHeadings, WithStrictNullComparison
{
    /**
     * @param \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $sheet
     * @return array
     */
    public function styles(Worksheet $sheet)
    {
        return [

            1 => [ "font" => [ "bold" => true, ], ],
        ];
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [

            "Platform",
            "Route",
            "Position",
            "Title",
            "Metadata",
            "Description",
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function collection()
    {
        return Menu::all([

            "platform",
            "route",
            "nth",
            "title",
            "metadata",
            "description",
        ]);
    }
};
