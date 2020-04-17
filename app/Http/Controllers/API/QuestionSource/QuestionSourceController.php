<?php

namespace App\Http\Controllers\API\QuestionSource;

use App\Http\Controllers\Controller;
use App\Models\QuestionSource\Question;
use App\Repositories\QuestionSource\QuestionSourceRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class QuestionSourceController extends Controller
{
    public function create(Request $request){
        // Initializing
        $repo = new QuestionSourceRepository();
        $data = $request->toArray();

        $resp=null;

        if($data['type'] == 'singleChoice'){
            $resp=$repo->createSingle($data);
        }
        else if($data['type'] == 'multiChoice'){
            $resp=$repo->createMulti($data);
        }
        else if($data['type'] == 'fillBlank'){
            $resp=$repo->createGap($data);
        }
        else if($data['type'] == 'trueFalse'){
            $resp=$repo->createTrueFalse($data);
        }
        else if($data['type'] == 'match'){
            $resp=$repo->createMatch($data);
        }
        else if($data['type'] == 'order'){
            $resp=$repo->createOrder($data);
        }

        // Operations
        if($resp!=null  and $resp->getResult()){
            return response()->json([
                'error' => false,
                'message' => 'Soru başarıyla oluşturuldu.',
                'data' => $resp->getData()
            ]);
        }
        return response()->json([
            'error' => true,
            'message' => 'Soru oluşturulurken hata meydana geldi.Tekrar deneyin',
            'errorMessage' => $resp->getError()
        ],400);

    }

    public function delete($id){
        // Initializing
        $repo = new QuestionSourceRepository();

        // Operations
        $resp = $repo->delete($id);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'message' => 'Soru başarıyla silindi.',
                'data' => $resp->getData()
            ]);
        }
        return response()->json([
            'error' => true,
            'message' => 'Soru silinirken hata meydana geldi.Tekrar deneyin',
        ],400);
    }

    public function getQuestions($id){
        // Initializing
        $repo = new QuestionSourceRepository();

        // Operations
        $resp = $repo->get($id);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'message' => 'Sorular başarıyla getirildi.',
                'data' => $resp->getData()
            ]);
        }
        return response()->json([
            'error' => true,
            'message' => 'Sorular getirilirken hata meydana geldi.Tekrar deneyin',
            'errorMessage' => $resp->getError()
        ],400);
    }

    public function getQuestion($id){
        // Initializing
        $repo = new QuestionSourceRepository();
        $resp = null;

        // Operations
        $question = Question::find($id);
        if($question->type == 'App\Models\QuestionSource\SingleChoice'){
            $resp = $repo->getSingle($id);
        }
        else if($question->type == 'App\Models\QuestionSource\MultiChoice') {
            $resp = $repo->getMulti($id);
        }
        else if($question->type == 'App\Models\QuestionSource\GapFilling'){
            $resp = $repo->getGap($id);
        }
        else if($question->type == 'App\Models\QuestionSource\TrueFalse'){
            $resp = $repo->getTrueFalse($id);
        }
        else if($question->type == 'App\Models\QuestionSource\Match'){
            $resp = $repo->getMatch($id);
        }
        else if($question->type == 'App\Models\QuestionSource\Order'){
            $resp = $repo->getOrder($id);
        }

        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'message' => 'Soru başarıyla getirildi.',
                'data' => $resp->getData()
            ]);
        }
        return response()->json([
            'error' => true,
            'message' => 'Soru getirilirken hata meydana geldi.Tekrar deneyin',
        ],400);
    }

    public function update($id,Request $request)
    {
        // Initializing
        $repo = new QuestionSourceRepository();
        $data = $request->toArray();
        $resp = null;

        if($data['type'] == 'singleChoice'){
            $resp=$repo->updateSingle($id,$data);
        }
        else if($data['type'] == 'multiChoice'){
            $resp=$repo->updateMulti($id,$data);
        }
        else if($data['type'] == 'fillBlank'){
            $resp=$repo->updateGap($id,$data);
        }
        else if($data['type'] == "trueFalse"){
            $resp=$repo->updateTrueFalse($id,$data);
        }
        else if($data['type'] == 'match'){
            $resp=$repo->updateMatch($id,$data);
        }
        else if($data['type'] == 'order'){
            $resp=$repo->updateOrder($id,$data);
        }

        // Operations
        if($resp!=null and $resp->getResult()){
            return response()->json([
                'error' => false,
                'message' => 'Soru başarıyla güncellendi.',
                'data' => $resp->getData()
            ]);
        }
        return response()->json([
            'error' => true,
            'message' => 'Soru güncellenirken hata meydana geldi.Tekrar deneyin',
            'errorMessage' => $resp->getError()
        ],400);
    }

}
