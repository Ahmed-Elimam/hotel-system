<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReservationRequest;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Models\Payment;
use App\Models\Reservation;
use Carbon\Carbon;

class PaymentController extends Controller
{
    public function createCheckoutSession(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $checkout_session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => "Book A Room In The Royal Crest"],
                        'unit_amount' => $request->paid_price * 100,
                ],'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('payment.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('payment.cancel'),
        ]);
        Reservation::create([
            'stripe_session_id' => $checkout_session->id,
            'paid_price' => request()->paid_price * 100,
            'status' => 'pending',
            'accompany_number' => $request->accompany_number,
            'check_in'=> Carbon::parse($request->check_in)->format('Y-m-d'),
            'check_out'=> Carbon::parse($request->check_out)->format('Y-m-d'),
            'room_id'=> request()->room_id,
            'room_creator_id'=>  request()-> room_creator_id,
            'client_id' => auth()->id(),
        ]);

        return response()->json([
            'checkout_url' => $checkout_session->url
        ]);
    }

    public function handleSuccess(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $session = Session::retrieve($request->session_id);

   
        $payment = Reservation::where('stripe_session_id', $request->session_id)->first();

   
        if ($session->payment_status === 'paid') {
  
            $payment->update([
                'status' => 'completed',
                'stripe_payment_intent_id' => $session->payment_intent
            ]);
            session()->flash('success', 'Payment is confirmed');
            return redirect()->route('managers.index');  
        }

        $payment->update(['status' => 'failed']);
        session()->flash('error','There was an error during process');
        return redirect()->route('managers.index');    
    }

    public function handleCancel(Request $request)
    {

        $payment = Reservation::where('stripe_session_id', $request->session_id)->first();
               
        if ($payment->status === 'cancelled') {
            $payment->update(['status' => 'cancelled']);
        }

        session()->flash('error', 'Your request was cancelled');
        return redirect()->route('managers.index');  
    }

}