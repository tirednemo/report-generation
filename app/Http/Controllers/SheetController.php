<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Jobs\ImportExcelFile;
use App\Exports\SheetsExport;
use App\Http\Controllers\Controller;


class SheetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        //
    }


    public function import(Request $request)
    {
        $request->validate([
            'sheet' => 'required|mimes:xlsx,xls|max:204800',
        ], [
            'sheet.required' => 'What are you doing? You have to select a file.',
            'sheet.mimes' => 'The file must be a file of type: xlsx.',
            'sheet.max' => 'The file may not be greater than 2 MB.',
        ]);

        if ($request->file('sheet')->isValid()) {
            $file = $request->file('sheet');
            $fileName = $file->getClientOriginalName();

            $storagePath = 'sheets/';
            $file->storeAs($storagePath, $fileName, 'local');

            ImportExcelFile::dispatch($storagePath, $fileName);
            return redirect()->back()->with('success', 'Spreadsheet is being uploaded.');
        }
        return redirect()->back()->with('error', 'Failed to upload.');
    }


    public function export()
    {
        $fileName = 'report.xlsx';
        return (new SheetsExport)->download($fileName);
    }
}
