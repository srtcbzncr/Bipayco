<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Auth\Instructor;
use App\Payment\Payment;

class RegisterSubMerchant extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'submerchant:register';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Register instructors who has not a sub_merchant_key to Iyzico as a sub merchant';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $instructors = Instructor::all();
        $payment = new Payment();
        $count = 0;

        foreach($instructors as $instructor){
            if($instructor->sub_merchant_key == null){
                $result = $payment->createSubMerchant($instructor);
                if($result->getStatus() == 'success'){
                    $instructor->sub_merchant_key = $result->getSubMerchantKey();
                    $instructor->save();
                    $count += 1;
                }
            }
        }
        $this->info('Eklenen satıcı sayısı:');
        $this->info(strval($count));
    }
}
