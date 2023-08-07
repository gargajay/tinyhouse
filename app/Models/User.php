<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Auth;
use Rennokki\QueryCache\Traits\QueryCacheable;
use Laravel\Cashier\Billable;


class User extends Authenticatable
{
    use HasApiTokens, Notifiable, SoftDeletes;



    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password', 'user_type', 'phone_number_full'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public $appends = ['average_rating', 'ratings_count', 'subscription_traction_id', 'subscription_amount','notification_count'];

    // public static function checkUser($data)
    // {
    //     $response = [];
    //     if (array_key_exists('username', $data)) {
    //         if (Auth::validate(array('username' => $data['username'], 'password' => $data['password']))) {
    //             $user = User::where('username', $data['username'])->first();
    //             $response['user'] = $user;
    //         } else {
    //             $response['message'] = 'Incorrect username or password';
    //         }
    //     } elseif (array_key_exists('email', $data)) {
    //         $userObj = User::where('email', strtolower($data['email']))->where('email', strtoupper($data['email']))->first();
    //         if (!$userObj) {
    //             $response['message'] = 'Please enter valid registered email.';
    //             return $response;
    //         }
    //         if (Auth::validate(array('email' => $data['email'], 'password' => $data['password']))) {
    //             $user = User::where('email', $data['email'])->first();
    //             $response['user'] = $user;
    //         } else {
    //             $response['message'] = 'Incorrect password';
    //         }
    //     } else {
    //         $response['message'] = 'Email or username is required';
    //     }
    //     return $response;
    // }

    public static function login($data)
    {
        $response = [];
        if(isset($data['email'])){
            $findUser = User::whereRaw('LOWER(email)
 = ?', [strtolower($data['email'])])->first();
            if(!empty($findUser))
            {
                $findUser->email = strtolower($data['email']);
                $findUser->save();
            }
        }
        if (array_key_exists('username', $data)) {
            if (Auth::validate(array('username' => $data['username'], 'password' => $data['password']))) {
                $user = User::where('username', $data['username'])->first();
                $response['user'] = $user;
            } else {
                $response['message'] = __("message.INCORRECT_NAME_PASSWORD");
            }
        } elseif (array_key_exists('email', $data)) {
            $userObj = User::where('email', $data['email'])->first();
            if (!$userObj) {
                $response['message'] =__("message.VALID_EMAIL");
                return $response;
            }
            if (Auth::validate(array('email' => $data['email'], 'password' => $data['password']))) {
                $user = User::where('email', $data['email'])->first();
                $response['user'] = $user;
            } else {
                $response['message'] =__("message.INCORRECT_PASSWORD");
            }
        } elseif (array_key_exists('mobile', $data)) {
            $userObj = User::where('mobile', $data['mobile'])->first();
            if (!$userObj) {
                $response['message'] =__("message.INCORRECT_MOBILE");
                return $response;
            }
            if (Auth::validate(array('mobile' => $data['mobile'], 'password' => $data['password']))) {
                $user = User::where('mobile', $data['mobile'])->first();
                $response['user'] = $user;
            } else {
                $response['message'] =__("message.INCORRECT_PASSWORD");
            }
        } else {
            $response['message'] =__("message.EMAIL_MOBILE_REQUIRED");
        }
        return $response;
    }


    public static function checkUser($data)
    {
        $response = [];
        if (array_key_exists('username', $data)) {
            if (Auth::validate(array('username' => $data['username'], 'password' => $data['password']))) {
                $user = User::where('username', $data['username'])->first();
                $response['user'] = $user;
            } else {
                $response['message'] =__("message.INCORRECT_NAME_PASSWORD");
            }
        } elseif (array_key_exists('email', $data)) {
            $userObj = User::where('email', $data['email'])->first();
            if (!$userObj) {
                $response['message'] =__("message.VALID_EMAIL");
                return $response;
            }
            if (Auth::validate(array('email' => $data['email'], 'password' => $data['password']))) {
                $user = User::where('email', $data['email'])->first();
                $response['user'] = $user;
            } else {
                $response['message'] = __("message.INCORRECT_PASSWORD");
            }
        } else {
            $response['message'] = __("message.EMAIL_USERNAME_REQUIRED");
        }
        return $response;
    }

    // public static function login($data)
    // {
    //     $response = [];
    //     if (array_key_exists('username', $data)) {
    //         if (Auth::validate(array('username' => $data['username'], 'password' => $data['password']))) {
    //             $user = User::where('username', $data['username'])->first();
    //             $response['user'] = $user;
    //         } else {
    //             $response['message'] = 'Incorrect username or password';
    //         }
    //     } elseif (array_key_exists('email', $data)) {

    //         $userObj = User::where('email', $data['email'])->first();
    //         if (!$userObj) {
    //             $response['message'] = 'Please enter valid registered email.';
    //             return $response;
    //         }
    //         if (Auth::validate(array('email' => $data['email'], 'password' => $data['password']))) {
    //             $user = User::where('email', $data['email'])->first();
    //             $response['user'] = $user;
    //         } else {
    //             $response['message'] = 'Incorrect password';
    //         }
    //     } elseif (array_key_exists('mobile', $data)) {
    //         $userObj = User::where('mobile', $data['mobile'])->first();
    //         if (!$userObj) {
    //             $response['message'] = 'Incorrect mobile';
    //             return $response;
    //         }
    //         if (Auth::validate(array('mobile' => $data['mobile'], 'password' => $data['password']))) {
    //             $user = User::where('mobile', $data['mobile'])->first();
    //             $response['user'] = $user;
    //         } else {
    //             $response['message'] = 'Incorrect password';
    //         }
    //     } else {
    //         $response['message'] = 'Email or mobile is required';
    //     }
    //     return $response;
    // }

    public static function webLogin($data)
    {
        $response = [];
        $response = [];
        if(isset($data['email'])){
            $findUser = User::whereRaw('LOWER(email)
 = ?', [strtolower($data['email'])])->first();
            if(!empty($findUser))
            {
                $findUser->email = strtolower($data['email']);
                $findUser->save();
            }
        }
        if (array_key_exists('username', $data)) {
            if (Auth::attempt(array('username' => $data['username'], 'password' => $data['password']))) {
                $user = User::where('username', $data['username'])->first();
                $response['user'] = $user;
            } else {
                $response['message'] = 'Incorrect username or password';
            }
        } elseif (array_key_exists('email', $data)) {
            $userObj = User::where('email', $data['email'])->first();
            if (!$userObj) {
                $response['message'] = 'Please enter valid registered email.';
                return $response;
            }
            if (Auth::attempt(array('email' => $data['email'], 'password' => $data['password']))) {
                $user = User::where('email', $data['email'])->first();
                $response['user'] = $user;
            } else {
                $response['message'] = 'Incorrect password';
            }
        } else {
            $response['message'] = 'Email or username is required';
        }

        return $response;
    }
    public function user_detail()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
    public function add_tally()
    {
        return $this->hasMany(addTally::class, 'user_id');
    }
    public function assign()
    {
        return $this->hasMany(TallyUser::class, 'user_id');
    }
    public function getPhoneNumberFullAttribute()
    {
        return $this->country_code . $this->mobile;
    }
    public function getImageAttribute($value = '')
    {
        if (!empty($value)) {
            return asset('public/uploads/images/' . $value);
        }
        return asset('public/images/default-profile.jpg');
    }

    public function user_address()
    {
        return $this->hasOne(Address::class, 'id', 'user_id');
    }
    
    public function userAddress()
    {
       return  $this->hasOne(Address::class, 'user_id');

       
        
    }

    public function VehicleDetails()
    {
        return $this->hasMany(Car::class, 'user_id')->with('VehicleModel');
    }

    public function carDetails()
    {
        return $this->belongsTo(Car::class, 'id', 'user_id')->with('VehicleModel', 'carImages');
    }

    public function ratings()
    {
        return $this->hasMany(ReviewRating::class, 'car_id');
    }

    public function getRatingsCountAttribute()
    {
        return ReviewRating::where('user_id', $this->id)->count();
    }


    public function getNotificationCountAttribute()
    {
       $user_id =  Auth::user()->id ?? 0;
        return Notification::where(['user_id' => $user_id, 'is_seen' => 0])->count();
    }

    

    public function getAverageRatingAttribute()
    {

        $userId = $this->id;

        $averageRating = ReviewRating::where('user_id', $userId)->get()->avg('rating') ?? 0;

        return number_format((float)$averageRating, 1, '.', '');
    }

    public function getSubscriptionTractionIdAttribute()
    {

        $userId = $this->id;
        $subscriptionPayment = SubscriptionPayment::where('user_id', $userId)->latest()->first() ?? '';
        return  $subscriptionPayment->subscription_traction_id ?? "";
    }

    public function getSubscriptionAmountAttribute()
    {

        $userId = $this->id;
        $subscriptionAmount = SubscriptionPayment::where('user_id', $userId)->latest()->first() ?? '';
        return  $subscriptionAmount->subscription_amount ?? "ßßß";
    }

    
}
