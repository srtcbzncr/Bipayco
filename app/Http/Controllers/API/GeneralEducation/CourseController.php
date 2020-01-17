<?php

namespace App\Http\Controllers\API\GeneralEducation;

use App\Http\Controllers\Controller;
use App\Http\Resources\GE_CommentResource;
use App\Http\Resources\GE_CourseCollection;
use App\Http\Resources\GE_CourseResource;
use App\Models\GeneralEducation\Course;
use App\Repositories\Auth\UserRepository;
use App\Repositories\GeneralEducation\AchievementRepository;
use App\Repositories\GeneralEducation\CourseRepository;
use App\Repositories\GeneralEducation\LessonRepository;
use App\Repositories\GeneralEducation\RequirementRepository;
use App\Repositories\GeneralEducation\SectionRepository;
use App\Repositories\GeneralEducation\SourceRepository;
use App\Repositories\GeneralEducation\TagRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        if($id==null){
            $user = Auth::user();
            $repoCourse = new CourseRepository();
            $data = $request->toArray();

            $respCourse = $repoCourse->create($data);

            if($respCourse->getResult()){
                return response()->json([
                    'error' => false,
                    'result' => $respCourse->getData()
                ]);
            }
            else{
                return response()->json([
                    'error' => true,
                    'message' => $respCourse->getError()->getMeesage(),
                ]);
            }
        }
        else{
            $course = Course::find($id);
            $user = Auth::user();
            if($user->can('update',$course)){
                $data = $request->toArray();
                $repoCourse = new CourseRepository();
                $respCourse=$repoCourse->update($id,$data);
                if($course==null){
                    return response()->json([
                        'error' => true,
                        'message' => 'id = '.$id.' kurs yok.'
                    ]);
                }
                else if($respCourse->getResult()){
                    return response()->json([
                        'error' => false,
                        'result' => $course,
                        'message' => 'Kurs başarıyla güncellendi'
                    ]);
                }
                else {
                    return response()->json([
                        'error' => true,
                        'result' => $course,
                        'message' => 'Kurs güncellenemedi'
                    ]);
                }
            }
            else{
                return response()->json([
                    'error' => true,
                    'message' => 'Eğitimci değilsin veya bu kursun eğitimcisi değilsin'
                ]);
            }
        }
    }

    public function goalsPost($id){
        $course = Course::find($id);
        $user = Auth::user();
        if($user->can('update',$course)){
            // Initializing
            $data = array();
            $data['course'] = $course;
            $repoCourse = new CourseRepository();

            // Operations
            $respAchievement = $repoCourse->syncAchievements($id,$data);
            $respRequirement = $repoCourse->syncRequirements($id,$data);
            $respTag = $repoCourse->syncTags($id,$data);

            if($respAchievement->getResult() and $respRequirement->getResult() and $respTag->getResult()){
                return response()->json([
                    'error' => false,
                    'result' => 'Kurs Güncellendi'
                ]);
            }
            else{
                return response()->json([
                    'error' => true,
                    'result' => 'Kurs Güncellenemdi'
                ]);
            }
        }
        else{
            return response()->json([
                'error' => true,
                'message' => 'Eğitimci değilsin veya bu kursun eğitimcisi değilsin'
            ]);
        }
    }


    public function sectionsPost($id,Request $request){
        // Initializing
        $repo = new CourseRepository();
        $data = $request->toArray();
        $course = Course::find($id);
        $user = Auth::user();
        if($user->can('update',$course)){
            // Operations
            $respSection = $repo->syncSections($id,$data);
            $respLesson = $repo->syncLesson($id,$data);
            $respSource = $repo->syncSource($id,$data);

            if($respSection->getResult() and $respLesson->getResult() and $respSource->getResult()){
                return response()->json([
                    'error' => false,
                    'result' => 'Kurs Güncellendi'
                ]);
            }
            else{
                return response()->json([
                    'error' => true,
                    'result' => 'Kurs Güncellenemedi'
                ]);
            }
        }
        else{
            return response()->json([
                'error' => true,
                'message' => 'Eğitimci değilsin veya bu kursun eğitimcisi değilsin'
            ]);
        }
    }


    public function instructorsPost($id,Request $request){
        $user = Auth::user();
        $course = Course::find($id);
        if($user->can('update',$course)){
            // Initializin
            $repo = new CourseRepository();
            $data = $request->toArray();

            // Operations
            $resp = $repo->syncInstructor($id,$data);
            if($resp->getResult()){
                return response()->json([
                    'error' => false,
                    'message' => 'Eğitimenler kursa eklendi'
                ]);
            }
            else{
                return response()->json([
                    'error' => true,
                    'message' => 'Eğitimenler kursa eklenemedi'
                ]);
            }
        }
        else{
            return response()->json([
                'error' => true,
                'message' => 'Eğitimci değilsin veya bu kursun eğitimcisi değilsin'
            ]);
        }
    }
}
