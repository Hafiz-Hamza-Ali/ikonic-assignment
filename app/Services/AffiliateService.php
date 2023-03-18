<?php

namespace App\Services;

use App\Exceptions\AffiliateCreateException;
use App\Mail\AffiliateCreated;
use App\Models\Affiliate;
use App\Models\Merchant;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AffiliateService
{
    public function __construct(
        protected ApiService $apiService
    ) {
          $this->ApiService = $apiService;
    }
 

 /**
     * Create a new affiliate for the merchant with the given commission rate.
     *
     * @param  Merchant $merchant
     * @param  string $email
     * @param  string $name
     * @param  float $commissionRate
     * @return Affiliate
     */
    public function register(Merchant $merchant, string $email, string $name, float $commissionRate): Affiliate
    {
        try {
            $user = User::where('email', $email)->first();

            if ($user) {
                throw new AffiliateCreateException("User with email {$email} already exists");
            }
        $discountCode=$this->ApiService->createDiscountCode();
        // create the user for the affiliate
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt(Str::random(10)), // generate a random password
            'type' => User::TYPE_AFFILIATE,
        ]);

        // create the affiliate for the merchant
        $affiliate = Affiliate::create([
            'user_id' => $user->id,
            'merchant_id' => $merchant->id,
            'commission_rate' => $commissionRate,
            'discount_code' =>  $discountCode['code'], // generate a random discount code
        ]);
        Mail::to($affiliate->user->email)->send(new AffiliateCreated($affiliate));
        return $affiliate;
         } catch (QueryException $e) {
            if ($e->getCode() === '23000') {
                throw new AffiliateCreateException("Failed to create affiliate with email {$email}: email already exists");
            } else {
                throw $e;
            }
        }
    }
   
}
