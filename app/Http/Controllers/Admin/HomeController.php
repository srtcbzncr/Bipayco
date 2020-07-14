<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Auth\Admin;
use App\Models\Auth\Instructor;
use App\Models\Auth\User;
use App\Repositories\Admin\DashboardRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
        $user = Auth::user();
        $admin = Admin::where('user_id',$user->id)->where('active',true)->where('deleted_at',null)->first();
        if($admin != null){
            return view('admin.sales');
        }
        else{
            return redirect()->back();
        }

    }

    public function instructorsFeeWithReferenceCode(){
        $user = Auth::user();
        $admin = Admin::where('user_id',$user->id)->where('active',true)->where('deleted_at',null)->first();
        if($admin != null){
            return view('admin.promotion_payment');
        }
        else{
            return redirect()->back();
        }

    }

    public function contracts(){
        $user = Auth::user();
        $admin = Admin::where('user_id',$user->id)->where('active',true)->where('deleted_at',null)->first();
        if($admin != null){
            return view('admin.contracts');
        }
        else{
            return redirect()->back();
        }

    }

    public function contractPost(Request $request){
        $user = Auth::user();
        $admin = Admin::where('user_id',$user->id)->where('active',true)->where('deleted_at',null)->first();
        if($admin==null){
            return redirect()->back();
        }
        if($request->hasFile('cookies_policy')){
            $file = $request->file('cookies_policy');
            Storage::disk('contracts')->putFileAs('', $file,'cookiesPolicy.pdf');
            return redirect()->back();
        }
        else if($request->hasFile('who_we_are')){
            $file = $request->file('who_we_are');
            Storage::disk('contracts')->putFileAs('', $file,'whoWeAre.pdf');
            return redirect()->back();
        }
        else if($request->hasFile('pre_information_form')){
            $file = $request->file('pre_information_form');
            Storage::disk('contracts')->putFileAs('', $file,'preInformationForm.pdf');
            return redirect()->back();
        }
        else if($request->hasFile('faq')){
            $file = $request->file('faq');
            Storage::disk('contracts')->putFileAs('', $file,'faq.pdf');
            return redirect()->back();
        }
        else if($request->hasFile('subscription')){
            $file = $request->file('subscription');
            Storage::disk('contracts')->putFileAs('', $file,'subscription.pdf');
            return redirect()->back();
        }
        else if($request->hasFile('sales')){
            $file = $request->file('sales');
            Storage::disk('contracts')->putFileAs('', $file,'salesContract.pdf');
            return redirect()->back();
        }
        else if($request->hasFile('kvkk_illuminate')){
            $file = $request->file('kvkk_illuminate');
            Storage::disk('contracts')->putFileAs('', $file,'kvkkAydinlatma.pdf');
            return redirect()->back();
        }
        else if($request->hasFile('intellectual_property_policy')){
            $file = $request->file('intellectual_property_policy');
            Storage::disk('contracts')->putFileAs('', $file,'fikriMulkiyetPolitikasi.pdf');
            return redirect()->back();
        }
        else if($request->hasFile('privacy_terms')){
            $file = $request->file('privacy_terms');
            Storage::disk('contracts')->putFileAs('', $file,'gizlilikPolitikasi.pdf');
            return redirect()->back();
        }
        else if($request->hasFile('term_of_use')){
            $file = $request->file('term_of_use');
            Storage::disk('contracts')->putFileAs('', $file,'kullanimKosullari.pdf');
            return redirect()->back();
        }
        else if($request->hasFile('member_obligations')){
            $file = $request->file('member_obligations');
            Storage::disk('contracts')->putFileAs('', $file,'uyeHukumleri.pdf');
            return redirect()->back();
        }

    }

    public function purchaseDetail($instructor_id){
        $user = Auth::user();
        $admin = Admin::where('user_id',$user->id)->where('active',true)->where('deleted_at',null)->first();
        if($admin != null){
            $instructor = Instructor::find($instructor_id);
            $user = User::find($instructor->id);
            $instructor['user'] = $user;

            $object = DB::table('instructor_fee_share')->where('instructor_id',$instructor_id)->where('confirm',false)->where('active',true)->get();
            $total = 0;
            foreach ($object as $item){
                $total+=$item->fee;
            }
            return view('admin.instructor_payment_detail')->with('instructor',$instructor)->with('total',$total);
        }
        else{
            return redirect()->back();
        }
    }

    public function courses(){
        $user = Auth::user();
        $admin = Admin::where('user_id',$user->id)->where('active',true)->where('deleted_at',null)->first();
        if($admin != null){
            return view('admin.courses');
        }
        else{
            return redirect()->back();
        }
    }

    public function course_detail($course_id,$course_type){
        $user = Auth::user();
        $admin = Admin::where('user_id',$user->id)->where('active',true)->where('deleted_at',null)->first();
        if($admin != null){
            return view('admin.course_detail')->with('course_id',$course_id)->with('course_type',$course_type);
        }
        else{
            return redirect()->back();
        }
    }
}
