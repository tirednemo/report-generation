<?php

namespace App\Imports;

use App\Models\Teacher;
use Illuminate\Support\Collection;

use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;

class TeachersImport implements ToCollection, WithHeadingRow, WithChunkReading, WithBatchInserts
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {
           Teacher::create([
               'id' => $row['id'],
               'name' => $row['name'],
               'department' => $row['department']
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