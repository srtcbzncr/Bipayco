<?php

namespace App\Http\Controllers\API\PrepareLessons;

use App\Http\Controllers\Controller;
use App\Models\Auth\Instructor;
use App\Models\Auth\User;
use App\Models\PrepareLessons\Course;
use App\Repositories\PrepareLessons\CourseRepository;
use App\Repositories\PrepareLessons\SectionRepository;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function createPost($id = null,Request $request){
        if($id == null){
            // Initializing
            $data = $request->toArray();
            $repo = new CourseRepository();

            // Operaitons
            $resp = $repo->create($data);
            if($resp->getResult()){
                return response()->json([
                    'error' => false,
                    'message' => 'Kurs başarıyla oluşturuldu'
                ]);
            }
            else{
                return response()->json([
                    'error' => true,
                    'message' => 'Kurs oluşturulurken hata meydana geldi.Tekrar deneyin.',
                    'errorMessage' => $resp->getError()
                ],400);
            }
        }
        else{
            // Initializing
            $data = $request->toArray();
            $repo = new CourseRepository();

            // Operaitons
            $resp = $repo->update($id,$data);
            if($resp->getResult()){
                return response()->json([
                    'error' => false,
                    'message' => 'Kurs başarıyla güncellendi.'
                ]);
            }
            else{
                return response()->json([
                    'error' => true,
                    'message' => 'Kurs güncellenirken hata meydana geldi.Tekrar deneyin.',
                    'errorMessage' => $resp->getError()
                ],400);
            }
        }
    }

    public function goalsPost($id,Request $request){
        $course = Course::find($id);
        $user = User::find(Instructor::find($request->toArray()['instructor_id'])->user->id);
        if($user->can('checkManager',$course)){
            // Initializing
            $achievementData = explode(',',$request->toArray()['achievements']);
            $requirementData = explode(',',$request->toArray()['requirements']);
            $tagsData = explode(',',$request->toArray()['tags']);
            $repoCourse = new CourseRepository();

            // Operations
            $respAchievement = $repoCourse->syncAchievements($id,$achievementData);
            $respRequirement = $repoCourse->syncRequirements($id,$requirementData);
            $respTag = $repoCourse->syncTags($id,$tagsData);

            if($respAchievement->getResult() and $respRequirement->getResult() and $respTag->getResult()){
                return response()->json([
                    'error' => false,
                    'result' => 'Kurs başarıyla güncellendi.'
                ]);
            }
            else{
                return response()->json([
                    'error' => true,
                    'message' => 'Kurs güncellenirken hata oluştu.Tekrar deneyin.',
                ],400);
            }
        }
        else{
            return response()->json([
                'error' => true,
                'message' => 'Eğitimci değilsin veya bu kursun eğitimcisi değilsin'
            ],400);
        }

    }

    public function goalsGet($id){
        // Initializing
        $repo = new CourseRepository();

        // Operations
        $respAchievement = $repo->syncAchievementGet($id);
        $respRequiement = $repo->syncRequierementGet($id);
        $respTag = $repo->syncTagGet($id);
        if($respAchievement->getResult() or $respRequiement->getResult() or $respTag->getResult()){
            $data = array();
            $data['achievements'] = $respAchievement->getData();
            $data['requirements'] = $respRequiement->getData();
            $data['tags'] = $respTag->getData();
            return response()->json([
                'error' => false,
                'data' => $data,
                'message' => 'Veriler başarıyla veritabanından getirildi.'
            ]);
        }
        else{
            return response()->json([
                'error' => true,
                'message' => 'Veriler getirilirken hata oluştu.Tekrar deneyin.'
            ],400);
        }
    }

    public function sectionsPost($id,$section_id = null,Request $request){
        // Initializing
        $repo = new SectionRepository();

        // Operations
        $resp = null;
        if($section_id == null){
            $resp = $repo->create($request->toArray());
        }
        else{
            $resp = $repo->update($section_id,$request->toArray());
        }

        // Response
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'message' => 'Bölüm başarıyla eklendi.'
            ]);
        }
        else{
            return response()->json([
                'error' => true,
                'message' => 'Bölüm eklenirken hata oluştu.Tekrar deneyin.'
            ],400);
        }
    }

    public function sectionsDelete($id,$section_id){
        // Initializing
        $repo = new SectionRepository();

        // Operations
        $resp = null;
        $resp=$repo->delete($section_id);
        // Response
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'message' => 'Bölüm başarıyla silindi.'
            ]);
        }
        else{
            return response()->json([
                'error' => true,
                'message' => 'Bölüm silinirken hata oluştu.Tekrar deneyin.'
            ],400);
        }
    }

    public function sectionsGet($id){
        // Initializing
        $repo = new CourseRepository();

        // Operations
        $resp = $repo->syncSectionGet($id);
        if($resp->getResult()){

            return response()->json([
                'error' => false,
                'data' => $resp->getData(),
                'message' => 'Bölümler veritabanından başarıyla getirildi.'
            ]);
        }
        else{
            return response()->json([
                'error' => true,
                'message' => 'Bölümler veritabanından getirilirken hata oluştu.Tekrar deneyin.',
                'error_message' => $resp->getError()
            ],400);
        }
    }
}
