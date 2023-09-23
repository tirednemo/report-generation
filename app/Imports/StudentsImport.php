<?php

namespace App\Imports;

use App\Models\Student;
use Illuminate\Support\Collection;

use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;

class StudentsImport implements ToCollection, WithHeadingRow, WithChunkReading, WithBatchInserts
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            Student::create([
                'id' => $row['id'],
                'name' => $row['name'],
                'major' => $row['major']
            ]);
        }
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public function batchSize(): int
    {
        return 1000;
    }
}
