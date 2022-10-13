<?php

namespace App\Http\Controllers;

use App\Models\University;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public  function index(){
        $universities = University::all();
        return view('welcome')->with(
            'universities', $universities
        );
    }

    public function getDomain($id){
        $univ = University::findOrFail($id);
        return response()->json($univ->domains);
    }

    public function getWebPages($id){
        $univ = University::findOrFail($id);
        return response()->json($univ->webpages);
    }
}
