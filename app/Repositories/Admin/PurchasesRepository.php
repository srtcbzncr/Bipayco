<?php


namespace App\Repositories\Admin;


use App\Models\Auth\Admin;
use App\Models\Auth\User;
use App\Models\GeneralEducation\Purchase;
use App\Models\Iyzico\Basket;
use App\Models\Iyzico\BasketItems;
use App\Payment\Payment;
use App\Repositories\IRepository;
use App\Repositories\RepositoryResponse;
use Illuminate\Support\Facades\DB;

class PurchasesRepository implements IRepository
{

    public function all()
    {
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{

        }
        catch(\Exception $e){
            $error = $e->getMessage();
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function get($id)
    {
        // TODO: Implement get() method.
    }

    public function create(array $data)
    {
        // TODO: Implement create() method.
    }

    public function update($id, array $data)
    {
        // TODO: Implement update() method.
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

    public function getPurchases($user_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $admin = Admin::where('user_id',$user_id)->where('active',true)->where('deleted_at',null)->first();
            if($admin!=null){
                //  sepet sepet satın alımları göster
                $object = Basket::where('deleted_at',null)->paginate(10);
                foreach ($object as $basketKey => $basket){
                    $basket_item = BasketItems::where('iyzico_basket_id',$basket->id)->where('deleted_at',null)->first();
                    $purchase = Purchase::find($basket_item->purchase_id);
                    $user = User::find($purchase->user_id);
                    $object[$basketKey]['user'] = $user;
                }
            }
            else{
                $result = false;
                $error = "Kimlik doğrulama hatası.";
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

    public function getPurchaseDetail($payment_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $payment = new Payment();
            $object=json_decode($payment->detail($payment_id)->getRawResult());
        }
        catch(\Exception $e){
            $error = $e->getMessage();
            $result = false;
        }

        // Response
        $resp = new RepositoryResponse($result, $object, $error);
        return $resp;
    }

    public function getPurchasesAsDate($user_id){
        // Response variables
        $result = true;
        $error = null;
        $object = null;

        // Operations
        try{
            $admin = Admin::where('user_id',$user_id)->where('active',true)->where('deleted_at',null)->first();
            if($admin!=null){
                // purchase tablosundan aylık,yıllık,toplam olarak veri gönder
                $total_purchase = 0;
                $purchases = Purchase::where('deleted_at',null)->where('confirmation',true)->get();
                foreach ($purchases as $item){
                    $total_purchase+=$item->price;
                }

                // aylık kazanç
                $total_month_purchase = 0;
                $purchases = Purchase::where('deleted_at',null)->where('confirmation',true)->whereDate('created_at', '>', \Carbon\Carbon::now()->subMonth())->get();
                foreach ($purchases as $item){
                    $total_month_purchase+=$item->price;
                }

                // yıllık kazanç
                $total_year_purchase = 0;
                $purchases = Purchase::where('deleted_at',null)->where('confirmation',true)->whereDate('created_at', '>', \Carbon\Carbon::now()->subYear())->get();
                foreach ($purchases as $item){
                    $total_year_purchase+=$item->price;
                }

                $object['total_purchase'] = $total_purchase;
                $object['total_month_purchase'] = $total_month_purchase;
                $object['total_year_purchase'] = $total_year_purchase;
            }
            else{
                $result = false;
                $error = "Kimlik doğrulama hatası.";
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
}
