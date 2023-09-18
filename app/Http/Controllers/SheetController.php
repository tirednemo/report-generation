<?php

namespace App\Http\Controllers;

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

use App\Jobs\ProcessExcelFile;


class SheetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('sheets.index', [
            'sheets' => Sheet::latest()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('sheets.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'sheet' => 'required|mimes:xlsx,xls|max:102400',
        ], [
            'sheet.required' => 'What are you doing? You have to select a file.',
            'sheet.mimes' => 'The file must be a file of type: xlsx.',
            'sheet.max' => 'The file may not be greater than 2 MB.',
        ]);

        if ($request->file('sheet')->isValid()) {
            $file = $request->file('sheet');
            $fileName = time() . '_' . $file->getClientOriginalName();

            $sheet = new Sheet;
            $sheet->file_name = $fileName;
            $sheet->save();

            $storagePath = 'sheets/';
            $file->storeAs($storagePath, $fileName, 'local');

            if (file_exists(storage_path('app/' . $storagePath . $fileName))) {

                ProcessExcelFile::dispatch($sheet, $fileName);

                Session::put('sheetFileName', $fileName);
                return redirect()->back()->with('success', 'Data from the spreadsheet stored successfully.');
            }
        }

        return redirect()->back()->with('error', 'Failed to upload.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Sheet $sheet)
    {
        $tableNames = DB::select('SHOW TABLES');
        $tableNames = array_map('current', $tableNames);

        $spreadsheet = new Spreadsheet();
        $spreadsheet->removeSheetByIndex(0);

        foreach ($tableNames as $tableName) {
            if ($tableName != 'migrations' && $tableName != 'personal_access_tokens' && $tableName != 'sheets') {
                $hasEntries = DB::table($tableName)->where('sheet_id', $sheet->id)->exists();

                if ($hasEntries) {
                    $worksheet = $spreadsheet->createSheet();
                    $worksheet->setTitle($tableName);

                    $tableData = DB::table($tableName)->where('sheet_id', $sheet->id)->get()->toArray();

                    if (!empty($tableData)) {
                        $headers = array_keys((array) $tableData[0]);
                        $worksheet->fromArray([$headers], null, 'A1');
                        $data = [];
                        foreach ($tableData as $row) {
                            $data[] = (array) $row;
                        }
                        $worksheet->fromArray($data, null, 'A2');
                    }
                }
            }
        }

        $response = response()->stream(
            function () use ($spreadsheet) {
                $writer = new Xlsx($spreadsheet);
                $writer->save('php://output');
            },
            200,
            [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'attachment; filename="exported_data.xlsx"',
            ]
        );

        return $response;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sheet $sheet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sheet $sheet)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sheet $sheet)
    {
        //
    }
}
