<?php

namespace App\Http\Controllers;

use Stripe\Stripe;
use Stripe\Checkout\Session;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Payment;

class PaymentController extends Controller
{
    public function buyCourse(Request $request){
        $course = Course::findOrFail($request->course_id);

        // 1. Create order
        $order = Payment::create([
            'user_id' => auth()->id(),
            'course_id' => $course->id,
            'status' => 'pending',
        ]);

        // 2. Stripe init
        Stripe::setApiKey(env('STRIPE_SECRET'));

        // 3. Create checkout session
        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => $course->title,
                    ],
                    'unit_amount' => 100,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => env('APP_URL') . '/payment-success',
            'cancel_url' => env('APP_URL') . '/payment-cancel',
        ]);

        // 4. Save session id
        $order->update([
            'stripe_session_id' => $session->id
        ]);

        return response()->json([
            'url' => $session->url
        ]);
    }

    public function webhook(Request $request){
        $event = $request->all();

        if ($event['type'] === 'checkout.session.completed') {

            $session = $event['data']['object'];

            $payment = Payment::where('stripe_session_id', $session['id'])->first();

            if($payment){
                $payment->update([
                    'status' => 'paid'
                ]);

                // 👉 εδώ δίνεις πρόσβαση στο course
                // π.χ. enroll user logic
            }
        }

        return response()->json(['status' => 'ok']);
    }
}
