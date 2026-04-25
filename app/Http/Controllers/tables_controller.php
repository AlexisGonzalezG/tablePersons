<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Status;
use Illuminate\Support\Facades\DB;

class tables_controller extends Controller
{
    public function status_list(Request $request) {

        $list = DB::select('select status,value from status');

        return $list;
 
        

    }
}
