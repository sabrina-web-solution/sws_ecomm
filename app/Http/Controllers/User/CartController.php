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
    public function _construct()
    {
        $user_id = $guest = null;
        if(Auth::user()){
            $user_id = Auth::id();
        } else {
            if(!isset($_COOKIE['sws_guest'])){
                $guest = Session::getId();
                setcookie('sws_guest', $guest, time() + (86400*30), "/" );
            } else {
                $guest = $_COOKIE['sws_guest'];
            }
        }
    }

    public function getCartDetails(Request $request)
    {
        $cartdata = $cart_details = $likes_details = $wish_details = [];
        $carts   =      Cart::where('system_type',$system_type)->where('user_id',$user_id)->where('guest',$guest)->get();
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
        $wishes = WishlistProduct::where('system_type',$system_type)->where('user_id',$user_id)->where('guest',$guest)->get();
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
        $likes = LikedProduct::where('system_type',$system_type)->where('user_id',$user_id)->where('guest',$guest)->get();
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
                $cart   =   Cart::where('system_type',$system_type)
                                ->where('user_id' , $user_id)
                                ->where('guest' , $guest)
                                ->where('product_id' , $request->product_id)
                                ->where('venue_id'  , $request->venue_id)
                                ->where('merchant_id', $request->merchant_id)
                                ->where('modifier_id', $request->modifier_id)
                                ->where('offer_id',$request->offer_id)
                                ->first();
                $wishes =   WishlistProduct::where('system_type',$system_type)
                                ->where('user_id' , $user_id)
                                ->where('guest' , $guest)
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
                            'system_type'   => $system_type,
                            'user_id'       => $request->user_id,
                            'guest'         => $request->guest,
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
                return response()->json(['status'=>200,'message'=>$message, 'flag'=>1]);
        } catch (Exception $e) {
            return response()->json(['status'=>200,'message'=>$e->getMessaage()]);
        }
    }

    public function addWishlist(Request $request){
        try {
                $wishlists = WishlistProduct::where('system_type',$system_type)
                                        ->where('user_id' , $user_id)
                                        ->where('guest' , $guest)
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
                            'system_type'   => $system_type,
                            'user_id'       => $request->user_id,
                            'guest'         => $request->guest,
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
                $likes =    LikedProduct::where('system_type',$system_type)
                                        ->where('user_id' , $user_id)
                                        ->where('guest' , $guest)
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
                            'system_type'   => $system_type,
                            'user_id'       => $request->user_id,
                            'guest'         => $request->guest,
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
