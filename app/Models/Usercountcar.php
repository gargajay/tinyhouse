<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usercountcar extends Model
{
    use HasFactory;
    public $appends = ['average_rating', 'ratings_count', 'user_count'];
    public function carDetails()
    {
        return $this->hasMany(Car::class, 'id', 'car_id')->with('carImages', 'VehicleModel', 'vehicleFeatures');
    }
    public function cars_images()
    {
        return $this->hasMany(CarImage::class, 'car_id');
    }

    public function car_images()
    {
        return $this->hasMany(CarImage::class, 'car_id');
    }
    public function user_details()
    {
        return $this->belongsTo(User::class, 'user_id')->with('userAddress');
    }

    public function VehicleModel()
    {
        return $this->belongsTo(VehicleModel::class, 'vehicle_models_id')->with('VehicleCompany');
    }
    public function userDetails()
    {
        return $this->belongsTo(User::class, 'user_id')->with('userAddress');
    }


    public function vehicleFeatures()
    {
        return $this->hasMany(Vehiclefeature::class, 'car_id')->with('featureList');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function getUserCountAttribute()
    {
        $car_id = $this->id;
        return Usercountcar::where('car_id', $car_id)->count();
    }
    public function ratings()
    {
        return $this->hasMany(ReviewRating::class, 'car_id');
    }

    public function getRatingsCountAttribute()
    {
        return $this->hasMany(ReviewRating::class, 'car_id')->where('review_by', '!=', $this->user_id)->count('id');
    }
    public function getAverageRatingAttribute()
    {

        $rating = ReviewRating::where([
            'car_id' => $this->id,
        ])->where('review_by', '!=', $this->user_id)->get()->toArray();

        if (count($rating) > 0) {
            $totalRating = 0;
            $totalItem = count($rating);
            foreach ($rating as $rat) {
                $totalRating += (float)$rat['rating'];
            }

            $averageRating = $totalRating / $totalItem;
            return number_format((float)$averageRating, 1, '.', '');
        }
        // return 0.00;
    }
}
