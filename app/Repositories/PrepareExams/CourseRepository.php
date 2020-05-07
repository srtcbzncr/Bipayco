<?php


namespace App\Repositories\PrepareExams;


use App\Models\Auth\Instructor;
use App\Models\Auth\Student;
use App\Models\Auth\User;
use App\Models\Curriculum\Exam;
use App\Models\Curriculum\Subject;
use App\Models\GeneralEducation\Achievement;
use App\Models\GeneralEducation\Comment;
use App\Models\GeneralEducation\Entry;
use App\Models\GeneralEducation\Purchase;
use App\Models\GeneralEducation\Requirement;
use App\Models\GeneralEducation\Source;
use App\Models\GeneralEducation\Tag;
use App\Models\PrepareExams\Course;
use App\Models\PrepareExams\Lesson;
use App\Models\PrepareExams\Section;
use App\Models\QuestionSource\GapFilling;
use App\Models\QuestionSource\Match;
use App\Models\QuestionSource\MultiChoice;
use App\Models\QuestionSource\Order;
use App\Models\QuestionSource\Question;
use App\Models\QuestionSource\SingleChoice;
use App\Models\QuestionSource\TrueFalse;
use App\Models\UsersOperations\Basket;
use App\Models\UsersOperations\Favorite;
use App\Repositories\IRepository;
use App\Repositories\RepositoryResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;

class CourseRepository implements IRepository{

    public function all()
    {
        // TODO: Implement all() method.
    }

    public function get($id)
    {
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $user = Auth::user();
            if($user == null){
                $object = Course::find($id);
            }
            else{
                $object = Course::find($id);
                $controlBasket = Basket::where('user_id',$user->id)->where('course_id',$id)->where('course_type','App\Models\PrepareExams\Course')->get();
                if($controlBasket != null and count($controlBasket) > 0){
                    $object['inBasket'] = true;
                }
                else{
                    $object['inBasket'] = false;
                }
                $controlFav = Favorite::where('user_id',$user->id)->where('course_id',$id)->where('course_type','App\Models\PrepareExams\Course')->get();
                if($controlFav != null and count($controlFav) > 0){
                    $object['inFavorite'] = true;
                }
                else{
                    $object['inFavorite'] = false;
                }
            }
        }
        catch(\Exception $e){
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function get_api($id,$user_id)
    {
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $user = null;
            if($user_id != null){
                $user = User::find($user_id);
                $student = Student::where('user_id',$user->id)->first();
            }

            if($user == null){
                $object = Course::find($id);
            }
            else{
                $object = Course::find($id);
                $controlBasket = Basket::where('user_id',$user->id)->where('course_id',$id)->where('course_type','App\Models\PrepareExams\Course')->get();
                if($controlBasket != null and count($controlBasket) > 0){
                    $object['inBasket'] = true;
                }
                else{
                    $object['inBasket'] = false;
                }
                $controlFav = Favorite::where('user_id',$user->id)->where('course_id',$id)->where('course_type','App\Models\PrepareExams\Course')->get();
                if($controlFav != null and count($controlFav) > 0){
                    $object['inFavorite'] = true;
                }
                else{
                    $object['inFavorite'] = false;
                }

                // proggress verisi gönder.
                $sections = $object->sections;
                $counter = 0;
                $totalLesson = 0;
                foreach ($sections as $section){
                    $lessons = $section->lessons;
                    $totalLesson+=count($lessons);
                    foreach ($lessons as $lesson){
                        $controlComplete = DB::table('ge_students_completed_lessons')
                            ->where('student_id',$student->id)
                            ->where('lesson_id',$lesson->id)
                            ->where('lesson_type','App\Models\PrepareExams\Lesson')->get();
                        if($controlComplete != null and count($controlComplete) > 0){
                            $counter++;
                        }
                    }
                }
                if($totalLesson == 0){
                    $object['progress'] = 0;
                }
                else{
                    $progress = ($counter/$totalLesson)*100;
                    $object['progress'] = $progress;
                }
            }
        }
        catch(\Exception $e){
            $error = $e->getMessage();
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function create(array $data)
    {
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            DB::beginTransaction();

            $imagePath = Storage::url($data['image']->store('public/images'));
            $object = new Course();
            $object->exam_id = $data['exam_id'];
            $object->image = $imagePath;
            $object->name = $data['name'];
            $object->description = $data['description'];
            $object->access_time = $data['access_time'];
            $object->certificate = $data['certificate'];
            $object->long = 0;
            $object->score = $data['score'];
            $object->price = $data['price'];
            $object->price_with_discount = $data['price'];
            $object->save();
            $object->instructors()->save(Instructor::find($data['instructor_id']), ['is_manager' => true, 'percent' => 100, 'active' => true]);
            DB::commit();
        }
        catch(\Exception $e){
            $error = $e->getMessage();
            $result = false;
            DB::rollBack();
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function update($id, array $data)
    {
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try {
            DB::beginTransaction();

            $object = Course::find($id);
            if(array_key_exists('image', $data)){
                $imagePath = Storage::url($data['image']->store('public/images'));
                Storage::delete($object->image);
                $object->image = $imagePath;
            }
            $object->exam_id = $data['exam_id'];
            $object->name = $data['name'];
            $object->description = $data['description'];
            $object->access_time = $data['access_time'];
            $object->certificate = $data['certificate'];
            $object->score = $data['score'];
            $long = $object->long;
            $object->long = $long;
            $object->price = $data['price'];
            $object->price_with_discount = $data['price'];
            $object->save();

            DB::commit();

        }catch(\Exception $e){
            $error = $e->getMessage();
            $result = false;
            DB::rollBack();
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function delete($id)
    {
        // TODO: Implement delete() method.
    }

    public function setActive($id)
    {
        // TODO: Implement setActive() method.
    }

    public function setPassive($id)
    {
        // TODO: Implement setPassive() method.
    }

    public function getPopularCourses($user_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Course::where('active', true)
                ->where('point', '>=', 0.0)
                ->where('deleted_at',null)
                ->orderBy('purchase_count', 'desc')
                ->orderBy('point', 'desc')
                ->take(12)
                ->get();

            // object ve lesson bilgisini ekle
            foreach ($object as $key => $item){
                $grade = Exam::find($item->grade_id);
                $lesson = \App\Models\Curriculum\Lesson::find($item->lesson_id);
                $object[$key]['grade'] = $grade;
                $object[$key]['lesson'] = $lesson;
            }

            if($user_id != null){
                // bu kursların favori veya sepete eklenip eklenmediği bilgisini getir.
                foreach ($object as $key=> $course){
                    $controlBasket = Basket::where('course_id',$course->id)->where('user_id',$user_id)->where('course_type','App\Models\PrepareExams\Course')->first();
                    if($controlBasket != null)
                        $object[$key]['inBasket'] = true;
                    else
                        $object[$key]['inBasket'] = false;

                    $controlFavorite = Favorite::where('course_id',$course->id)->where('user_id',$user_id)->where('course_type','App\Models\PrepareExams\Course')->first();
                    if($controlFavorite != null)
                        $object[$key]['inFavorite'] = true;
                    else
                        $object[$key]['inFavorite'] = false;
                }
            }

        }
        catch(\Exception $e){
            $error = $e->getMessage();
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function getByLessonFilterByNewest($lesson_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Course::where('lesson_id', $lesson_id)
                ->where('active', true)
                ->where('deleted_at',null)
                ->latest()
                ->paginate(9);
        }
        catch(\Exception $e){
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function getByLessonFilterByOldest($lesson_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Course::where('lesson_id', $lesson_id)
                ->where('active', true)
                ->where('deleted_at',null)
                ->oldest()
                ->paginate(9);
        }
        catch(\Exception $e){
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function getByLessonFilterByPriceASC($lesson_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Course::where('lesson_id', $lesson_id)
                ->where('active', true)
                ->where('deleted_at',null)
                ->orderBy('price_with_discount', 'asc')
                ->paginate(9);
        }
        catch(\Exception $e){
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function getByLessonFilterByPriceDESC($lesson_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Course::where('lesson_id', $lesson_id)
                ->where('active', true)
                ->where('deleted_at',null)
                ->orderBy('price_with_discount', 'desc')
                ->paginate(9);
        }
        catch(\Exception $e){
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function getByLessonFilterByPoint($lesson_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Course::where('lesson_id', $lesson_id)
                ->where('active', true)
                ->where('deleted_at',null)
                ->orderBy('point', 'desc')
                ->paginate(9);
        }
        catch(\Exception $e){
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function getByLessonFilterByPurchases($lesson_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Course::where('lesson_id', $lesson_id)
                ->where('active', true)
                ->where('deleted_at',null)
                ->orderBy('purchase_count', 'desc')
                ->paginate(9);
        }
        catch(\Exception $e){
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function getByLessonFilterByTrending($lesson_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Course::where('lesson_id', $lesson_id)
                ->where('active', true)
                ->where('deleted_at',null)
                ->orderBy('purchase_count', 'desc')
                ->orderBy('point','desc')
                ->paginate(9);
        }
        catch(\Exception $e){
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function getByExamFilterByNewest($exam_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Course::where('exam_id', $exam_id)
                ->where('active', true)
                ->where('deleted_at',null)
                ->latest()
                ->paginate(9);
        }
        catch(\Exception $e){
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function getByExamFilterByOldest($exam_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Course::where('exam_id', $exam_id)
                ->where('active', true)
                ->where('deleted_at',null)
                ->oldest()
                ->paginate(9);
        }
        catch(\Exception $e){
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function getByExamFilterByPriceASC($exam_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Course::where('exam_id', $exam_id)
                ->where('active', true)
                ->where('deleted_at',null)
                ->orderBy('price_with_discount', 'asc')
                ->paginate(9);
        }
        catch(\Exception $e){
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function getByExamFilterByPriceDESC($exam_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Course::where('exam_id', $exam_id)
                ->where('active', true)
                ->where('deleted_at',null)
                ->orderBy('price_with_discount', 'desc')
                ->paginate(9);
        }
        catch(\Exception $e){
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function getByExamFilterByPoint($exam_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Course::where('exam_id', $exam_id)
                ->where('active', true)
                ->where('deleted_at',null)
                ->orderBy('point', 'desc')
                ->paginate(9);
        }
        catch(\Exception $e){
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function getByExamFilterByPurchases($exam_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Course::where('exam_id', $exam_id)
                ->where('active', true)
                ->where('deleted_at',null)
                ->orderBy('purchase_count', 'desc')
                ->paginate(9);
        }
        catch(\Exception $e){
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function getByExamFilterByTrending($exam_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Course::where('exam_id', $exam_id)
                ->where('active', true)
                ->where('deleted_at',null)
                ->orderBy('purchase_count', 'desc')
                ->orderBy('point','desc')
                ->paginate(9);
        }
        catch(\Exception $e){
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function syncRequirements($id, array $data){
        // data empty control
        if(count($data) == 0){
            $object = array();
            $error = false;
            $result = true;
            $resp = new RepositoryResponse($result, $object, $error);
            return $resp;
        }
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            DB::beginTransaction();
            $requirements = Requirement::where('course_id',$id)->where('course_type','App\Models\PrepareExams\Course')->get();
            foreach ($requirements as $item){
                $item->delete();
            }
            foreach ($data as $requirement){
                $newRequirement = new Requirement();
                $newRequirement->course_id = $id;
                $newRequirement->course_type = 'App\Models\PrepareExams\Course';
                $newRequirement->content = $requirement;
                $newRequirement->save();
            }
            $object = Requirement::where('course_id',$id)->where('course_type','App\Models\PrepareExams\Course')->get();
            DB::commit();
        }
        catch(\Exception $e){
            DB::rollBack();
            $error = $e->getMessage();
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function syncAchievements($id, array $data){
        // data empty control
        if(count($data) == 0){
            $object = array();
            $error = false;
            $result = true;
            $resp = new RepositoryResponse($result, $object, $error);
            return $resp;
        }
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            DB::beginTransaction();
            $achievements = Achievement::where('course_id',$id)->where('course_type','App\Models\PrepareExams\Course')->get();
            foreach ($achievements as $item){
                $item->delete();
            }

            foreach ($data as $achievement){
                $newAchievement = new Achievement();
                $newAchievement->course_id = $id;
                $newAchievement->course_type = 'App\Models\PrepareExams\Course';
                $newAchievement->content = $achievement;
                $newAchievement->save();
            }
            $object = Achievement::where('course_id',$id)->where('course_type','App\Models\PrepareExams\Course')->get();
            DB::commit();
        }
        catch(\Exception $e){
            DB::rollBack();
            $error = $e->getMessage();
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function syncTags($id, array $data){
        // data empty control
        if(count($data) == 0){
            $object = array();
            $error = false;
            $result = true;
            $resp = new RepositoryResponse($result, $object, $error);
            return $resp;
        }
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            DB::beginTransaction();
            $tags = Tag::where('course_id',$id)->where('course_type','App\Models\PrepareExams\Course')->get();
            foreach ($tags as $item){
                $item->delete();
            }
            foreach ($data as $tag){
                $newTag = new Tag();
                $newTag->course_id = $id;
                $newTag->course_type = 'App\Models\PrepareExams\Course';
                $newTag->tag = $tag;
                $newTag->save();
            }
            $object = Tag::where('course_id',$id)->where('course_type','App\Models\PrepareExams\Course')->get();
            DB::commit();
        }
        catch(\Exception $e){
            DB::rollBack();
            $error = $e->getMessage();
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }
    public function syncAchievementGet($id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            DB::beginTransaction();
            $achievements = Achievement::where('course_id',$id)->where('course_type','App\Models\PrepareExams\Course')->where('active',1)->get();
            $object = $achievements;
            DB::commit();
        }
        catch(\Exception $e){
            DB::rollBack();
            $object = array();
            $error = $e->getMessage();
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }
    public function syncRequierementGet($id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            DB::beginTransaction();
            $requierements = Requirement::where('course_id',$id)->where('course_type','App\Models\PrepareExams\Course')->where('active',1)->get();
            $object = $requierements;
            DB::commit();
        }
        catch(\Exception $e){
            DB::rollBack();
            $object = array();
            $error = $e->getMessage();
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }
    public function syncTagGet($id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            DB::beginTransaction();
            $tag = Tag::where('course_id',$id)->where('course_type','App\Models\PrepareExams\Course')->get();
            $object = $tag;
            DB::commit();
        }
        catch(\Exception $e){
            DB::rollBack();
            $object = array();
            $error = $e->getMessage();
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function syncSections($id, array $data){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            DB::beginTransaction();
            $course = Course::find($id);
            $sections = Section::where('course_id',$id)->where('deleted_at',null)->get();
            // var olan sectionları ve lessonsları sil
            foreach ($sections as $item){
                $lessons = Lesson::where('section_id',$item->id)->where('deleted_at',null)->get();
                foreach ($lessons as $lesson){
                    $lesson->delete();
                }
                $item->delete();
            }

            // yeni sectionları ekle
            foreach ($data as $key => $section){
                $newSection = new Section();
                $newSection->course_id = $id;
                $newSection->no = $key;
                $newSection->name = $section['name'];
                $newSection->save();
            }
            $object = $course->sections;
            DB::commit();
        }
        catch(\Exception $e){
            DB::rollBack();
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }
    public function syncLesson($id, array $data){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            DB::beginTransaction();
            $course = Course::find($id);
            $sections = $course->sections;
            // yeni lessons ekle
            foreach ($data as $key => $section){
                foreach($section['lessons'] as $key_lesson => $lesson){
                    $objLesson = new Lesson();
                    $objLesson->section_id = $sections[$key]->id;
                    $objLesson->is_video = $lesson['is_video'];
                    $objLesson->no = $key_lesson;
                    $objLesson->long = 1;
                    $file = Request::file($lesson['file']);
                    $filename = $file->getClientOriginalName();
                    $path = public_path().'/storage/app/lessons';
                    $objLesson->file_path = $file->move($path, $filename);
                    //$videoPath = Storage::url($data['image']->store('public/videos'));
                    //$objLesson->file_path = "boş";
                    $objLesson->preview = $lesson['is_preview'];
                    $objLesson->name = $lesson['name'];
                    $objLesson->save();
                }
            }
            DB::commit();
        }
        catch(\Exception $e){
            DB::rollBack();
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }
    public function syncSource($id,$data){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            DB::beginTransaction();
            $course = Course::find($id);
            $sections = $course->sections;
            $myLessons = $sections->lessons;

            // yeni source ekle
            foreach ($data as $key => $section){
                foreach($section['lessons'] as $key_lesson => $lesson){
                    $objLesson = new Lesson();
                    $objLesson->section_id = $sections[$key]->id;
                    $objLesson->is_video = $lesson['isVideo'];
                    $objLesson->no = $key_lesson;
                    $objLesson->long = 1;
                    $videoPath = Storage::url($data['image']->store('public/videos'));
                    $objLesson->file_path = $videoPath;
                    $objLesson->preview = $lesson['isPreview'];
                    $objLesson->name = $lesson['name'];
                    $objLesson->save();
                }
            }
            DB::commit();
        }
        catch(\Exception $e){
            DB::rollBack();
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function syncSectionGet($id){
        // section->lessonsları çek

        // Response variables
        $result = true;
        $error = null;
        $object = null;

        try{
            DB::beginTransaction();

            $object = array();
            $course = Course::find($id);
            $sections = Section::where('course_id',$id)->where('deleted_at',null)->orderBy('no','asc')->get();
            foreach ($sections as $keySection=>$section){
                $subject = Subject::find($section->subject_id);
                $sections[$keySection]['subject_name'] = $subject->name;
            }

            $object['sections'] = $sections;
            foreach ($sections as $key => $section){
                $lessons = Lesson::where('section_id',$section->id)->where('deleted_at',null)->where('active',true)->orderBy('no','asc')->get();
                $object['sections'][$key]['lessons'] = $lessons;
                foreach ($lessons as $keyLesson => $lesson){
                    $sources = $lesson->sources;
                    $object['sections'][$key]['lessons'][$keyLesson]['sources'] = $sources;
                }
            }

            DB::commit();
        }
        catch(\Exception $e){
            DB::rollBack();
            $error = $e->getMessage();
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }
    public function syncInstructor($course_id,$data){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        $isManagers = array();
        foreach ($data as $key => $item){
            $geCoursesInstructor = DB::table('ge_courses_instructors')->where('course_id',$course_id)
                ->where('deleted_at',null)->where('instructor_id',$item['instructor_id'])
                ->where('course_type','App\Models\PrepareExams\Course')->get();
            try {
                if($geCoursesInstructor[0]->is_manager == 1){
                    $isManagers[$key] = 1;
                }
                else{
                    $isManagers[$key] = 0;
                }
            } catch(\Exception $e){
                $isManagers[$key] = 0;
            }
        }

        try{
            DB::beginTransaction();
            $course = Course::find($course_id);
            DB::table("ge_courses_instructors")->where('course_id',$course_id)
                ->where('course_type','App\Models\PrepareExams\Course')->delete();
            foreach ($data as $key => $item){
                DB::table("ge_courses_instructors")->insert(array(
                    'course_id' => $course_id,
                    'course_type' => 'App\Models\PrepareExams\Course',
                    'instructor_id' => $item['instructor_id'],
                    'is_manager' => $isManagers[$key],
                    'percent' => $item['percent'],
                    'active' => true
                ));
            }
            $object = $course->instructors;
            DB::commit();
        }
        catch(\Exception $e){
            DB::rollBack();
            $error = $e->getMessage();
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }
    public function syncInstructorGet($id){
        // Response variables
        $result = true;
        $error = null;
        $object = array();

        // Operations
        try{
            $geCourseInstructor =  DB::table("ge_courses_instructors")->where('course_id',$id)->where('course_type','App\Models\PrepareExams\Course')->where('active',true)->get();
            foreach ($geCourseInstructor as $key => $item){
                if($item->is_manager == true){
                    $temp = $geCourseInstructor[0];
                    $geCourseInstructor[0] = $item;
                    $geCourseInstructor[$key] = $temp;
                    break;
                }
            }
            $object = array();
            foreach ($geCourseInstructor as $key => $item){
                if($item->is_manager == true){
                    $object[$key] = Instructor::find($item->instructor_id);
                    $object[$key]['is_manager'] = true;
                    $object[$key]['percent'] = $item->percent;
                }
                else{
                    $object[$key] = Instructor::find($item->instructor_id);
                    $object[$key]['is_manager'] = false;
                    $object[$key]['percent'] = $item->percent;
                }
            }
        }
        catch(\Exception $e){
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function updateImage($id, array $data){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            DB::beginTransaction();
            $object = Course::find($id);
            $imagePath = $data['image']->store('public/images');
            Storage::delete($object->image);
            $object->imagePath = $imagePath;
            $object->save();
            DB::commit();
        }
        catch(\Exception $e){
            DB::rollBack();
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function getSections($id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $course = Course::find($id);
            $object = $course->sections->where('active', true);
        }
        catch(\Exception $e){
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function getManagerInstructor($id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = DB::select('SELECT * FROM auth_instructors WHERE id=(SELECT instructor_id FROM ge_courses_instructors WHERE course_id='.$id.' AND is_manager=1 LIMIT 1)');
        }
        catch(\Exception $e){
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function getCoursesFromInstructors($id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = DB::select('SELECT * FROM ge_courses WHERE id NOT IN( '.$id.' ) AND id IN (SELECT course_id FROM ge_courses_instructors WHERE instructor_id IN (SELECT instructor_id FROM ge_courses_instructors WHERE course_id='.$id.')) ORDER BY point DESC LIMIT 10');
        }
        catch(\Exception $e){
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function getSimilarCourses($id,$user_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $course = Course::find($id);
            $courses = Course::where('lesson_id',$course->lesson_id)->where('deleted_at',null)->where('exam_id',$course->exam_id)
                ->where('active',true)->get();
            if(count($courses)>2){
                $object = $courses->random(2);
            }
            else if(count($courses)==2){
                $object = $courses;
            }
            else{
                $object = array();
            }
            // exam bilgisini ver
            if(count($object)>0){
                foreach ($object as $key => $item){
                    $exam = Exam::find($item->exam_id);
                    $object[$key]['exam'] = $exam;
                }
            }

            if(count($object) > 0 and $user_id != null){
                foreach ($object as $key => $item){
                    $contorlBasket = DB::table('basket')->where('user_id',$user_id)->where('course_id',$item->id)->where('course_type','App\Models\PrepareExams\Course')->get();
                    if($contorlBasket !=  null and count($contorlBasket) > 0){
                        $object[$key]['inBasket'] = true;
                    }
                    else{
                        $object[$key]['inBasket'] = false;
                    }

                    $contorlFav = DB::table('favorite')->where('user_id',$user_id)->where('course_id',$item->id)->where('course_type','App\Models\PrepareExams\Course')->get();
                    if($contorlFav !=  null and count($contorlFav) > 0){
                        $object[$key]['inFavorite'] = true;
                    }
                    else{
                        $object[$key]['inFavorite'] = false;
                    }
                }
            }
        }
        catch(\Exception $e){
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function getComments($id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $course = Course::find($id);
            $object = $course->comments->where('active', true)->orderBy('created_at', 'desc');
        }
        catch(\Exception $e){
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function getCommentsWithPaginate($id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $course = Course::find($id);
            $object = Comment::where('course_id', $id)->where('active', true)->orderBy('created_at', 'desc')->paginate(10);
        }
        catch(\Exception $e){
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function getDiscounts($id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $course = Course::find($id);
            $object = $course->discounts->where('active', true);
        }
        catch(\Exception $e){
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function getNotices($id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $course = Course::find($id);
            $object = $course->notices->where('active', true);
        }
        catch(\Exception $e){
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function getFavorites($id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $course = Course::find($id);
            $object = $course->favorites;
        }
        catch(\Exception $e){
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function getPurchases($id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $course = Course::find($id);
            $object = $course->purchases;
        }
        catch(\Exception $e){
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function getEntries($id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $course = Course::find($id);
            $object = $course->entries->where('active', true);
        }
        catch(\Exception $e){
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function getStudents($id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Entry::where('course_id', $id)->where('course_type', 'App\Models\PrepareExams\Course')->where('active', true)->orderBy('created_at', 'desc')->take(3)->get();
        }
        catch(\Exception $e){
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function getExam($id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $course = Course::find($id);
            $object = $course->exam;
        }
        catch(\Exception $e){
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function getLesson($id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $course = Course::find($id);
            $object = $course->lesson;
        }
        catch(\Exception $e){
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function calculateProgress($course_id, $student_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $student = Student::find($student_id);
            $sections = Section::where('course_id',$course_id)->where('deleted_at',null)->where('active',true)->get()->toArray();

            $lessons = array();
            foreach ($sections as $section){
                $tempLessons = Lesson::where('section_id',$section['id'])->where('deleted_at',null)->where('active',true)->get()->toArray();
                foreach ($tempLessons as $lesson){
                    array_push($lessons,$lesson);
                }

            }

            // tamamlanmış dersleri al
            $completedLessons = DB::table('ge_students_completed_lessons')
                ->where('student_id',$student->id)
                ->where('lesson_type','App\Models\PrepareExams\Lesson')->get();
            $completeCount = 0;
            foreach ($lessons as $lesson){
                foreach ($completedLessons as $completedLessonn){
                    if($lesson['id'] == $completedLessonn->lesson_id){;
                        $completeCount = $completeCount + 1;
                        break;
                    }
                }
            }

            $progress = 0;
            $progress = ($completeCount/count($lessons))*100;
            $object = $progress;

            /* $student = Student::where('user_id', $user_id)->first();
             $lessonsArray = array();
             $course = Course::find($course_id);
             $sections = $course->sections;
             $student = Student::find($student->id);
             $completedArray = array();
             foreach ($sections as $section){
                 $lessons = $section->lessons;
                 foreach ($lessons as $lesson){
                     array_push($lessonsArray, $lesson->id);
                 }
             }
             $lessonCount = count($lessonsArray);
             $completedCount = 0;
             foreach ($student->geCompleted as $completed){
                 if($completed->pivot->is_completed == true){
                     array_push($completedArray, $completed->id);
                 }
             }
             foreach ($lessonsArray as $lesson_id){
                 if(in_array($lesson_id, $completedArray)){
                     $completedCount = $completedCount + 1;
                 }
             }
             $progressPercent = number_format($completedCount * (100/$lessonCount), 0);
             $object = $progressPercent;*/
        }
        catch(\Exception $e){
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function getCompletedLessons($course_id, $user_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $student = Student::where('user_id', $user_id)->first();
            $lessons = DB::select('SELECT lesson_id FROM ge_students_completed_lessons WHERE is_completed=1 AND student_id='.$student->id.' AND lesson_id IN (SELECT id FROM pe_lessons WHERE section_id IN (SELECT id FROM pe_sections WHERE course_id='.$course_id.'))');
            $object = array();
            foreach ($lessons as $lesson){
                array_push($object, $lesson->lesson_id);
            }
        }
        catch(\Exception $e){
            $error = $e;
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function getPreviewLessons($id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $previewLessons = array();
            $course = Course::find($id);
            $sections = $course->sections;
            foreach ($sections as $section){
                $lessons = $section->lessons;
                foreach ($lessons as $lesson){
                    if($lesson->preview == 1){
                        array_push($previewLessons,$lesson);
                    }
                }
            }
            $object = $previewLessons;

        }
        catch(\Exception $e){
            $error = $e->getMessage();
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function getSubjects($id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $plCourse = Course::find($id);
            $subjects = Subject::where('lesson_id',$plCourse->lesson_id)->where('deleted_at',null)->get();
            $object = $subjects;
        }
        catch(\Exception $e){
            $error = $e->getMessage();
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function getSubjectsForLesson($id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $subjects = Subject::where('lesson_id',$id)->where('deleted_at',null)->get();
            $object = $subjects;
        }
        catch(\Exception $e){
            $error = $e->getMessage();
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function getRandomQuestions($courseId,$crLessonId,$crSubjectId){
        // Response variables
        $result = true;
        $error = null;
        $object = array();

        // Operations
        try{
            $insructorsCourses = DB::table('ge_courses_instructors')->where('course_type','App\Models\PrepareExams\Course')
                ->where('course_id',$courseId)->get();
            $instructorsId = array();
            foreach ($insructorsCourses as $course){
                array_push($instructorsId,$course->instructor_id);
            }

            $i = 0;
            $object['questions'] = array();
            $questions1 = Question::where('level',1)->where('crLessonId',$crLessonId)->where('crSubjectId',$crSubjectId)->whereIn('instructorId',$instructorsId)->where('isConfirm',true)->get();
            if(count($questions1) > 3)
                $questions1 = $questions1->random(3);
            foreach ($questions1 as $question){
                $object['questions'][$i] = $question;
                $object['questions'][$i]['answers'] = $this->getAnswers($question);
                $i++;
            }
            $questions2 = Question::where('level',2)->where('crLessonId',$crLessonId)->where('crSubjectId',$crSubjectId)->whereIn('instructorId',$instructorsId)->where('isConfirm',true)->get();
            if(count($questions2) > 3)
                $questions2 = $questions2->random(4);
            foreach ($questions2 as $question){
                $object['questions'][$i] = $question;
                $object['questions'][$i]['answers'] = $this->getAnswers($question);
                $i++;
            }
            $questions3 = Question::where('level',3)->where('crLessonId',$crLessonId)->where('crSubjectId',$crSubjectId)->whereIn('instructorId',$instructorsId)->where('isConfirm',true)->get();
            if(count($questions3) > 3)
                $questions3 = $questions3->random(3);
            foreach ($questions3 as $question){
                $object['questions'][$i] = $question;
                $object['questions'][$i]['answers'] = $this->getAnswers($question);
                $i++;
            }
        }
        catch(\Exception $e){
            $error = $e->getMessage();
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }
    private function getAnswers($question){
        $answers = null;

        if($question->type == "App\Models\QuestionSource\SingleChoice"){
            $question->type = "singleChoice";
            $answers = SingleChoice::where('questionId',$question->id)->get()->toArray();
            shuffle($answers);
        }
        else if($question->type == "App\Models\QuestionSource\MultiChoice"){
            $question->type = "multiChoice";
            $answers = MultiChoice::where('questionId',$question->id)->get()->toArray();
            shuffle($answers);
        }
        else if($question->type == "App\Models\QuestionSource\GapFilling"){
            $question->type = "fillBlank";
            $answers = GapFilling::where('questionId',$question->id)->get()->toArray();
            shuffle($answers);
        }
        else if($question->type == "App\Models\QuestionSource\TrueFalse"){
            $question->type = "trueFalse";
            $answers = TrueFalse::where('questionId',$question->id)->get()->toArray();
            shuffle($answers);
        }
        else if($question->type == "App\Models\QuestionSource\Match"){
            $question->type = "match";
            $temp = Match::where('questionId',$question->id)->get()->toArray();
            $answers = array();
            $tempContents = array();
            $tempAnswers = array();
            foreach ($temp as $key => $temp){
                $tempContents[$key]['content'] = $temp;
                $tempAnswers[$key]['answer'] = $temp;
            }
            shuffle($tempAnswers);
            $answers['contents'] = $tempContents;
            $answers['answers'] = $tempAnswers;
        }
        else if($question->type == "App\Models\QuestionSource\Order"){
            $question->type = "order";
            $answers = Order::where('questionId',$question->id)->get()->toArray();
            shuffle($answers);
        }

        if($answers == null){
            $answers = array();
            return $answers;
        }
        else{
            return $answers;
        }
    }

    public function inBasket($user_id,$course_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        $control = DB::table('basket')->where('user_id',$user_id)
            ->where('course_id',$course_id)
            ->where('course_type','App\Models\PrepareExams\Course')->get();
        if($control!=null and count($control)>0){
            $object = true;
        }
        else{
            $object = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function getBySubCategoryFilterByNewest($examId,$user_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Course::where('exam_id', $examId)
                ->where('active', true)
                ->where('deleted_at',null)
                ->latest()
                ->paginate(9);

            // grade bilgisi
            foreach ($object as $key => $course){
                $exam = Exam::find($course->exam_id);
                $object[$key]['exam'] = $exam;
            }

            # inBasket ve inFavorite bilgileri
            if($user_id != null){
                foreach ($object as $key=> $item){
                    $controlBasket = Basket::where('user_id',$user_id)->where('course_type','App\Models\PrepareExams\Course')
                        ->where('course_id',$item->id)->get();
                    if($controlBasket != null and count($controlBasket) > 0){
                        $object[$key]['inBasket'] = true;
                    }
                    else{
                        $object[$key]['inBasket'] = false;
                    }

                    $controlFavorite = Favorite::where('user_id',$user_id)->where('course_type','App\Models\PrepareExams\Course')
                        ->where('course_id',$item->id)->get();
                    if($controlFavorite != null and count($controlFavorite) > 0){
                        $object[$key]['inFavorite'] = true;
                    }
                    else{
                        $object[$key]['inFavorite'] = false;
                    }
                }
            }
            else{
                foreach ($object as $key => $item){
                    $object[$key]['inBasket'] = null;
                    $object[$key]['inFavorite'] = null;
                }
            }

        }
        catch(\Exception $e){
            $error = $e->getMessage();
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }
    public function getBySubCategoryFilterByOldest($examId,$user_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Course::where('exam_id', $examId)
                ->where('active', true)
                ->where('deleted_at',null)
                ->oldest()
                ->paginate(9);

          /*  // lesson ve grade bilgisi
            foreach ($object as $key => $course){
                $grade = Grade::find($course->grade_id);
                $lesson = \App\Models\Curriculum\Lesson::find($course->lesson_id);
                $object[$key]['grade'] = $grade;
                $object[$key]['lesson'] = $lesson;
            }*/

            # inBasket ve inFavorite bilgileri
            if($user_id != null){
                foreach ($object as $key=> $item){
                    $controlBasket = Basket::where('user_id',$user_id)->where('course_type','App\Models\PrepareExams\Course')
                        ->where('course_id',$item->id)->get();
                    if($controlBasket != null and count($controlBasket) > 0){
                        $object[$key]['inBasket'] = true;
                    }
                    else{
                        $object[$key]['inBasket'] = false;
                    }

                    $controlFavorite = Favorite::where('user_id',$user_id)->where('course_type','App\Models\PrepareExams\Course')
                        ->where('course_id',$item->id)->get();
                    if($controlFavorite != null and count($controlFavorite) > 0){
                        $object[$key]['inFavorite'] = true;
                    }
                    else{
                        $object[$key]['inFavorite'] = false;
                    }
                }
            }
            else{
                foreach ($object as $key => $item){
                    $object[$key]['inBasket'] = null;
                    $object[$key]['inFavorite'] = null;
                }
            }
        }
        catch(\Exception $e){
            $error = $e->getMessage();
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }
    public function getBySubCategoryFilterByPriceASC($examId,$user_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Course::where('exam_id', $examId)
                ->where('active', true)
                ->where('deleted_at',null)
                ->orderBy('price_with_discount', 'asc')
                ->paginate(9);

          /*  // lesson ve grade bilgisi
            foreach ($object as $key => $course){
                $grade = Grade::find($course->grade_id);
                $lesson = \App\Models\Curriculum\Lesson::find($course->lesson_id);
                $object[$key]['grade'] = $grade;
                $object[$key]['lesson'] = $lesson;
            }*/

            # inBasket ve inFavorite bilgileri
            if($user_id != null){
                foreach ($object as $key=> $item){
                    $controlBasket = Basket::where('user_id',$user_id)->where('course_type','App\Models\PrepareExams\Course')
                        ->where('course_id',$item->id)->get();
                    if($controlBasket != null and count($controlBasket) > 0){
                        $object[$key]['inBasket'] = true;
                    }
                    else{
                        $object[$key]['inBasket'] = false;
                    }

                    $controlFavorite = Favorite::where('user_id',$user_id)->where('course_type','App\Models\PrepareExams\Course')
                        ->where('course_id',$item->id)->get();
                    if($controlFavorite != null and count($controlFavorite) > 0){
                        $object[$key]['inFavorite'] = true;
                    }
                    else{
                        $object[$key]['inFavorite'] = false;
                    }
                }
            }
            else{
                foreach ($object as $key => $item){
                    $object[$key]['inBasket'] = null;
                    $object[$key]['inFavorite'] = null;
                }
            }
        }
        catch(\Exception $e){
            $error = $e->getMessage();
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }
    public function getBySubCategoryFilterByPriceDESC($examId,$user_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Course::where('exam_id', $examId)
                ->where('active', true)
                ->where('deleted_at',null)
                ->orderBy('price_with_discount', 'desc')
                ->paginate(9);

            /*// lesson ve grade bilgisi
            foreach ($object as $key => $course){
                $grade = Grade::find($course->grade_id);
                $lesson = \App\Models\Curriculum\Lesson::find($course->lesson_id);
                $object[$key]['grade'] = $grade;
                $object[$key]['lesson'] = $lesson;
            }*/

            # inBasket ve inFavorite bilgileri
            if($user_id != null){
                foreach ($object as $key=> $item){
                    $controlBasket = Basket::where('user_id',$user_id)->where('course_type','App\Models\PrepareExams\Course')
                        ->where('course_id',$item->id)->get();
                    if($controlBasket != null and count($controlBasket) > 0){
                        $object[$key]['inBasket'] = true;
                    }
                    else{
                        $object[$key]['inBasket'] = false;
                    }

                    $controlFavorite = Favorite::where('user_id',$user_id)->where('course_type','App\Models\PrepareExams\Course')
                        ->where('course_id',$item->id)->get();
                    if($controlFavorite != null and count($controlFavorite) > 0){
                        $object[$key]['inFavorite'] = true;
                    }
                    else{
                        $object[$key]['inFavorite'] = false;
                    }
                }
            }
            else{
                foreach ($object as $key => $item){
                    $object[$key]['inBasket'] = null;
                    $object[$key]['inFavorite'] = null;
                }
            }
        }
        catch(\Exception $e){
            $error = $e->getMessage();
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }
    public function getBySubCategoryFilterByPoint($examId,$user_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Course::where('exam_id', $examId)
                ->where('active', true)
                ->where('deleted_at',null)
                ->orderBy('point', 'desc')
                ->paginate(9);

           /* // lesson ve grade bilgisi
            foreach ($object as $key => $course){
                $grade = Grade::find($course->grade_id);
                $lesson = \App\Models\Curriculum\Lesson::find($course->lesson_id);
                $object[$key]['grade'] = $grade;
                $object[$key]['lesson'] = $lesson;
            }*/

            # inBasket ve inFavorite bilgileri
            if($user_id != null){
                foreach ($object as $key=> $item){
                    $controlBasket = Basket::where('user_id',$user_id)->where('course_type','App\Models\PrepareExams\Course')
                        ->where('course_id',$item->id)->get();
                    if($controlBasket != null and count($controlBasket) > 0){
                        $object[$key]['inBasket'] = true;
                    }
                    else{
                        $object[$key]['inBasket'] = false;
                    }

                    $controlFavorite = Favorite::where('user_id',$user_id)->where('course_type','App\Models\PrepareExams\Course')
                        ->where('course_id',$item->id)->get();
                    if($controlFavorite != null and count($controlFavorite) > 0){
                        $object[$key]['inFavorite'] = true;
                    }
                    else{
                        $object[$key]['inFavorite'] = false;
                    }
                }
            }
            else{
                foreach ($object as $key => $item){
                    $object[$key]['inBasket'] = null;
                    $object[$key]['inFavorite'] = null;
                }
            }
        }
        catch(\Exception $e){
            $error = $e->getMessage();
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }
    public function getBySubCategoryFilterByPurchases($examId,$user_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Course::where('exam_id', $examId)
                ->where('active', true)
                ->where('deleted_at',null)
                ->orderBy('purchase_count', 'desc')
                ->paginate(9);

            /*// lesson ve grade bilgisi
            foreach ($object as $key => $course){
                $grade = Grade::find($course->grade_id);
                $lesson = \App\Models\Curriculum\Lesson::find($course->lesson_id);
                $object[$key]['grade'] = $grade;
                $object[$key]['lesson'] = $lesson;
            }*/

            # inBasket ve inFavorite bilgileri
            if($user_id != null){
                foreach ($object as $key=> $item){
                    $controlBasket = Basket::where('user_id',$user_id)->where('course_type','App\Models\PrepareExams\Course')
                        ->where('course_id',$item->id)->get();
                    if($controlBasket != null and count($controlBasket) > 0){
                        $object[$key]['inBasket'] = true;
                    }
                    else{
                        $object[$key]['inBasket'] = false;
                    }

                    $controlFavorite = Favorite::where('user_id',$user_id)->where('course_type','App\Models\PrepareExams\Course')
                        ->where('course_id',$item->id)->get();
                    if($controlFavorite != null and count($controlFavorite) > 0){
                        $object[$key]['inFavorite'] = true;
                    }
                    else{
                        $object[$key]['inFavorite'] = false;
                    }
                }
            }
            else{
                foreach ($object as $key => $item){
                    $object[$key]['inBasket'] = null;
                    $object[$key]['inFavorite'] = null;
                }
            }
        }
        catch(\Exception $e){
            $error = $e->getMessage();
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }
    public function getBySubCategoryFilterByTrending($examId,$user_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Course::where('exam_id', $examId)
                ->where('active', true)
                ->where('deleted_at',null)
                ->orderBy('purchase_count', 'desc')
                ->orderBy('point','desc')
                ->paginate(9);

         /*   // lesson ve grade bilgisi
            foreach ($object as $key => $course){
                $grade = Grade::find($course->grade_id);
                $lesson = \App\Models\Curriculum\Lesson::find($course->lesson_id);
                $object[$key]['grade'] = $grade;
                $object[$key]['lesson'] = $lesson;
            }*/

            # inBasket ve inFavorite bilgileri
            if($user_id != null){
                foreach ($object as $key=> $item){
                    $controlBasket = Basket::where('user_id',$user_id)->where('course_type','App\Models\PrepareExams\Course')
                        ->where('course_id',$item->id)->get();
                    if($controlBasket != null and count($controlBasket) > 0){
                        $object[$key]['inBasket'] = true;
                    }
                    else{
                        $object[$key]['inBasket'] = false;
                    }

                    $controlFavorite = Favorite::where('user_id',$user_id)->where('course_type','App\Models\PrepareExams\Course')
                        ->where('course_id',$item->id)->get();
                    if($controlFavorite != null and count($controlFavorite) > 0){
                        $object[$key]['inFavorite'] = true;
                    }
                    else{
                        $object[$key]['inFavorite'] = false;
                    }
                }
            }
            else{
                foreach ($object as $key => $item){
                    $object[$key]['inBasket'] = null;
                    $object[$key]['inFavorite'] = null;
                }
            }
        }
        catch(\Exception $e){
            $error = $e->getMessage();
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function buy($courseId,$data){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            DB::beginTransaction();
            // öğrenciyi purchase tablosuna kaydet.
            $object = new Purchase();
            $object->user_id =  $data['userId'];
            $user = User::find($data['userId']);
            $object->student_id = $user->student->id;
            $object->course_id = $courseId;
            $object->course_type = 'App\Models\PrepareExams\Course';
            $object->price = $data['price'];
            $object->confirmation = true;
            $object->save();

            //  öğrenciyi entry tablosuna kaydet.
            $object = null;
            $object = new Entry();
            $object->course_id = $courseId;
            $object->course_type = 'App\Models\PrepareExams\Course';
            $object->student_id = $user->student->id;

            $course = Course::find($courseId);
            $today = date("Y/m/d");
            $accessTime = $course->access_time;
            $object->access_start = $today;
            $object->access_finish = date('Y-m-d', strtotime('+ '.$accessTime.' months', strtotime($today)));
            $object->active = true;
            $object->save();
            DB::commit();
        }
        catch(\Exception $e){
            DB::rollBack();
            $error = $e->getMessage();
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function deleteCourse($courseId,$data){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            DB::beginTransaction();
            $user = User::find($data['userId']);
            $instructor = $user->instructor;
            if($instructor != null){
                $hasCourse = DB::table('ge_courses_instructors')->where('course_id',$courseId)
                    ->where('course_type','App\Models\PrepareExams\Course')
                    ->where('deleted_at',null)
                    ->where('instructor_id',$instructor->id)
                    ->where('is_manager',true)->get();
                if($hasCourse != null and count($hasCourse)>0){
                    $now = date('Y-m-d', time());
                    $flag = false;
                    $entries = Entry::where('course_id',$courseId)->where('course_type','App\Models\PrepareExams\Course')->where('active',true)->get();
                    foreach ($entries as $entry){
                        if(date('Y-m-d',strtotime($entry->access_start))<=$now and date('Y-m-d',strtotime($entry->access_finish))>=$now){
                            $flag = true;
                            break;
                        }
                    }
                    if($flag == false){
                        // kurs ve kursa ait tüm bilgileri sil
                        $course = Course::find($courseId);
                        $sections = Section::where('course_id',$courseId)->where('deleted_at',null)->where('deleted_at',null)->get();
                        foreach ($sections as $section){
                            $lessons = Lesson::where('section_id',$section->id)->where('deleted_at',null)->get();
                            foreach ($lessons as $lesson){
                                $sources = Source::where('lesson_id',$lesson->id)->where('deleted_at',null)->where('lesson_type','App\Models\PrepareExams\Lesson')->get();
                                foreach ($sources as $source){
                                    $source->delete();
                                }
                                $lesson->delete();
                            }
                            $section->delete();
                        }
                        $course->delete();
                        DB::table('ge_courses_instructors')
                            ->where('course_id',$courseId)
                            ->where('course_type','App\Models\PrepareExams\Course')->update(['deleted_at' => date('Y-m-d H:i:s')]);
                    }
                    else{
                        $error = "Kursa sahip öğrenci bulunmaktadır.Bu yüzden kursu silemezsiniz.";
                        $result = false;
                    }
                }
                else{
                    $error = "Bu kursun eğitmeni veya yönetici değilsiniz.Erişiminiz bulunmamaktadır.";
                    $result = false;
                }
            }
            else{
                $error = "Eğitmen değilsiniz.Erişiminiz bulunmamaktadır.";
                $result = false;
            }
            DB::commit();
        }
        catch(\Exception $e){
            DB::rollBack();
            $error = $e->getMessage();
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function activeCourse($courseId,$data){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            DB::beginTransaction();
            $user = User::find($data['userId']);
            $instructor = $user->instructor;
            if($instructor != null){
                $hasCourse = DB::table('ge_courses_instructors')->where('course_id',$courseId)
                    ->where('course_type','App\Models\PrepareExams\Course')
                    ->where('deleted_at',null)
                    ->where('instructor_id',$instructor->id)
                    ->where('is_manager',true)->get();
                if($hasCourse != null and count($hasCourse)>0){
                    $course = Course::find($courseId);
                    $course->active = true;
                    $course->save();
                }
                else{
                    $error = "Bu kursun eğitmeni veya yönetici değilsiniz.Erişiminiz bulunmamaktadır.";
                    $result = false;
                }
            }
            else{
                $error = "Eğitmen değilsiniz.Erişiminiz bulunmamaktadır.";
                $result = false;
            }
            DB::commit();
        }
        catch(\Exception $e){
            DB::rollBack();
            $error = $e->getMessage();
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function passiveCourse($courseId,$data){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            DB::beginTransaction();
            $user = User::find($data['userId']);
            $instructor = $user->instructor;
            if($instructor != null){
                $hasCourse = DB::table('ge_courses_instructors')->where('course_id',$courseId)
                    ->where('course_type','App\Models\PrepareExams\Course')
                    ->where('deleted_at',null)
                    ->where('instructor_id',$instructor->id)
                    ->where('is_manager',true)->get();
                if($hasCourse != null and count($hasCourse)>0){
                    $course = Course::find($courseId);
                    $course->active = false;
                    $course->save();
                }
                else{
                    $error = "Bu kursun eğitmeni veya yönetici değilsiniz.Erişiminiz bulunmamaktadır.";
                    $result = false;
                }
            }
            else{
                $error = "Eğitmen değilsiniz.Erişiminiz bulunmamaktadır.";
                $result = false;
            }
            DB::commit();
        }
        catch(\Exception $e){
            DB::rollBack();
            $error = $e->getMessage();
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function getExams(){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $object = Exam::all();
        }
        catch(\Exception $e){
            $error = $e->getMessage();
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }
}

