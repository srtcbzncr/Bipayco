<?php

namespace App\Http\Controllers\API\Search;

use App\Http\Controllers\Controller;
use App\Repositories\Search\SearchRepository;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request){
        $data = $request->toArray();
        $tag = $data['tag'];
        $tags = explode(" ",$tag); // burada search bölümüne yazılan her bir kelime var.
        $repo = new SearchRepository();

        $resp = $repo->search($tags);
        if($resp->getResult()){
            return response()->json([
               'error' => false,
               'message' => 'Kurslar başarıyla getirildi',
               'data' => $resp->getData()
            ]);
        }

        return response()->json([
            'error' => false,
            'message' => 'Kurslar getirilirken bir hata meydana geldi.Tekrar dene.',
            'errorMessage' => $resp->getError()
        ],400);

    }
}
