<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RomaController extends Controller
{
    //
    public function getdata(Request $request)
    {
        $name=$request->input('entity');
        $data = file_get_contents('/opt/lampp/htdocs/laravel/public/KGGraph_files/data/data.json');
        echo $data;
    }
    public function getconcepts(Request $request)
    {
        $name=$request->input('entity');
        $data = file_get_contents('/opt/lampp/htdocs/laravel/public/KGGraph_files/data/data2.json');
        echo $data;
    }
}
