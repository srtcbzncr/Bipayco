<?php

namespace App\Http\Controllers\API\PrepareExams;

use App\Http\Controllers\Controller;
use App\Models\Auth\Instructor;
use App\Models\Auth\User;
use App\Models\PrepareExams\Course;
use App\Repositories\GeneralEducation\SourceRepository;
use App\Repositories\PrepareExams\CourseRepository;
use App\Repositories\PrepareExams\LessonRepository;
use App\Repositories\PrepareExams\SectionRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    public function show($id, Request $request){
        // Repo initialization
        $repo = new CourseRepository;
        $user_id = null;
        if(isset($request->toArray()['user_id'])){
            $user_id = $request->toArray()['user_id'];
        }

        // Operations
        $resp = $repo->get_api($id,$user_id);
        $completedLessonsResp = $repo->getCompletedLessons($id, Auth::id());
        $entriesResp = $repo->getStudents($id);
        $progress = $repo->calculateProgress($resp->getData()->id, Auth::id());
        $similarCourses = $repo->getSimilarCourses($id);
        $data = [
            'course' => $resp->getData(),
            'entries' => $entriesResp->getData(),
            'student_count' => count($resp->getData()->entries),
            'progress' => $progress->getData(),
            'completed' => $completedLessonsResp->getData(),
            'similar_courses' => $similarCourses->getData(),
        ];

        // Response
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'data' => $data
            ]);
        }

        return response()->json([
            'error' => false,
            'mesage' => 'Kurs verileri getirilirken hata oluştu.Tekrar deneyin.'
        ]);
    }

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
       // $control=$this->checkManager($user,$course);
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
        $repo = new \App\Repositories\PrepareExams\SourceRepository();

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
        $geCoursesInstructor =  DB::table('ge_courses_instructors')->where('course_type','App\Models\PrepareLessons\Course')
            ->where('course_id',$id)->get();
        foreach ($geCoursesInstructor as $item){
            if($item->is_manager == true){
                $instructor = Instructor::find($item->instructor_id);
                $user = User::find($instructor->user_id);
                break;
            }
        }

        // percent control
        $b = false;
        $total = 0;
        foreach ($data as $item){
            if(!isset($item['percent']) and $item['percent'] ==null){
                $b = true;
                break;
            }
            else{
                $total+=$item['percent'];
            }
        }

        if($b == true){
            return response()->json([
                'error' => true,
                'message' => 'Eğitimenler kursa eklenirken hata oluştu.Tekrar deneyin.'
            ],400);
        }
        else{
            if($total!=100){
                return response()->json([
                    'error' => true,
                    'message' => 'Eğitimenlerin payları toplam 100 olmalıdır.Tekrar deneyin.'
                ],400);
            }
        }

        $course = Course::find($id);
        if($this->checkManagerPolicy($user,$course)){
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
    private function checkManagerPolicy($user,$course){
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
                $user = User::find($instructor->user_id);
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
                //'data' => $resp->getData()
            ]);
        }

        return response()->json([
            'error' => true,
            'message' => 'Bölümler güncellenirken hata oluştu.Tekrar deneyin.',
            //'data' => $resp->getData()
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
                //'data' => $resp->getData()
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
                // 'data' => $resp->getData()
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
                // 'data' => $resp->getData()
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

    public function getSubjectsForLesson($id){
        // Initializing
        $repo = new CourseRepository();

        // Operations
        $resp =  $repo->getSubjectsForLesson($id);

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

    public function getRandomQuestions($courseId,$crLessonId,$crSubjectId){
        // Initializing
        $repo = new CourseRepository();

        // Operations
        $resp =  $repo->getRandomQuestions($courseId,$crLessonId,$crSubjectId);

        // Response
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'message' => 'Sorular başarıyla getirildi.',
                'data' => $resp->getData()
            ]);
        }
        else{
            return response()->json([
                'error' => true,
                'message' => 'Sorular getirilirken hata oluştu.Tekrar deneyin.',
                'errorMessage' => $resp->getError()
            ],400);
        }
    }

    public function inBasket($user_id,$course_id){
        // Initializing
        $repo = new CourseRepository();

        // Operations
        $resp = $repo->inBasket($user_id,$course_id);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'inBasket' => $resp->getData()
            ]);
        }

        return response()->json([
            'error' => true,
            'message' => 'Bir hata oluştu.Tekrar deneyin.'
        ]);
    }

    public function simularCourses($course_id,$user_id=null){
        // Initializing
        $repo = new CourseRepository();

        // Operations
        $resp = $repo->getSimilarCourses($course_id,$user_id);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'data' => $resp->getData()
            ]);
        }

        return response()->json([
            'error' => true,
            'message' => 'Bir hata oluştu.Tekrar deneyin.'
        ]);
    }

    public function getByLessonFilterByNewest($gradeId,$lesson_id,$user_id=null){
        // Repo initialization
        $repo = new CourseRepository;

        // Operations
        $resp = $repo->getBySubCategoryFilterByNewest($gradeId,$lesson_id,$user_id);

        // Response
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'data' => $resp->getData()
            ]);
            //return GE_CourseResource::collection($resp->getData());
        }
        else{
            return response()->json(['error' => true, 'message' => $resp->getError()],400);
        }
    }
    public function getByLessonFilterByOldest($gradeId,$lesson_id,$user_id=null){
        // Repo initialization
        $repo = new CourseRepository;

        // Operations
        $resp = $repo->getBySubCategoryFilterByOldest($gradeId,$lesson_id,$user_id);

        // Response
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'data' => $resp->getData()
            ]);
        }
        else{
            return response()->json(['error' => true, 'message' => $resp->getError()],400);
        }
    }
    public function getByLessonFilterByPriceASC($gradeId,$lesson_id,$user_id=null){
        // Repo initialization
        $repo = new CourseRepository;

        // Operations
        $resp = $repo->getBySubCategoryFilterByPriceASC($gradeId,$lesson_id,$user_id);

        // Response
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'data' => $resp->getData()
            ]);
        }
        else{
            return response()->json(['error' => true, 'message' => $resp->getError()],400);
        }
    }
    public function getByLessonFilterByPriceDESC($gradeId,$lesson_id,$user_id=null){
        // Repo initialization
        $repo = new CourseRepository;

        // Operations
        $resp = $repo->getBySubCategoryFilterByPriceDESC($gradeId,$lesson_id,$user_id);

        // Response
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'data' => $resp->getData()
            ]);
        }
        else{
            return response()->json(['error' => true, 'message' => $resp->getError()],400);
        }
    }
    public function getByLessonFilterByPoint($gradeId,$lesson_id,$user_id=null){
        // Repo initialization
        $repo = new CourseRepository;

        // Operations
        $resp = $repo->getBySubCategoryFilterByPoint($gradeId,$lesson_id,$user_id);

        // Response
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'data' => $resp->getData()
            ]);
        }
        else{
            return response()->json(['error' => true, 'message' => $resp->getError()],400);
        }
    }
    public function getByLessonFilterByPurchases($gradeId,$lesson_id,$user_id=null){
        // Repo initialization
        $repo = new CourseRepository;

        // Operations
        $resp = $repo->getBySubCategoryFilterByPurchases($gradeId,$lesson_id,$user_id);

        // Response
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'data' => $resp->getData()
            ]);
        }
        else{
            return response()->json(['error' => true, 'message' => $resp->getError()],400);
        }
    }
    public function getByLessonFilterByTrending($gradeId,$lesson_id,$user_id=null){
        // Repo initialization
        $repo = new CourseRepository;

        // Operations
        $resp = $repo->getBySubCategoryFilterByTrending($gradeId,$lesson_id,$user_id);

        // Response
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'data' => $resp->getData()
            ]);
        }
        else{
            return response()->json(['error' => true, 'message' => $resp->getError()],400);
        }
    }

    public function buy($courseId,Request $request){
        // initializing
        $repo = new CourseRepository();
        $data = $request->toArray();

        // operations
        $resp = $repo->buy($courseId,$data);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'data' => $resp->getData()
            ]);
        }

        return response()->json([
            'error' => true,
            'message' => 'Satın alma başarısız.Tekrar deneyin',
            'errorMessage' => $resp->getError()
        ]);
    }

    public function deleteCourse($id,Request $request){
        // initializing
        $repo = new CourseRepository();
        $data = $request->toArray();

        // operations
        $resp = $repo->deleteCourse($id,$data);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'message' => 'Kurs başarıyla silindi'
            ]);
        }
        return response()->json([
            'error' => true,
            'message' => 'Kurs Silme işlemi başarısız.Tekrar deneyin',
            'errorMessage' => $resp->getError()
        ]);
    }


    public function activeCourse($id,Request $request){
        // initializing
        $repo = new CourseRepository();
        $data = $request->toArray();

        // operations
        $resp = $repo->activeCourse($id,$data);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'message' => 'Kurs başarıyla aktifleştirildi'
            ]);
        }
        return response()->json([
            'error' => true,
            'message' => 'Kurs aktifleştirme işlemi başarısız.Tekrar deneyin',
            'errorMessage' => $resp->getError()
        ]);
    }

    public function passiveCourse($id,Request $request){
        // initializing
        $repo = new CourseRepository();
        $data = $request->toArray();

        // operations
        $resp = $repo->passiveCourse($id,$data);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'message' => 'Kurs başarıyla pasifleştirildi'
            ]);
        }
        return response()->json([
            'error' => true,
            'message' => 'Kurs pasifleştirme işlemi başarısız.Tekrar deneyin',
            'errorMessage' => $resp->getError()
        ]);
    }
}
