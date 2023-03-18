<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Merchant;
use App\Models\Order;
use App\Services\MerchantService;
use App\Services\AffiliateService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\WithFaker;

class MerchantController extends Controller
{
    use  WithFaker;
    public function __construct(
        MerchantService $merchantService,AffiliateService $affiliateService
    ) {

        $this->MerchantService = $merchantService;
        $this->AffiliateService = $affiliateService;
    }

    /**
     * Useful order statistics for the merchant API.
     * 
     * @param Request $request Will include a from and to date
     * @return JsonResponse Should be in the form {count: total number of orders in range, commission_owed: amount of unpaid commissions for orders with an affiliate, revenue: sum order subtotals}
     */
    public function orderStats(Request $request): JsonResponse
    {
        $fromDate = $request->input('from');
        $toDate = $request->input('to');
        
        $ordersQuery = DB::table('orders')->whereBetween('created_at', [$fromDate, $toDate]);
        
        $orderCount = $ordersQuery->count();
        // dd($orderCount);
        // dd($toDate);
        $revenue = $ordersQuery->sum('subtotal');
        $commissionOwed = $ordersQuery->whereNotNull('affiliate_id')->where('payout_status', Order::STATUS_UNPAID)->sum('commission_owed');
        return response()->json([
            'count' => $orderCount,
            'commissions_owed' => $commissionOwed,
            'revenue' => $revenue,
        ]);
        // TODO: Complete this method
    }
    public function register(Request $request): JsonResponse
    {
        // $myArray =[
        //     'domain' => 'ghnnvj',
        //     'name' => 'jgjgjkhhjgjj',
        //     'email' => 'hjgjgkjhkkvgkknhkkkj@gmail.com',
        //     'api_key' => 'jhfjcfj76mmm5775jjhjgjgj'
        // ];
        //dd($myArray);
        $merchant = new Merchant;
$merchant->user_id = 53;
$merchant->domain = 'examplfrfee.ertcofgdfgm';
$merchant->display_name = 'Examplerfe Merchant';
$merchant->turn_customers_into_affiliates = true;
$merchant->default_commission_rate = 0.1;
$merchant->save();
        // $data = $request->toarray();
        // $userData = User::where('email', $data['email'])->get();
         $this->AffiliateService->register($merchant, $merchant->domain, 'dfkslfsdlf', 0.1);
        ///dd($userData);
       // $result=$this->MerchantService->updateMerchant( $userData,  $data);
        //dd($order);
        // Return a response
        return response()->json([
            'message' => ' processed successfully',
        ]);
    }
}
