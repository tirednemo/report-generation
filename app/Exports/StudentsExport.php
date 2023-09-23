<?php

namespace App\Exports;
use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StudentsExport implements FromQuery, WithTitle,  WithHeadings
{
    public function query()
    {
        return Student::query();
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'student';
    }

    public function headings(): array
    {
        return [
            'id',
            'name',
            'major',
        ];
    }
}
