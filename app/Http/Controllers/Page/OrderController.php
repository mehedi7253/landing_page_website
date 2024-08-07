<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use App\Mail\OrderMail;
use App\Mail\TestMail;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cartData = session()->get('cart');
        return view('frontend.pages.checkout', compact('cartData'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $this->validate($request,[
            'first_name'       =>'required',
            'last_name'        =>'required',
            'email'            =>'required',
            'phone'            =>'required',
            'address'          =>'required',
        ]);
        $order = new Order();
        $order->first_name    = $request->first_name;
        $order->last_name     = $request->last_name;
        $order->email         = $request->email;
        $order->phone         = $request->phone;
        $order->address       = $request->address;
        $order->order_note    = $request->order_note;
        $order->total         = totalPrice();
        $order->status        = 'pending';
        $order->save();

        if($order){

            $cartData = Session::get('cart', []);
            $products = Product::whereIn('id', array_keys($cartData))->get();

            //store data into orderDetails table

            foreach($products as $item)
            {
                $order_details = new OrderDetails();
                $order_details->order_id = $order->id;
                $order_details->product_name = $item->product_name;
                $order_details->quantity = $cartData[$item->id];
                $order_details->price = ($item->discount_price ?? $item->price)* $cartData[$item->id];
                $order_details->save();
                session()->forget('cart');
            }
        }

        $orderDetails = [
            'order_id' => $order->id,
            'orderData' => $request->all(),
            'product' => $order_details,
        ];

        $user = Auth::user();
        Mail::to('mdmehedihasan221@gmail.com')->send(new TestMail($user));

        // $senderEmail = "arshiyatechnology@gmail.com";
        // $email = $request->email;
        // Mail::to($email)->send(new OrderMail($orderDetails, $senderEmail));
        return redirect()->route('cart.index')->with('message', 'Your order has been placed successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
