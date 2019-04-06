<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EcommController extends Controller
{
    public function getVenueMerchantDetails(Request $request){
        try {
            $merchant_id 	= ($request->merchant_id)?(decrypt($request->merchant_id)):null;
        	$venue_id 		= ($request->venue_id)?(decrypt($request->venue_id)):null;

            $result = json_decode(getDetails(null,"getVenueMerchantDetails",['venue_id'=>$venue_id,'merchant_id'=>$merchant_id]));
            if($result->status==200){
                return response()->json(['status'=>200, 'data'=>$result->data,'message'=>$result->message]);
            } else {
                return response()->json(['status'=>400, 'message'=>$result->message]); 
            }
        } catch (Exception $e) {
            return response()->json(['status'=>400, 'message'=>$result->message]);
        }
    }

    public function getProductDetails(Request $request){
    	try {
            $merchant_id 	= ($request->merchant_id)?(decrypt($request->merchant_id)):null;
        	$venue_id 		= ($request->venue_id)?(decrypt($request->venue_id)):null;
        	$product_id 	= ($request->product_id)?(decrypt($request->product_id)):null;
        	$modifier_id 	= ($request->modifier_id)?(decrypt($request->modifier_id)):null;
        	$offer_id 		= ($request->offer_id)?(decrypt($request->offer_id)):null;

            $result = json_decode(getDetails(null,"getProductDetails",['venue_id'=>$venue_id,'merchant_id'=>$merchant_id, 'product_id'=>$product_id, 'modifier_id'=>$modifier_id, 'offer_id'=>$offer_id]));
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

            $result = json_decode(getDetails(null,"getPrice",['venue_id'=>$venue_id,'merchant_id'=>$merchant_id, 'product_id'=>$product_id, 'modifier_id'=>$modifier_id, 'offer_id'=>$offer_id]));
            if($result->status==200){
                return response()->json(['status'=>200, 'data'=>$result->data,'message'=>$result->message]);
            } else {
                return response()->json(['status'=>400, 'message'=>$result->message]); 
            }
        } catch (Exception $e) {
            return response()->json(['status'=>400, 'message'=>$e->getMessage()]);
        }
    }
}
