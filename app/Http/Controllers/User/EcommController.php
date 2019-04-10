<?php

namespace App\Http\Controllers\User;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

use Auth;
use Session;
use Cookie;

class EcommController extends Controller
{
    protected $system_id;
    
    public function __construct(){
        $this->middleware(function ($request, $next) {
            $this->system_id = getSystemId();
            $this->user_id = $this->guest_id = null;

            return $next($request);
        });
    }

    public function getProductDetails(Request $request){
        try {
            $merchant_id    = ($request->merchant_id)?(decrypt($request->merchant_id)):null;
            $venue_id       = ($request->venue_id)?(decrypt($request->venue_id)):null;
            $product_id     = ($request->product_id)?(decrypt($request->product_id)):null;
            $modifier_id    = ($request->modifier_id)?(decrypt($request->modifier_id)):null;
            $offer_id       = ($request->offer_id)?(decrypt($request->offer_id)):null;

            $result = json_decode(getDetails("getProductDetails",json_encode(['venue_id'=>$venue_id,'merchant_id'=>$merchant_id, 'product_id'=>$product_id, 'modifier_id'=>$modifier_id, 'offer_id'=>$offer_id])));
            if($result->status==200){
                return response()->json(['status'=>200, 'data'=>$result->data,'message'=>$result->message]);
            } else {
                return response()->json(['status'=>400, 'message'=>$result->message]); 
            }
        } catch (Exception $e) {
            return response()->json(['status'=>400, 'message'=>$e->getMessage()]);
        }
    }

    public function getOfferDetails(Request $request){
        try {
            $merchant_id    = ($request->merchant_id)?(decrypt($request->merchant_id)):null;
            $venue_id       = ($request->venue_id)?(decrypt($request->venue_id)):null;
            $product_id     = ($request->product_id)?(decrypt($request->product_id)):null;
            $modifier_id    = ($request->modifier_id)?(decrypt($request->modifier_id)):null;
            $offer_id       = ($request->offer_id)?(decrypt($request->offer_id)):null;

            $result = json_decode(getDetails(null,"getOfferDetails",['venue_id'=>$venue_id,'merchant_id'=>$merchant_id, 'product_id'=>$product_id, 'modifier_id'=>$modifier_id, 'offer_id'=>$offer_id]));
            if($result->status==200){
                return response()->json(['status'=>200, 'data'=>$result->data,'message'=>$result->message]);
            } else {
                return response()->json(['status'=>400, 'message'=>$result->message]); 
            }
        } catch (Exception $e) {
            return response()->json(['status'=>400, 'message'=>$e->getMessage()]);
        }
    }

    public function getPrice(Request $request){
         try {
            $merchant_id    = ($request->merchant_id)?(decrypt($request->merchant_id)):null;
            $venue_id       = ($request->venue_id)?(decrypt($request->venue_id)):null;
            $product_id     = ($request->product_id)?(decrypt($request->product_id)):null;
            $modifier_id    = ($request->modifier_id)?(decrypt($request->modifier_id)):null;
            $offer_id       = ($request->offer_id)?(decrypt($request->offer_id)):null;

            $result = json_decode(getDetails("getPrice",['venue_id'=>$venue_id,'merchant_id'=>$merchant_id, 'product_id'=>$product_id, 'modifier_id'=>$modifier_id, 'offer_id'=>$offer_id]));
            if($result->status==200){
                return response()->json(['status'=>200, 'data'=>$result->data,'message'=>$result->message]);
            } else {
                return response()->json(['status'=>400, 'message'=>$result->message]); 
            }
        } catch (Exception $e) {
            return response()->json(['status'=>400, 'message'=>$e->getMessage()]);
        }
    }

    public function getAvailableQuantity((Request $request){
        try {
            $merchant_id    = ($request->merchant_id)?(decrypt($request->merchant_id)):null;
            $venue_id       = ($request->venue_id)?(decrypt($request->venue_id)):null;
            $product_id     = ($request->product_id)?(decrypt($request->product_id)):null;
            $modifier_id    = ($request->modifier_id)?(decrypt($request->modifier_id)):null;
            $offer_id       = ($request->offer_id)?(decrypt($request->offer_id)):null;

            $result = json_decode(getDetails("getAvailableQuantity",['venue_id'=>$venue_id,'merchant_id'=>$merchant_id, 'product_id'=>$product_id, 'modifier_id'=>$modifier_id, 'offer_id'=>$offer_id]));
            if($result->status==200){
                return response()->json(['status'=>200, 'data'=>$result->data,'message'=>$result->message]);
            } else {
                return response()->json(['status'=>400, 'message'=>$result->message]); 
            }
        } catch (Exception $e) {
            return response()->json(['status'=>400, 'message'=>$e->getMessage()]);
        }
    }

    public function getVenueMerchantDetails(Request $request){
        try {
            $merchant_id    = ($request->merchant_id)?(decrypt($request->merchant_id)):null;
            $venue_id       = ($request->venue_id)?(decrypt($request->venue_id)):null;

            $URL         =  getApiUrl() . 'getProductDetails?data='.json_encode([['venue_id'=>$venue_id,'merchant_id'=>$merchant_id]);
            
            $client1     = new Client;
            $result1     = $client1->get($URL);
            
            if($result1->getStatusCode()==200){
                $data = json_decode($result1->getBody()->getContents());
                return response()->json(['status'=>200, 'data'=>$data]);
            }
        } catch (Exception $e) {
            return response()->json(['status'=>400, 'message'=>$e->getMessage()]);
        }
    }

}
