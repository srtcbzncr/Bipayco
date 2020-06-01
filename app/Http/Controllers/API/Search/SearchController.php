<?php

namespace App\Http\Controllers\API\Search;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request){
        $data = $request->toArray();
        $tag = $data['tag'];
        $tags = explode(" ",$tag); // burada search bölümüne yazılan her bir kelime var.


    }
}
