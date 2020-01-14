<?php

namespace App\Http\Controllers\API\GeneralEducation;

use App\Http\Controllers\Controller;
use App\Http\Resources\GE_CommentResource;
use App\Http\Resources\GE_CourseCollection;
use App\Http\Resources\GE_CourseResource;
use App\Models\GeneralEducation\Course;
use App\Repositories\Auth\UserRepository;
use App\Repositories\GeneralEducation\CourseRepository;
use Illuminate\Http\Request;

class CourseController extends Controller
{

    public function getPopularCourses(){
        // Repo initialization
        $repo = new CourseRepository;

        // Operations
        $resp = $repo->getPopularCourses();

        // Response
        if($resp->getResult()){
            return GE_CourseResource::collection($resp->getData());
        }
        else{
            return response()->json(['error' => true, 'message' => $resp->getError()->getMessage()]);
        }
    }

    public function getByCategoryFilterByNewest($category_id){
        // Repo initialization
        $repo = new CourseRepository;

        // Operations
        $resp = $repo->getByCategoryFilterByNewest($category_id);

        // Response
        if($resp->getResult()){
            return GE_CourseResource::collection($resp->getData());
        }
        else{
            return response()->json(['error' => true, 'message' => $resp->getError()->getMessage()]);
        }
    }

    public function getByCategoryFilterByOldest($category_id){
        // Repo initialization
        $repo = new CourseRepository;

        // Operations
        $resp = $repo->getByCategoryFilterByOldest($category_id);

        // Response
        if($resp->getResult()){
            return GE_CourseResource::collection($resp->getData());
        }
        else{
            return response()->json(['error' => true, 'message' => $resp->getError()->getMessage()]);
        }
    }

    public function getByCategoryFilterByPriceASC($category_id){
        // Repo initialization
        $repo = new CourseRepository;

        // Operations
        $resp = $repo->getByCategoryFilterByPriceASC($category_id);

        // Response
        if($resp->getResult()){
            return GE_CourseResource::collection($resp->getData());
        }
        else{
            return response()->json(['error' => true, 'message' => $resp->getError()->getMessage()]);
        }
    }

    public function getByCategoryFilterByPriceDESC($category_id){
        // Repo initialization
        $repo = new CourseRepository;

        // Operations
        $resp = $repo->getByCategoryFilterByPriceDESC($category_id);
        //dd($resp);

        // Response
        if($resp->getResult()){
            return GE_CourseResource::collection($resp->getData());
        }
        else{
            return response()->json(['error' => true, 'message' => $resp->getError()->getMessage()]);
        }
    }

    public function getByCategoryFilterByPoint($category_id){
        // Repo initialization
        $repo = new CourseRepository;

        // Operations
        $resp = $repo->getByCategoryFilterByPoint($category_id);

        // Response
        if($resp->getResult()){
            return GE_CourseResource::collection($resp->getData());
        }
        else{
            return response()->json(['error' => true, 'message' => $resp->getError()->getMessage()]);
        }
    }

    public function getByCategoryFilterByPurchases($category_id){
        // Repo initialization
        $repo = new CourseRepository;

        // Operations
        $resp = $repo->getByCategoryFilterByPurchases($category_id);

        // Response
        if($resp->getResult()){
            return GE_CourseResource::collection($resp->getData());
        }
        else{
            return response()->json(['error' => true, 'message' => $resp->getError()->getMessage()]);
        }
    }

    public function getByCategoryFilterByTrending($category_id){
        // Repo initialization
        $repo = new CourseRepository;

        // Operations
        $resp = $repo->getByCategoryFilterByTrending($category_id);

        // Response
        if($resp->getResult()){
            return GE_CourseResource::collection($resp->getData());
        }
        else{
            return response()->json(['error' => true, 'message' => $resp->getError()->getMessage()]);
        }
    }

    public function getBySubCategoryFilterByNewest($sub_category_id){
        // Repo initialization
        $repo = new CourseRepository;

        // Operations
        $resp = $repo->getBySubCategoryFilterByNewest($sub_category_id);

        // Response
        if($resp->getResult()){
            return GE_CourseResource::collection($resp->getData());
        }
        else{
            return response()->json(['error' => true, 'message' => $resp->getError()->getMessage()]);
        }
    }

    public function getBySubCategoryFilterByOldest($sub_category_id){
        // Repo initialization
        $repo = new CourseRepository;

        // Operations
        $resp = $repo->getBySubCategoryFilterByOldest($sub_category_id);

        // Response
        if($resp->getResult()){
            return GE_CourseResource::collection($resp->getData());
        }
        else{
            return response()->json(['error' => true, 'message' => $resp->getError()->getMessage()]);
        }
    }

    public function getBySubCategoryFilterByPriceASC($sub_category_id){
        // Repo initialization
        $repo = new CourseRepository;

        // Operations
        $resp = $repo->getBySubCategoryFilterByPriceASC($sub_category_id);

        // Response
        if($resp->getResult()){
            return GE_CourseResource::collection($resp->getData());
        }
        else{
            return response()->json(['error' => true, 'message' => $resp->getError()->getMessage()]);
        }
    }

    public function getBySubCategoryFilterByPriceDESC($sub_category_id){
        // Repo initialization
        $repo = new CourseRepository;

        // Operations
        $resp = $repo->getBySubCategoryFilterByPriceDESC($sub_category_id);

        // Response
        if($resp->getResult()){
            return GE_CourseResource::collection($resp->getData());
        }
        else{
            return response()->json(['error' => true, 'message' => $resp->getError()->getMessage()]);
        }
    }

    public function getBySubCategoryFilterByPoint($sub_category_id){
        // Repo initialization
        $repo = new CourseRepository;

        // Operations
        $resp = $repo->getBySubCategoryFilterByPoint($sub_category_id);

        // Response
        if($resp->getResult()){
            return GE_CourseResource::collection($resp->getData());
        }
        else{
            return response()->json(['error' => true, 'message' => $resp->getError()->getMessage()]);
        }
    }

    public function getBySubCategoryFilterByPurchases($sub_category_id){
        // Repo initialization
        $repo = new CourseRepository;

        // Operations
        $resp = $repo->getBySubCategoryFilterByPurchases($sub_category_id);

        // Response
        if($resp->getResult()){
            return GE_CourseResource::collection($resp->getData());
        }
        else{
            return response()->json(['error' => true, 'message' => $resp->getError()->getMessage()]);
        }
    }

    public function getBySubCategoryFilterByTrending($sub_category_id){
        // Repo initialization
        $repo = new CourseRepository;

        // Operations
        $resp = $repo->getBySubCategoryFilterByTrending($sub_category_id);

        // Response
        if($resp->getResult()){
            return GE_CourseResource::collection($resp->getData());
        }
        else{
            return response()->json(['error' => true, 'message' => $resp->getError()->getMessage()]);
        }
    }

    public function getComments($id){
        // Repo initialization
        $repo = new CourseRepository;

        // Operations
        $resp = $repo->getCommentsWithPaginate($id);

        // Response
        if($resp->getResult()){
            return GE_CommentResource::collection($resp->getData());
        }
        else{
            return response()->json(['error' => true, 'message' => $resp->getError()->getMessage()]);
        }
    }

    public function canEntry($id, $user_id){
        // Repo initialization
        $courseRepo = new CourseRepository;
        $userRepo = new UserRepository;

        // Operations
        $courseResp = $courseRepo->get($id);
        $userResp = $userRepo->get($user_id);

        // Response
        if($courseResp->getResult() and $userResp->getResult()){
            $user = $userResp->getData();
            $course = $courseResp->getData();
            return response()->json(['error' => false, 'result' => $user->can('entry', $course)]);
        }
        else{
            return response()->json(['error' => true, 'message' => 'Bir hata oluştu.']);
        }
    }

    public function canComment($id, $user_id){
        // Repo initialization
        $courseRepo = new CourseRepository;
        $userRepo = new UserRepository;

        // Operations
        $courseResp = $courseRepo->get($id);
        $userResp = $userRepo->get($user_id);

        // Response
        if($courseResp->getResult() and $userResp->getResult()){
            $user = $userResp->getData();
            $course = $courseResp->getData();
            return response()->json(['error' => false, 'result' => $user->can('comment', $course)]);
        }
        else{
            return response()->json(['error' => true, 'message' => 'Bir hata oluştu.']);
        }
    }

    public function createPost($id = null,Request $request){
        $course = null;
        if($id==null){
            $course = new Course();
            $course->image = $request->image;
            $course->name = $request->name;
            $course->description = $request->description;
            $course->access_time = $request->access_time;
            $course->certificate = $request->certificate;
            $course->price = $request->price;
            $course->category_id = $request->category_id;
            $course->sub_category_id = $request->sub_category_id;
            $course->save();
            return response()->json([
                'error' => false,
                'result' => $course,
                'message' => 'Kurs oluşturuldu.'
            ]);
        }
        else{
            $course = Course::find($id);
            if($course==null){
                return response()->json([
                   'error' => true,
                   'message' => 'id = '.$id.' kurs yok.'
                ]);
            }
            else{
                $course->image = $request->image;
                $course->name = $request->name;
                $course->description = $request->description;
                $course->access_time = $request->access_time;
                $course->certificate = $request->certificate;
                $course->price = $request->price;
                $course->category_id = $request->category_id;
                $course->sub_category_id = $request->sub_category_id;
                $course->save();
                return response()->json([
                   'error' => false,
                   'result' => $course,
                   'message' => 'Kurs başarıyla güncellendi'
                ]);
            }
        }
    }
}
