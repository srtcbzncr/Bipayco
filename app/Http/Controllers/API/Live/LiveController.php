<?php

namespace App\Http\Controllers\API\Live;

use App\Events\Live\StartLiveEvent;
use App\Http\Controllers\Controller;
use App\Models\Auth\Student;
use App\Models\Auth\User;
use App\Models\Live\Entry;
use App\Repositories\Live\LiveRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;

class LiveController extends Controller
{
    public function createLiveOnBipayco(Request $request){
        $data = $request->toArray();
        $repo = new LiveRepository();

        $resp = $repo->createLiveOnBipayco($data);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'data' => $resp->getData(),
                'message' => 'Canlı yayın başarıyla oluşturuldu.'
            ]);
        }
        return response()->json([
            'error' => true,
            'errorMessage', $resp->getError(),
            'message' => 'Canlı yayın oluşturulurken bir hata meydana geldi.Tekrar deneyin.'
        ],400);
    }

    public function updateLiveOnBipayco($course_id,Request $request){
        $data = $request->toArray();
        $repo = new LiveRepository();

        $resp = $repo->updateLiveOnBipayco($course_id,$data);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'data' => $resp->getData(),
                'message' => 'Canlı yayın başarıyla güncellendi.'
            ]);
        }
        return response()->json([
            'error' => true,
            'errorMessage', $resp->getError(),
            'message' => 'Canlı yayın güncellenirken bir hata meydana geldi.Tekrar deneyin.'
        ],400);
    }

    public function createLiveOnBBB($course_id,$user_id){
        $repo = new LiveRepository();

        $resp=$repo->createLiveOnBBB($user_id,$course_id);
        if($resp->getResult()){
            $data = $resp->getData();
            if($data['returncode'] == "SUCCESS"){
                // kursa sahip olan kişilere mail gönder.
                $entries = Entry::where('live_course_id',$course_id)->where('deleted_at',null)->get();
                foreach ($entries as $entry){
                    $student = Student::find($entry->student_id);
                    $user = User::find($student->user_id);

                    $name = $user->first_name.' '.$user->last_name;
                    $email = $user->email;
                    $dataEmail['name'] = $name;
                    $dataEmail['email'] = $email;
                    //\event(new StartLiveEvent($dataEmail));
                }


                // eğitmmen olarak join yap
                $resp_join = $repo->joinLive($user_id,$course_id);
                $data_join = $resp_join->getData();

                if($data_join!= null){
                    return response()->json([
                        'error' => false,
                        'data' => $data_join,
                        'message' => 'Canlı yayına başarıyla katılım gerçekleşti.'

                    ],400);
                }
                else{
                    return response()->json([
                        'error' => true,
                        'message' => 'Canlı yayına katılırken bir hata meydana geldi.',
                       // 'errorMessage' => 'return code: '.$data_join['returncode'].' message key: '.$data_join['messageKey'].' message: '.$data_join['message']
                    ],400);
                }
            }
            else{
                return response()->json([
                    'error' => true,
                    'message' => 'Canlı yayın başlatılırken bir hata meydana geldi.',
                    'errorMessage' => 'return code: '.$data['returncode'].' message key: '.$data['messageKey'].' message: '.$data['message']
                ],400);
            }
        }
        return response()->json([
            'error' => true,
            'errorMessage', $resp->getError(),
            'message' => 'Canlı yayın başlatılırken bir hata meydana geldi.Tekrar deneyin.'
        ],400);
    }

    public function joinLive($course_id,$user_id){
        $repo = new LiveRepository();

        $resp=$repo->joinLive($user_id,$course_id);
        if($resp->getResult()){
            $data = $resp->getData();
            if($data!= null){
                return response()->json([
                    'error' => false,
                    'data' => $data,
                    'message' => 'Canlı yayına başarıyla katılım gerçekleşti.'

                ],400);
            }
            else{
                return response()->json([
                    'error' => true,
                    'message' => 'Canlı yayına katılırken bir hata meydana geldi.',
                ],400);
            }
        }
        return response()->json([
            'error' => true,
            'errorMessage', $resp->getError(),
            'message' => 'Canlı yayına giriş yapılırken bir hata meydana geldi.Tekrar deneyin.'
        ],400);
    }
}
