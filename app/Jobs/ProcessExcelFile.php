<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Models\Sheet;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ProcessExcelFile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $sheet;
    protected $fileName;
    protected $sheetName;

    /**
     * Create a new job instance.
     */
    public function __construct(Sheet $sheet, $fileName)
    {
        $this->sheet = $sheet;
        $this->fileName = $fileName;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {       
        $spreadsheet = IOFactory::load(storage_path('app/sheets/' .$this->fileName));

        $sheetNames = $spreadsheet->getSheetNames();

        foreach ($sheetNames as $sheetName) {
            $worksheet = $spreadsheet->getSheetByName($sheetName);
            $data = $worksheet->toArray();

            if (!Schema::hasTable($sheetName)) {
                Schema::create($sheetName, function (Blueprint $table) use ($data) {
                    $table->string('sheet_id');
                    foreach ($data[0] as $header) {
                        $table->string($header);
                    }
                });
            }

            $chunkSize = 1000;
            $totalRows = count($data) - 1; 
        
            for ($offset = 1; $offset <= $totalRows; $offset += $chunkSize) {
                $chunk = array_slice($data, $offset, $chunkSize);
        
                $tableData = [];
                foreach ($chunk as $row) {
                    $rowData = ['sheet_id' => $this->sheet->id];
                    foreach ($data[0] as $index => $header) {
                        $rowData[$header] = $row[$index];
                    }
                    $tableData[] = $rowData;
                }
        
                DB::table($sheetName)->insert($tableData);
            }
        }
    }
}
