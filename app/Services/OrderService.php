<?php

namespace App\Services;

use App\Models\Affiliate;
use App\Models\Merchant;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Str;
use DB;
class OrderService
{
    public function __construct(
        protected AffiliateService $affiliateService
    ) {}

    /**
     * Process an order and log any commissions.
     * This should create a new affiliate if the customer_email is not already associated with one.
     * This method should also ignore duplicates based on order_id.
     *
     * @param  array{order_id: string, subtotal_price: float, merchant_domain: string, discount_code: string, customer_email: string, customer_name: string} $data
     * @return void
     */
    public function processOrder(array $data)
    {
        $order = Order::where('id', $data['order_id'])->first();
        if ($order) {
            // Order already exists, ignore duplicate
            
            return;
        }
    
        $merchant = Merchant::where('domain', $data['merchant_domain'])->first();
        if (!$merchant) {
            // Merchant not found, cannot process order
            return;
        }
    
        $affiliate = Affiliate::where('discount_code', $data['discount_code'])->first();
        if (!$affiliate) {
            // Create a new affiliate if the customer_email is not already associated with one
            $affiliate = new Affiliate();
            $affiliate->user_id = $merchant->user_id;
            $affiliate->merchant_id = $merchant->id;
            $affiliate->commission_rate = $merchant->default_commission_rate;
            $affiliate->discount_code = $data['discount_code'];
            $affiliate->save();
        }
    
        $order = new Order();
        $order->merchant_id = $merchant->id;
        $order->affiliate_id = $affiliate->id;
        $order->subtotal = $data['subtotal_price'];
        $order->discount_code = $data['discount_code'];
        $order->save();
    
        // Calculate commission owed and update affiliate and order
        $commissionRate = $affiliate->commission_rate;
        $commissionOwed = $order->subtotal * $commissionRate;
        //$affiliate->commission_earned += $commissionOwed;
        $affiliate->save();
        $order->commission_owed = $commissionOwed;
        $order->save();
    }
}
