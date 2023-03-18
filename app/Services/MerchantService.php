<?php

namespace App\Services;

use App\Jobs\PayoutOrderJob;
use App\Models\Affiliate;
use App\Models\Merchant;
use App\Models\Order;
use App\Models\User;
use App\Jobs\ProcessOrderPayout;
class MerchantService
{
    /**
     * Register a new user and associated merchant.
     * Hint: Use the password field to store the API key.
     * Hint: Be sure to set the correct user type according to the constants in the User model.
     *
     * @param array{domain: string, name: string, email: string, api_key: string} $data
     * @return Merchant
     */
    function register(array $data): Merchant
    {
        //dd($data);
        $userData = User::where('email', $data['email'])->first();
        $merchant = Merchant::where('domain', $data['name'])->first();
        if ($merchant) {
            throw new Exception('Merchant exist already');
        }
        $merchant = new Merchant([
            'user_id' => '53',
            'domain' => $data['domain'],
            'display_name' => $data['name'] // Use the merchant name as the display name by default
        ]);
        $merchant->save();
        $user = User::where('email', $data['email'])->first();
        if ($user) {
            // Ignore duplicate orders
            return false;
        }
        else{
            $userData = [
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['api_key'], // Store the API key as the password
                'type' => 'merchant' // Set the user type to merchant
            ];

            $user = User::create($userData);
    }

       

        return $merchant;
    }

    /**
     * Update the user
     *
     * @param array{domain: string, name: string, email: string, api_key: string} $data
     * @return void
     */
    public function updateMerchant(User $user, array $data)
    {
        // TODO: Complete this method
        $merchant = $user->merchant;

    if (!$merchant) {
        // handle the case when the user doesn't have a related merchant
        // maybe create a new merchant record and associate it with the user
        return;
    }

    $merchant->domain = $data['domain'] ?? $merchant->domain;
    $merchant->display_name = $data['name'] ?? $merchant->display_name;
    $merchant->turn_customers_into_affiliates = $data['turn_customers_into_affiliates'] ?? $merchant->turn_customers_into_affiliates;
    $merchant->default_commission_rate = $data['default_commission_rate'] ?? $merchant->default_commission_rate;

    $merchant->save();
    }

    /**
     * Find a merchant by their email.
     * Hint: You'll need to look up the user first.
     *
     * @param string $email
     * @return Merchant|null
     */
    public function findMerchantByEmail(string $email): ?Merchant
    {
        // TODO: Complete this method
        $user = User::where('email', $email)->first();
        
        if ($user) {
            return $user->merchant;
        }
        
        return null;
    }

    /**
     * Pay out all of an affiliate's orders.
     * Hint: You'll need to dispatch the job for each unpaid order.
     *
     * @param Affiliate $affiliate
     * @return void
     */
    public function payout(Affiliate $affiliate)
    {
      // Get all unpaid orders for the affiliate
    $unpaidOrders = Order::where('affiliate_id', $affiliate->id)
    ->where('payout_status', Order::STATUS_UNPAID)
    ->get();

// Loop through each unpaid order and dispatch a job to pay the commission
foreach ($unpaidOrders as $order) {
    PayoutOrderJob::dispatch($order);
}
    }
}
