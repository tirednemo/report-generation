<?php

namespace App\Jobs;

use Throwable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\SheetsImport;


class ImportExcelFile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $storagePath;
    protected $fileName;

    /**
     * Create a new job instance.
     */
    public function __construct($storagePath, $fileName)
    {
        $this->storagePath = $storagePath;
        $this->fileName = $fileName;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $path = storage_path('app/' . $this->storagePath . $this->fileName);
        if (file_exists($path)) {
            Excel::import(new SheetsImport, $path);
            echo "Importing {$this->fileName}";
        }
    }

    public function failed(Throwable $exception): void
    {
        // handle failed export
    }
}
