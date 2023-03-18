<?php

namespace App\Services;

use App\Models\Affiliate;
use App\Models\Merchant;
use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Str;
use RuntimeException;

/**
 * You don't need to do anything here. This is just to help
 */
class ApiService
{
    /**
     * Create a new discount code for an affiliate
     *
     * @param Merchant $merchant
     *
     * @return array{id: int, code: string}
     */
     public function createDiscountCode()
    {
        $discountCode = [
            'id' => -1,
            'code' => \Illuminate\Support\Str::uuid(),
        ];

        return $discountCode;
    }

    /**
     * Send a payout to an email
     *
     * @param  string $email
     * @param  float $amount
     * @return void
     * @throws RuntimeException
     */
    public function sendPayout( $email, $amount)
    {
        //dd($email);
        // Check if the email is associated with a user
        $user = User::where('email', $email)->first();
        if (!$user) {   
            throw new RuntimeException('User not found');
        }
        // Get all orders associated with the user's affiliates
        $orders = Order::whereHas('affiliate', function($q) use ($user) {
            $q->where('user_id', $user->id);
        })->get();
        //dd($orders);
        // Calculate total commission owed
        $totalCommission = 0.0;
        foreach ($orders as $order) {
            $totalCommission += $order->commission_owed;
        }
       // dd($amount);
        // Check if the total commission owed is greater than the requested payout amount
        if ($totalCommission < $amount) {
            throw new RuntimeException('Insufficient commission to payout');
        }
        
        // Update the payout status for each order
        foreach ($orders as $order) {
            
            $order->payout_status = Order::STATUS_PAID;
            $order->save();
            
        }
        
        // TODO: Add code to actually send the payout to the user's email address
        
    }
}
