<?php

namespace App\Http\Controllers\API\PrepareLessons;

use App\Http\Controllers\Controller;
use App\Models\Auth\Instructor;
use App\Models\Auth\User;
use App\Models\PrepareLessons\Course;
use App\Repositories\GeneralEducation\SourceRepository;
use App\Repositories\PrepareLessons\CourseRepository;
use App\Repositories\PrepareLessons\LessonRepository;
use App\Repositories\PrepareLessons\SectionRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
                    'result' => $resp->getData(),
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
        $control=$this->checkManager($user,$course);
        if($control){
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

    public function checkManager(User $user, Course $course){
        $instructor = Instructor::where('user_id',$user->id)->first();
        if($instructor != null){
            $geCourseInstructor = DB::table("ge_courses_instructors")->where('course_id',$course->id)
                ->where('instructor_id',$instructor->id)->where('course_type','App\Models\PrepareLessons\Course')->first();
            if($geCourseInstructor != null){
                if($geCourseInstructor->is_manager == 1){
                    return true;
                }
                else{
                    return false;
                }
            }
            else{
                return false;
            }
        }
        else{
            return false;
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

    public function getSubjects($id){
        // Initializing
        $repo = new CourseRepository();

        // Operations
        $resp =  $repo->getSubjects($id);

        // Response
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'message' => 'Konular başarıyla getirildi.',
                'data' => $resp->getData()
            ]);
        }
        else{
            return response()->json([
                'error' => true,
                'message' => 'Konular getirilirken hata oluştu.Tekrar deneyin.'
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

    public function lessonsPost($id,$section_id,$lesson_id = null,Request $request){
        $sources = null;
        if(isset($request->toArray()['source'])){
            $sources = $request->toArray()['source'];
        }


        // Initializing
        $repo = new LessonRepository();
        $data = $request->toArray();
        $data['section_id'] = $section_id;
        $data['sources'] = $sources;

        // Operations
        if($lesson_id == null){
            $resp = $repo->create($data);
            if($resp->getResult()){
                return response()->json([
                    'error' => false,
                    'message' => 'Ders başarıyla eklendi.'
                ]);
            }
            else{
                return response()->json([
                    'error' => true,
                    'message' => 'Ders eklenirken hata oluştu.Tekrar deneyin.',
                    'errorMessage' => $resp->getError()
                ],400);
            }
        }
        else{
            $resp = $repo->update($lesson_id,$data);
            if($resp->getResult()){
                return response()->json([
                    'error' => false,
                    'message' => 'Ders başarıyla güncellendi'
                ]);
            }
            else{
                return response()->json([
                    'error' => true,
                    'message' => 'Ders güncellenirken hata oluştu.Tekrar deneyin.',
                    'errorMessage' => $resp->getError()
                ],400);
            }
        }
    }

    public function lessonsDelete($id,$section_id,$lesson_id){
        // Initializing
        $repo = new LessonRepository();

        // Operations
        $resp = $repo->delete($lesson_id);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'message' => 'Ders başarıyla silindi'
            ]);
        }
        else{
            return response()->json([
                'error' => true,
                'message' => 'Ders silinirken hata oluştu.Tekrar deneyin.'
            ],400);
        }
    }

    public function sourceDelete($course_id,$section_id,$lesson_id,$source_id){
        // Initializing
        $repo = new SourceRepository();

        // Operations
        $resp =  $repo->delete($source_id);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'message' => 'Kaynak başarıyla silindi.'
            ]);
        }
        else{
            return response()->json([
                'error' => true,
                'message' => 'Kaynak silinirken hata oluştu.Tekrar deneyin.'
            ],400);
        }
    }
    public function sourceDeleteCancel($course_id,$section_id,$lesson_id){
        // Initializing
        $repo = new \App\Repositories\PrepareLessons\SourceRepository();

        // Operations
        $resp =  $repo->setActive($lesson_id);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'message' => 'Kaynak başarıyla geri getirildi.',
                'data' => $resp->getData()
            ]);
        }
        else{
            return response()->json([
                'error' => true,
                'message' => 'Kaynak geri getirilirken hata oluştu.Tekrar deneyin.',
                'errorMessage' => $resp->getError()
            ],400);
        }
    }

    public function instructorsPost($id,Request $request){
        $user = null;
        $data = $request->toArray();
        $course_type = 'App\Models\PrepareLessons\Course';
        foreach ($data as $key => $item){
            $geCoursesInstructor = DB::select('select * from ge_courses_instructors where course_id = '.$id.' and instructor_id = '.$item['instructor_id'].' and course_type = '.$course_type);
            try {
                if($geCoursesInstructor[0]->is_manager == true){
                    $instructor = Instructor::find($geCoursesInstructor[0]->instructor_id);
                    $user = User::find($instructor->user_id);
                    break;
                }
            } catch(\Exception $e){
            }
        }


        $course = Course::find($id);
        if($user->can('checkManager',$course)){
            // Initializin
            $repo = new CourseRepository();
            $data = $request->toArray();

            // Operations
            $resp = $repo->syncInstructor($id,$data);
            if($resp->getResult()){
                return response()->json([
                    'error' => false,
                    'message' => 'Eğitimenler kursa başarıyla eklendi'
                ]);
            }
            else{
                return response()->json([
                    'error' => true,
                    'message' => 'Eğitimenler kursa eklenirken hata oluştu.Tekrar deneyin.'
                ],400);
            }
        }
        else{
            return response()->json([
                'error' => true,
                'message' => 'Bu kursun eğitimcisi değilsin veya eklenen eğitmen eğitimci değil.'
            ],400);
        }
    }

    public function instructorsGet($id){
        // Initializing
        $repoCourse  = new CourseRepository();

        // Operations
        $respCourse = $repoCourse->syncInstructorGet($id);
        if($respCourse->getResult()){
            $data = array();
            $data['instructor'] = $respCourse->getData();
            $i=0;
            foreach ($data['instructor'] as $instructor){
                $ins = Instructor::find($instructor->instructor_id);
                $user = User::find($ins->user_id);
                $data['instructor'][$i]->user = $user;
                $i++;
            }
            return response()->json([
                'error' => false,
                'data' => $data,
                'message' => 'Eğitimcilerin bilgisi veritabanından başarıyla çekildi.'
            ]);
        }
        else{
            return response()->json([
                'error' => true,
                'message' => 'Eğitimcilerin bilgisi veritabanından çekilirken hata oluştur.Tekrar deneyin.'
            ],400);
        }
    }

    public function sectionUp($course_id,$section_id){
        // Initializing
        $repo = new SectionRepository();

        // Operations
        $resp = $repo->sectionUp($course_id,$section_id);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'message' => 'Bölümler başarıyla güncellendi',
                'data' => $resp->getData()
            ]);
        }

        return response()->json([
            'error' => true,
            'message' => 'Bölümler güncellenirken hata oluştu.Tekrar deneyin.',
            'data' => $resp->getData()
        ]);
    }

    public function sectionDown($course_id,$section_id){
        // Initializing
        $repo = new SectionRepository();

        // Operations
        $resp = $repo->sectionDown($course_id,$section_id);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'message' => 'Bölümler başarıyla güncellendi',
                'data' => $resp->getData()
            ]);
        }

        return response()->json([
            'error' => true,
            'message' => 'Bölümler güncellenirken hata oluştu.Tekrar deneyin.',
            'messageError' => $resp->getError()
        ]);
    }

    public function lessonUp($course_id,$section_id,$lesson_id){
        // Initializing
        $repo = new LessonRepository();

        // Operations
        $resp = $repo->lessonUp($course_id,$section_id,$lesson_id);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'message' => 'Dersler başarıyla güncellendi',
                'data' => $resp->getData()
            ]);
        }

        return response()->json([
            'error' => true,
            'message' => 'Dersler güncellenirken hata oluştu.Tekrar deneyin.',
            'messageError' => $resp->getError()
        ]);
    }

    public function lessonDown($course_id,$section_id,$lesson_id){
        // Initializing
        $repo = new LessonRepository();

        // Operations
        $resp = $repo->lessonDown($course_id,$section_id,$lesson_id);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'message' => 'Dersler başarıyla güncellendi',
                'data' => $resp->getData()
            ]);
        }

        return response()->json([
            'error' => true,
            'message' => 'Dersler güncellenirken hata oluştu.Tekrar deneyin.',
            'messageError' => $resp->getError()
        ]);
    }

    public function getPreviewLessons($id){
        // Initializing
        $repo = new CourseRepository();

        // Operations
        $resp = $repo->getPreviewLessons($id);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'message' => 'Ön izlemeli dersler başarıyla getirildi.',
                'previewLessons' => $resp->getData()
            ]);
        }

        return response()->json([
            'error' => true,
            'message' => 'Ön izlemeli dersler getirilirken hata oluştu.Tekrar deneyin.',
            'messageError' => $resp->getError()
        ]);
    }
}
