<?php


namespace App\Payment;
use App\Models\UsersOperations\Basket;
use Iyzipay\Model\CheckoutFormInitialize;
use Iyzipay\Model\SubMerchant;
use Iyzipay\Model\SubMerchantType;
use Iyzipay\Model\Currency;
use Iyzipay\Model\Locale;
use Iyzipay\Options;
use Iyzipay\Request\CreateSubMerchantRequest;
use Iyzipay\Request\UpdateSubMerchantRequest;
use Iyzipay\Request\CreateCheckoutFormInitializeRequest;
use Iyzipay\Request\RetrieveCheckoutFormRequest;
use Iyzipay\Model\Buyer;
use Iyzipay\Model\Address;
use Iyzipay\Model\BasketItem;
use Iyzipay\Model\BasketItemType;
use Iyzipay\Model\PaymentGroup;
use Iyzipay\Model\CheckoutForm;
use App\Models\Auth\Instructor;


class Payment
{
    // alt üye iş yeri kayıt oluşturma metodu-satıcı oluşturma
    public function createSubMerchant(Instructor $instructor){
        $options = new Options();
        $options->setApiKey('sandbox-zKK3HgzvDkPILo9D7PesKOixCuBg9Rpj');
        $options->setSecretKey('sandbox-AuVhbC9hstaRNtlSb1xEn9bwwsgecdHP');
        $options->setBaseUrl('https://sandbox-api.iyzipay.com');

        $request = new CreateSubMerchantRequest();
        $request->setLocale(Locale::TR);
        $request->setConversationId($instructor->id);
        $request->setSubMerchantExternalId($instructor->id);
        $request->setSubMerchantType(SubMerchantType::PERSONAL);
        $request->setAddress("Türkiye");
        $request->setContactName($instructor->user->first_name);
        $request->setContactSurname($instructor->user->last_name);
        $request->setEmail($instructor->user->email);
        $request->setGsmNumber($instructor->user->phone_number);
        $request->setName($instructor->user->first_name.' '.$instructor->user->last_name);
        $request->setIban($instructor->iban);
        $request->setIdentityNumber($instructor->identification_number);
        $request->setCurrency(Currency::TL);

        $subMerchant = SubMerchant::create($request, $options);
        return $subMerchant;
    }

    // satıcı güncelleme
    public function updateSubMerchant(Instructor $instructor){
        $options = new Options();
        $options->setApiKey('sandbox-zKK3HgzvDkPILo9D7PesKOixCuBg9Rpj');
        $options->setSecretKey('sandbox-AuVhbC9hstaRNtlSb1xEn9bwwsgecdHP');
        $options->setBaseUrl('https://sandbox-api.iyzipay.com');

        $request = new UpdateSubMerchantRequest();
        $request->setLocale(Locale::TR);
        $request->setConversationId($instructor->id);
        $request->setSubMerchantKey($instructor->sub_merchant_key);
        $request->setIban($instructor->iban);
        $request->setAddress("Türkiye");
        $request->setContactName($instructor->first_name);
        $request->setContactSurname($instructor->last_name);
        $request->setEmail($instructor->email);
        $request->setGsmNumber($instructor->phone_number);
        $request->setName($instructor->first_name.' '.$instructor->last_name);
        $request->setIdentityNumber($instructor->identification_number);
        $request->setCurrency(Currency::TL);

        $subMerchant = SubMerchant::update($request, $options);
        return $subMerchant;
    }

    // checkout metodu ödemeden önceki detay sayfasını verir. Fatura bilgileri yazıldıktan sonra ödeme yap dedikten sonra check out metodu çağıralacak.
    // dönen veri-> https://dev.iyzipay.com/tr/odeme-formu/odeme-formu-baslatma
    public function checkOut($user_id, $first_name, $last_name, $phone_number, $email, $identity_number, $ip, $city, $zip_code, $country, $address, $courses, $is_discount, $basket_id){
        $options = new Options();
        $options->setApiKey('sandbox-zKK3HgzvDkPILo9D7PesKOixCuBg9Rpj');
        $options->setSecretKey('sandbox-AuVhbC9hstaRNtlSb1xEn9bwwsgecdHP');
        $options->setBaseUrl('https://sandbox-api.iyzipay.com');

        $basketItems = array();
        $total_price = 0.0;
        foreach ($courses as $course){
            $basketItem = new BasketItem();
            $type = '';
            if(get_class($course) == 'App\Models\GeneralEducation\Course'){
                $type = 'ge-';
            }
            else if(get_class($course) == 'App\Models\PrepareLessons\Course'){
                $type = 'pl-';
            }
            else if(get_class($course) == 'App\Models\PrepareExams\Course'){
                $type = 'pe-';
            }
            $basketItem->setId($type.strval($course->id));
            $basketItem->setName($course->name);
            $basketItem->setCategory1("Bipayco");
            $basketItem->setItemType(BasketItemType::VIRTUAL);
            if($is_discount == "true"){
                $basketItem->setPrice(round(0.75 * $course->price_with_discount, 2));
            }
            else{
                $basketItem->setPrice(round($course->price_with_discount, 2));
            }
            //$instructor = $course->instructors()->where('is_manager', true)->first();
            //$basketItem->setSubMerchantKey($instructor->sub_merchant_key);
            //$basketItem->setSubMerchantPrice(($basketItem->getPrice() - 0.18 * $basketItem->getPrice()) * 0.40);
            $total_price += $basketItem->getPrice();
            array_push($basketItems, $basketItem);
        }

        $request = new CreateCheckoutFormInitializeRequest();
        $request->setLocale(Locale::TR);
        $request->setConversationId($basket_id);
        $request->setBasketId($basket_id);
        $request->setPrice($total_price);
        $request->setPaidPrice($total_price);
        $request->setCurrency(Currency::TL);
        $request->setPaymentGroup(PaymentGroup::PRODUCT);
        $request->setCallbackUrl("https://www.bipayco.com/paymentResult");
        $request->setEnabledInstallments(array(2, 3, 6, 9));

        $buyer = new Buyer();
        $buyer->setId($user_id);
        $buyer->setName($first_name);
        $buyer->setSurname($last_name);
        $buyer->setGsmNumber($phone_number);
        $buyer->setEmail($email);
        $buyer->setIdentityNumber($identity_number);
        $buyer->setRegistrationAddress($city.'/'.$country);
        $buyer->setIp($ip);
        $buyer->setCity($city);
        $buyer->setCountry($country);
        $buyer->setZipCode($zip_code);
        $request->setBuyer($buyer);

        $shippingAddress = new Address();
        $shippingAddress->setContactName($first_name.' '.$last_name);
        $shippingAddress->setCity($city);
        $shippingAddress->setCountry($country);
        $shippingAddress->setAddress($address);
        $shippingAddress->setZipCode($zip_code);
        $request->setShippingAddress($shippingAddress);

        $billingAddress = new Address();
        $billingAddress->setContactName($first_name.' '.$last_name);
        $billingAddress->setCity($city);
        $billingAddress->setCountry($country);
        $billingAddress->setAddress($address);
        $billingAddress->setZipCode($zip_code);
        $request->setBillingAddress($billingAddress);

        $request->setBasketItems($basketItems);

        $checkoutFormInitialize = CheckoutFormInitialize::create($request, $options);
        return $checkoutFormInitialize;
    }

    public function result($conversation_id, $token){
        $options = new Options();
        $options->setApiKey('sandbox-zKK3HgzvDkPILo9D7PesKOixCuBg9Rpj');
        $options->setSecretKey('sandbox-AuVhbC9hstaRNtlSb1xEn9bwwsgecdHP');
        $options->setBaseUrl('https://sandbox-api.iyzipay.com');

        $request = new RetrieveCheckoutFormRequest();
        $request->setLocale(Locale::TR);
        $request->setConversationId($conversation_id);
        $request->setToken($token);

        $result = CheckoutForm::retrieve($request, $options);
        return $result;
    }

}
