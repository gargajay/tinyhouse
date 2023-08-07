<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;
Use App\Models\User;
use Stripe;
use Session;
use Exception;
use Illuminate\Support\Facades\DB;

class SubscriptionController extends Controller
{
    public function index(Request $request)
    {
        $data['car'] = Car::find($request->car_id);
        $data['intent'] = auth()->user()->createSetupIntent();

        return view('subscription.create',$data);
    }

    public function orderPost(Request $request)
    {
       // dd($request->all());
            $user = auth()->user();
            $input = $request->all();
            $token =  $request->stripeToken;
            $plan = $request->plan;
            $paymentMethod = $request->paymentMethod;
            try {

                DB::beginTransaction();
                $car = Car::find($request->car_id);
                Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

                if (is_null($user->stripe_id)) {
                    $stripeCustomer = $user->createAsStripeCustomer();
                }
            
               $sub =  $user->newSubscription($request->car_id, config("services.stripe.plans.$plan"))->create($request->token);

               if($sub)
               {
                $currentDate = now();

                // Add 30 days to the current date
                $newDate = $currentDate->addDays(30);

                // Format the new date as 'Y-m-d' (Year-Month-Day)
                $newDateString = $newDate->format('Y-m-d');

                $car->expiry_date = $newDateString;

                $car->save();
               }
              DB::commit();
                return back()->with('success','Subscription is completed.');
            } catch (Exception $e) {
                DB::rollBack();
                return back()->with('success',$e->getMessage());
            }
            
    }
}
