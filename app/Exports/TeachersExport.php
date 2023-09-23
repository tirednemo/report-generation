<?php

namespace App\Exports;
use App\Models\Teacher;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TeachersExport implements FromQuery, WithTitle, WithHeadings
{

    // public function collection()
    // {
    //     return Teacher::all();
    // }

    public function query()
    {
        return Teacher::query();
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'teacher';
    }

    public function headings(): array
    {
        return [
            'id',
            'name',
            'department',
        ];
    }
}
