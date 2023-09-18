<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Session;

use Illuminate\Http\Request;

class SessionController extends Controller
{
    public function storeDataInSession(Request $request)
    {
        $data = $request->input('data');
        Session::put('sheetData', $data);

        return response()->json(['message' => 'Data stored in session successfully']);
    }

    public function deleteSessionData() {
        Session::forget(['sheetFileName', 'sheetData']);
        return response()->json(['message' => 'Data removed from session successfully']);
    }
}