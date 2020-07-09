<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Auth\Admin;
use App\Repositories\Admin\DashboardRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function dashboard(){
        $user = Auth::user();
        $admin = Admin::where('user_id',$user->id)->where('active',true)->where('deleted_at',null)->first();
        if($admin != null){
            $repo = new DashboardRepository();
            $resp = $repo->getDataForDashboard($admin->id);
            if($resp->getResult()){
                $data = $resp->getData();
                return view('admin.dashboard')->with('data',$data);
            }
            else{
                return redirect()->back();
            }

        }
        else{
            return redirect()->back();
        }
    }

    public function categories(){
        $user = Auth::user();
        $admin = Admin::where('user_id',$user->id)->where('active',true)->where('deleted_at',null)->first();
        if($admin != null){
            return view('admin.categories');
        }
        else{
            return redirect()->back();
        }
    }

  /*  public function subCategories(){
        return view('admin.sub_categories');
    }*/

    public function cities(){
        $user = Auth::user();
        $admin = Admin::where('user_id',$user->id)->where('active',true)->where('deleted_at',null)->first();
        if($admin != null){
            return view('admin.cities');
        }
        else{
            return redirect()->back();
        }
    }

  /*  public function districts(){
        return view('admin.districts');
    }*/

    public function grade(){
        $user = Auth::user();
        $admin = Admin::where('user_id',$user->id)->where('active',true)->where('deleted_at',null)->first();
        if($admin != null){
            return view('admin.grade');
        }
        else{
            return redirect()->back();
        }
    }

    public function exam(){
        $user = Auth::user();
        $admin = Admin::where('user_id',$user->id)->where('active',true)->where('deleted_at',null)->first();
        if($admin != null){
            return view('admin.exams');
        }
        else{
            return redirect()->back();
        }
    }

    public function lesson(){
        $user = Auth::user();
        $admin = Admin::where('user_id',$user->id)->where('active',true)->where('deleted_at',null)->first();
        if($admin != null){
            return view('admin.lesson');
        }
        else{
            return redirect()->back();
        }
    }

  /*  public function subjects(){
        return view('admin.subjects');
    }*/

    public function getSubcategoryOfCategory($categoryId){
        $user = Auth::user();
        $admin = Admin::where('user_id',$user->id)->where('active',true)->where('deleted_at',null)->first();
        if($admin == null){
            return redirect()->back();
        }

        // initializing
        $data = array();

        // operations
        $data['categoryId'] = $categoryId;
        return view('admin.sub_categories')->with('data',$data);
    }

    public function getDistrictsOfCity($cityId){
        $user = Auth::user();
        $admin = Admin::where('user_id',$user->id)->where('active',true)->where('deleted_at',null)->first();
        if($admin == null){
            return redirect()->back();
        }
        // initializing
        $data = array();

        // operations
        $data['cityId'] = $cityId;
        return view('admin.districts')->with('data',$data);
    }

    public function getSubjectsOfLesson($lessonId){
        $user = Auth::user();
        $admin = Admin::where('user_id',$user->id)->where('active',true)->where('deleted_at',null)->first();
        if($admin == null){
            return redirect()->back();
        }
        // initializing
        $data = array();

        // operations
        $data['lessonId'] = $lessonId;
        return view('admin.subjects')->with('data',$data);
    }

    public function users(){
        $user = Auth::user();
        $admin = Admin::where('user_id',$user->id)->where('active',true)->where('deleted_at',null)->first();
        if($admin == null){
            return redirect()->back();
        }
        return view('admin.users');
    }

    public function instructors(){
        $user = Auth::user();
        $admin = Admin::where('user_id',$user->id)->where('active',true)->where('deleted_at',null)->first();
        if($admin == null){
            return redirect()->back();
        }
        return view('admin.instructors');
    }

    public function guardians(){
        $user = Auth::user();
        $admin = Admin::where('user_id',$user->id)->where('active',true)->where('deleted_at',null)->first();
        if($admin == null){
            return redirect()->back();
        }
        return view('admin.guardians');
    }

    public function admins(){
        $user = Auth::user();
        $admin = Admin::where('user_id',$user->id)->where('active',true)->where('deleted_at',null)->first();
        if($admin == null){
            return redirect()->back();
        }
        return view('admin.admins');
    }

    public function purchases(){
        return view('admin.sales');
    }
}
