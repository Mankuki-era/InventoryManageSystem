<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\ItemsImport;
use Excel;

class ImportExcelController extends Controller
{

    public function import(Request $request){
        $file = $request->file;

        Excel::import(new ItemsImport, $file);
    }
}
