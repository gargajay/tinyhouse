<?php

namespace App\Http\Controllers;

use App\Library\StripeGateway;
use App\Models\Car;
use Illuminate\Http\Request;
Use App\Models\User;
use Stripe;
use Session;
use Exception;
use Illuminate\Support\Facades\DB;
use Stripe\Plan;

class SubscriptionController extends Controller
{
    public function index(Request $request)
    {
        $data['car'] = Car::find($request->car_id);
        $data['intent'] = auth()->user()->createSetupIntent();

       

    $data['products'] = StripeGateway::getPlans();

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


                if(!empty($request->promo_code))
                {
                    if($request->promo_code=='WELCOMEOFFER'){
                        $userObj = User::find($user->id);
                        if($userObj->is_info==true){
                            return back()->with('error',"You have already used this promocode");

                        }
                        $currentDate = now();
                        $newDate = $currentDate->addDays(30);
                        $newDateString = $newDate->format('Y-m-d');

                        $car->expiry_date = $newDateString;
        
                        $car->save();
                        $userObj->is_info = true;
                        $userObj->save();
                        DB::commit();
                        return back()->with('success','Promo code applied successfully.');


                    }else if($request->promo_code=='THOMES1MONTH')
                    {
                        $userObj = User::find($user->id);
                        if($car->is_payment==1){
                            return back()->with('error',"You have already used this promocode");

                        }
                        $currentDate = now();
                        $newDate = $currentDate->addDays(30);
                        $newDateString = $newDate->format('Y-m-d');

                        $car->expiry_date = $newDateString;
                        $car->is_payment = 1;
                        $car->save();
                        $userObj->is_info = true;
                        $userObj->save();
                        DB::commit();
                        return back()->with('success','Promo code applied successfully.');
                    }
                    else if($request->promo_code=='THOMES2MONTH')
                    {
                        $userObj = User::find($user->id);
                        if($car->is_payment==1){
                            return back()->with('error',"You have already used this promocode");
                        }
                        $currentDate = now();
                        $newDate = $currentDate->addDays(60);
                        $newDateString = $newDate->format('Y-m-d');

                        $car->expiry_date = $newDateString;
        
                        $car->is_payment = 1;
                        $car->save();
                        $userObj->is_info = true;
                        $userObj->save();
                        DB::commit();
                        return back()->with('success','Promo code applied successfully.');
                    }
                    
                    else{
                        DB::rollBack();
                        return back()->with('error',"Invalid or expired promocode");
        
                    }
                }

                if (is_null($user->stripe_id)) {
                    $stripeCustomer = $user->createAsStripeCustomer();
                }
            
               $sub =  $user->newSubscription($request->car_id, $request->plan)->create($request->token);

               if($sub)
               {

                $sub->cancel();
                $sub->save();

                $currentDate = now();


                if($request->plan == 'price_1NdjsWC2kWkG1GrQNebWbyo2'){
                    $newDate = $currentDate->addDays(30);

                }elseif($request->plan == 'price_1NdjtlC2kWkG1GrQXqfGoCym'){

                    $newDate = $currentDate->addDays(90);

                }elseif($request->plan == 'price_1NdjucC2kWkG1GrQjvn7ogVv'){

                    $newDate = $currentDate->addDays(180);

                }
                elseif($request->plan == 'price_1NdjwIC2kWkG1GrQVmj494Vb'){

                    $newDate = $currentDate->addYear();

                }

                // Add 30 days to the current date

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
