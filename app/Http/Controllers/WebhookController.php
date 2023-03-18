<?php

namespace App\Http\Controllers;

use App\Services\AffiliateService;
use App\Services\OrderService;
use App\Services\ApiService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WebhookController extends Controller
{
    public function __construct(
        protected OrderService $orderService,protected ApiService $apiService
    ) {

        $this->OrderService = $orderService;
        $this->ApiService = $apiService;
    }

    /**
     * Pass the necessary data to the process order method
     * 
     * @param  Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        // TODO: Complete this method
        $myArray = $request->all();
        $order=$this->OrderService->processOrder($myArray);
        
        // Return a response
        return response()->json([
            'message' => 'Order processed successfully',
            'order' => $order
        ]);
    }
    public function webhook(Request $request){
        $data=$this->ApiService->sendPayout('zachery19@example.net',3.14);
        //dd($data);
        return $data;

    }
}
