<?php

namespace App\Http\Controllers\API\PrepareLessons;

use App\Http\Controllers\Controller;
use App\Models\PrepareLessons\Course;
use App\Repositories\PrepareLessons\CommentRepository;
use App\Repositories\PrepareLessons\CourseRepository;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function create(Request $request){
        // Repo initialization
        $repo = new CommentRepository;

        if($request->has('content') and $request->has('point')){
            $array = $request->toArray();
            $array['course'] = Course::find($request->course_id);
            // Operations
            $resp = $repo->create($array);

            // Response
            if($resp->getResult()){
                return response()->json(['error' => false, 'message' => 'Yorum oluşturuldu']);
            }
            else{
                return response()->json(['error' => true, 'message' => $resp->getError()]);
            }
        }
        else{
            return response()->json(['error' => false, 'message' => 'Lütfen alanları eksiksiz doldurun.']);
        }
    }

    public function delete($id){
        // Repo initialization
        $repo = new CommentRepository;

        $resp = $repo->delete($id);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'message' => 'Yorum silindi'
            ]);
        }

        return response()->json([
            'error' => true,
            'errorMessage' => $resp->getError()
        ],400);
    }

    public function update($id,Request $request){
        // Repo initialization
        $repo = new CommentRepository;

        $resp = $repo->update($id,$request->toArray());
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'message' => 'Yorum güncellendi'
            ]);
        }

        return response()->json([
            'error' => true,
            'errorMessage' => $resp->getError()
        ],400);
    }

    public function getComments($courseId){
        // Repo initialization
        $repo = new CourseRepository;

        // Operations
        $resp = $repo->getCommentsWithPaginate($courseId);

        // Response
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'data' => $resp->getData()
            ]);
            // return GE_CommentResource::collection($resp->getData());
        }
        else{
            return response()->json(['error' => true, 'message' => $resp->getError()],400);
        }
    }
}
