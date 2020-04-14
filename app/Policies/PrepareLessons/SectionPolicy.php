<?php

namespace App\Policies\PrepareLessons;

use App\Models\Auth\Student;
use App\Models\Auth\User;
use App\Models\PrepareLessons\Section;
use App\Models\QuestionSource\Student\FirstLastTestStatus;
use Illuminate\Auth\Access\HandlesAuthorization;

class SectionPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function firstLastTestControl(Student $student, Section $section){
        /*// ön/son test kontrolü
        foreach ($object['sections'] as $key=> $section){
            $flTestStatus = FirstLastTestStatus::where('studentId',$student->id)
                ->where('sectionId',$section->id)
                ->where('sectionType','App\Models\GeneralEducation\Section')->get()->toArray();

            $object['sections'][$key]['isSuccessful'] = false;
            foreach ($flTestStatus as $flKey => $status){
                if($status['result'] == true){
                    $object['sections'][$key]['isSuccessful'] = true;
                }
            }
        }*/

        // ön/son test kontrolü
        $flTestStatus = FirstLastTestStatus::where('studentId',$student->id)
            ->where('sectionId',$section->id)
            ->where('sectionType','App\Models\PrepareLessons\Section')->get()->toArray();

        $control = false;
        foreach ($flTestStatus as $flKey => $status){
            if($status['result'] == true){
                $control = true;
                break;
            }
        }
        return $control;
    }
}
