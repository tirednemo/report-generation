<?php

namespace App\Jobs;

use Illuminate\Bus\Batchable;
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
    use Dispatchable, Batchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;
    protected $sheetName;
    protected $sheet;

    /**
     * Create a new job instance.
     */
    public function __construct($data, $sheetName, Sheet $sheet)
    {
        $this->data = $data;
        $this->sheetName = $sheetName;
        $this->sheet = $sheet;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $tableData = [];
        foreach ($this->data as $row) {
            $rowData = ['sheet_id' => $this->sheet->id];
            foreach ($this->data[0] as $index => $header) {
                $rowData[$header] = $row[$index];
            }
            $tableData[] = $rowData;
        }
        
        DB::table($this->sheetName)->insert($tableData);
    }
}
