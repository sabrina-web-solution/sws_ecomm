<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Auth;
use Session;
use Cookie;

use App\Models\User\Cart;
use App\Models\User\LikedProduct;
use App\Models\User\WishlistProduct;

class CartController extends Controller
{
    protected $system_id;
    protected $user_id;
    protected $guest_id;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->system_id = getSystemId();
            $this->user_id = $this->guest_id = null;
            
            if(Auth::id()){
                $this->user_id = Auth::id();
                Cookie::queue(Cookie::forget('sws_guest_id'));
            } else {
                if(!isset($_COOKIE['sws_guest_id'])){
                    $this->guest_id = Session::getId();
                    setcookie('sws_guest_id', $this->guest_id, time() + 86400 * 30,"/");
                } else {
                    $this->guest_id = $_COOKIE['sws_guest_id'];
                }
            }
            return $next($request);
        });
    }

    public function getCartDetails(Request $request)
    {
        $cartdata = $cart_details = $likes_details = $wish_details = [];
        $carts   =      Cart::where('system_id',$this->system_id)->where('user_id',$this->user_id)->where('guest_id',$this->guest_id)->get();
        if(!empty($carts) && count($carts)){
            foreach ($carts as $key => $cart) {
                $cartdata[]   =     [
                                        'type'          =>    'Cart',
                                        'merchant_id'   =>    $cart->merchant_id,
                                        'venue_id'      =>    $cart->venue_id,
                                        'product_id'    =>    $cart->product_id,
                                        'modifier_id'   =>    $cart->modifier_id,
                                        'offer_id'      =>    $cart->offer_id,
                                        'price'         =>    $cart->costperpc
                                    ];
                }
        }
        $wishes = WishlistProduct::where('system_id',$this->system_id)->where('user_id',$this->user_id)->where('guest_id',$this->guest_id)->get();
        if(!empty($wishes) && count($wishes)){
            foreach ($wishes as $key => $cart) {
                $cartdata[]   =     [
                                        'type'          =>    'Wish',
                                        'merchant_id'   =>    $cart->merchant_id,
                                        'venue_id'      =>    $cart->venue_id,
                                        'product_id'    =>    $cart->product_id,
                                        'modifier_id'   =>    $cart->modifier_id,
                                        'offer_id'      =>    $cart->offer_id,
                                        'price'         =>    $cart->costperpc
                                    ];
                }
        }
        $likes = LikedProduct::where('system_id',$this->system_id)->where('user_id',$this->user_id)->where('guest_id',$this->guest_id)->get();
        if(!empty($likes) && count($likes)){
            foreach ($likes as $key => $cart) {
                $cartdata[]   =     [
                                        'type'          =>    'Likes',
                                        'merchant_id'   =>    $cart->merchant_id,
                                        'venue_id'      =>    $cart->venue_id,
                                        'product_id'    =>    $cart->product_id,
                                        'modifier_id'   =>    $cart->modifier_id,
                                        'offer_id'      =>    $cart->offer_id,
                                        'price'         =>    $cart->costperpc
                                    ];
                }
        }
        
        $result = json_decode(getDetails("getProductDetails",$cartdata));
        foreach ($result->data as $key => $data1) {
            if($data1->received_details->type=='Cart'){ $cart_details[] = $data1->details; }
            else if($data1->received_details->type=='Wish'){ $wish_details[] = $data1->details; }
            else { $likes_details[] = $data1->details; }
        }
        return view('website.cart',compact('cart_details','wish_details','likes_details'));
    }

    public function addCart(Request $request){
        try {
                $cart   =   Cart::where('system_id',$this->system_id)
                                ->where('user_id' , $this->user_id)
                                ->where('guest_id' , $guest_id)
                                ->where('product_id' , $request->product_id)
                                ->where('venue_id'  , $request->venue_id)
                                ->where('merchant_id', $request->merchant_id)
                                ->where('modifier_id', $request->modifier_id)
                                ->where('offer_id',$request->offer_id)
                                ->first();
                $wishes =   WishlistProduct::where('system_id',$this->system_id)
                                ->where('user_id' , $this->user_id)
                                ->where('guest_id' , $guest_id)
                                ->where('product_id' , $request->product_id)
                                ->where('venue_id'  , $request->venue_id)
                                ->where('merchant_id', $request->merchant_id)
                                ->where('modifier_id', $request->modifier_id)
                                ->first();              
                if($cart){
                    $cart['quantity']  += $request->quantity;
                    $cart->save();
                    $message = "Item is updated in cart";
                } else {
                        $cart = new Cart;
                        $cart = [
                            'system_id'   => $this->system_id,
                            'user_id'       => $request->user_id,
                            'guest_id'         => $request->guest_id,
                            'product_id'    => $request->product_id,
                            'venue_id'      => $request->venue_id,
                            'merchant_id'   => $request->merchant_id,
                            'modifier_id'   => $request->modifier_id,
                            'offer_id'      => $request->offer_id,
                            'quantity'      => $request->quantity,
                            'costperpc'     => $request->price
                       ];
                       $cart->save();
                       if($wishes){ $wishes->destroy();}
                       $message = "Item is added to cart";
                }
                return response()->json(['status'=>200,'message'=>$message,'cart'=>$cart]);
        } catch (Exception $e) {
            return response()->json(['status'=>400,'message'=>$e->getMessaage()]);
        }
    }

    public function addWishlist(Request $request){
        try {
                $wishlists = WishlistProduct::where('system_id',$this->system_id)
                                        ->where('user_id' , $this->user_id)
                                        ->where('guest_id' , $guest_id)
                                        ->where('product_id' , $request->product_id)
                                        ->where('venue_id'  , $request->venue_id)
                                        ->where('merchant_id', $request->merchant_id)
                                        ->where('modifier_id', $request->modifier_id)
                                        ->first();
                if($wishlists){
                    $wishlists->delete($wishlists->id);
                    $message = "Item is removed from wishlists";
                    return response()->json(['status'=>200,'message'=>$message, 'flag'=>1]);
                } else {
                        $wishlists = new WishlistProduct;
                        $wishlists = [
                            'system_id'   => $this->system_id,
                            'user_id'       => $request->user_id,
                            'guest_id'         => $request->guest_id,
                            'product_id'    => $request->product_id,
                            'venue_id'      => $request->venue_id,
                            'merchant_id'   => $request->merchant_id,
                            'modifier_id'   => $request->modifier_id,
                            'costperpc'     => $request->price
                       ];
                       $wishlists->save();
                       $message = "Item is added to wishlists";
                    return response()->json(['status'=>200,'message'=>$message, 'flag'=>0]);
            }
        } catch (Exception $e) {
            return response()->json(['status'=>200,'message'=>$e->getMessaage()]);
        }
    }

    public function addLikedProduct(Request $request){
        try {
                $likes =    LikedProduct::where('system_id',$this->system_id)
                                        ->where('user_id' , $this->user_id)
                                        ->where('guest_id' , $guest_id)
                                        ->where('product_id' , $request->product_id)
                                        ->where('venue_id'  , $request->venue_id)
                                        ->where('merchant_id', $request->merchant_id)
                                        ->where('modifier_id', $request->modifier_id)
                                        ->first();
                if($likes){
                    $likes->delete($likes->id);
                    $message = "Item is removed from likes";
                    return response()->json(['status'=>200,'message'=>$message, 'flag'=>1]);
                } else {
                        $likes = new LikedProduct;
                        $likes = [
                            'system_id'   => $this->system_id,
                            'user_id'       => $request->user_id,
                            'guest_id'         => $request->guest_id,
                            'product_id'    => $request->product_id,
                            'venue_id'      => $request->venue_id,
                            'merchant_id'   => $request->merchant_id,
                            'modifier_id'   => $request->modifier_id,
                            'costperpc'     => $request->price
                       ];
                       $likes->save();
                       $message = "Item is added to likes";
                    return response()->json(['status'=>200,'message'=>$message, 'flag'=>0]);
            }
        } catch (Exception $e) {
            return response()->json(['status'=>200,'message'=>$e->getMessaage()]);
        }
    }
    
}
