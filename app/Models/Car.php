<?php

namespace App\Models;

use Carbon\Carbon;
use FontLib\TrueType\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    // protected $appends = ['gift_count','gift_mothly'  ];
    public $appends = ['is_sold_out'];
    protected $fillable = ['sold_at'];

    public function getImageAttribute($value = '')
    {
        if (!empty($value)) {
            return asset('/uploads/images/' . $value);
        }
        return asset('/images/default-profile.jpg');
    }

    public function carImages()
    {
        return $this->hasMany(CarImage::class, 'car_id');//->select(['id','image']);
    }

    public function carImageSingle()
    {
        return $this->hasOne(CarImage::class, 'car_id');//->select(['id','image']);
    }


    public function cars_images()
    {
        return $this->hasMany(CarImage::class, 'car_id');//->select(['id','image']);
    }

    public function VehicleModel()
    {
        return $this->belongsTo(VehicleModel::class, 'vehicle_models_id')->with('VehicleCompany');
    }

    public function getCategoryAttribute()
    {
        $data = Category::select('id', 'title')->where('id', $this->category_id)->first();
        return $data ? $data->title : "";
    }

    public function vehicleFeatures()
    {
        return $this->hasMany(Vehiclefeature::class, 'car_id')->with('featureList');
    }

    public function myvechicleFeatures()
    {
        $data = [];
        $childIds = Vehiclefeature::where('car_id', $this->id)->pluck('feature_id')->toArray();
        if (!empty($childIds)) {
            $parentIds = Featurelist::whereIn('id', $childIds)->pluck('parent_id')->toArray();
            if (!empty($parentIds)) {
                $data = Featurelist::whereIn('id', $parentIds)->with(['children' => function ($query) use ($childIds) {
                    $query->when($childIds, function ($query) use ($childIds) {
                        $query->whereIn('id', $childIds);
                    });
                }])->get();
            }
        }
        //   print_r($data);
        return $data;
    }

    public function featureList()
    {
        return $this->hasMany(Vehiclefeature::class, 'car_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /*
    public function users()
    {
        return $this->hasMany(User::class, 'id');
    } */
    public function ratings()
    {
        return $this->hasMany(ReviewRating::class, 'car_id');
    }


    public function userDetails()
    {
        return $this->belongsTo(User::class, 'user_id')->with('userAddress');
    }

    public function sellerDetails()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function user_details()
    {
        return $this->belongsTo(User::class, 'user_id')->with('userAddress');
    }

    public function getIsSoldOutAttribute()
    {
        if (!empty($this->sold_at)) {
            return true;
        }
        return false;
    }

    public function getIsSubscriptionAttribute()
    {
        $dateexpire = Carbon::now()->format('Y-m-d');
        if ($this->expiry_date != null && $this->expiry_date >= $dateexpire) {
            return true;
        }
        return false;
    }

    // public function getFindMeBuyerAttribute()
    // {
    //     $payment = Payment::where('car_id', $this->id)->first();
    //     if (!empty($payment)) {
    //         return true;
    //     }
    //     return false;
    // }
}
