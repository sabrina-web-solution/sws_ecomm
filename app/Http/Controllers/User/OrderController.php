<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

use Auth;
use Session;
use Cookie;

use App\Models\User\Cart;
use App\Models\User\LikedProduct;
use App\Models\User\WishlistProduct;
use App\Models\User\OrderDetail;

class OrderController extends Controller
{
    protected $system_id;
    protected $user_id;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->system_id = getSystemId();
            $this->user_id = $this->guest_id = null;
            
            if(Auth::id()){
                $this->user_id = Auth::id();
                Cookie::queue(Cookie::forget('sws_guest_id'));
            } else {

            }
            return $next($request);
        });
    }

    public function getOrderDetails(Request $request){
        try {
            $order_details = [];
            $URL         =  getApiUrl() . 'getOrderDetails?data='.json_encode(['user_id'=>$this->user_id]);
            
            $client1     = new Client;
            $result1     = $client1->get($URL);
            
            if($result1->getStatusCode()==200){

                $data = json_decode($result1->getBody()->getContents());
                foreach ($result->data as $key => $data1) {
                     $order_details[] = $data1->details;
                }
            }
            return view('website.order',compact('order_details'));
        } catch (Exception $e) {
            return response()->json(['status'=>400,'message'=>$e->getMessaage()]);
        }
    }

    public function addOrder(Request $request){
        try {
            $URL         =  getApiUrl() . 'addOrder?data='.json_encode(['user_id'=>$this->user_id,'cart_ids'=>$request->cart_ids]);
            
            $client1     = new Client;
            $result1     = $client1->post($URL);

            if($result1->getStatusCode()==200){
                $data = json_decode($result1->getBody()->getContents());
                redirect('order')->with(['status'=>$data->status,'message'=>$data->message]);
            }
        } catch (Exception $e) {
            return response()->json(['status'=>400,'message'=>$e->getMessaage()]);
        }
    }

    public function cancelOrder(Request $request){
        try {
             if(!empty($request->order_id)){
                $URL         =  getApiUrl() . 'cancelOrder?data='.json_encode(['user_id'=>$this->user_id,'cart_ids'=>decrypt($request->order_id)]);
            
                $client1     = new Client;
                $result1     = $client1->post($URL);

                if($result1->getStatusCode()==200){
                    $data = json_decode($result1->getBody()->getContents());
                    redirect('order')->with(['status'=>$data->status,'message'=>$data->message]);
                }
             }
        } catch (Exception $e) {
            return response()->json(['status'=>400,'message'=>$e->getMessaage()]);
        }
    }
}
