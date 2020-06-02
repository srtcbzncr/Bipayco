<?php

namespace App\Http\Controllers\Search;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    public function search(Request $request){
        $data = $request->toArray();
        $tag = $data['search'];
        $userId = Auth::id();
        return view('search')->with('tag',$tag)->with('userId',$userId);
    }
}
