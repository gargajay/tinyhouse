<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class Featurelist extends Model
{
    use HasFactory,SoftDeletes;


     protected  $appends = ['name'];

    

    public function vehicleFeatures()
    {
        return $this->hasMany(Vehiclefeature::class, 'feature_id');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id', 'id');
    }

    
      
    public function parent()
    {
        return $this->hasOne(self::class, 'id', 'parent_id');
    }

    public function getChildern($id="")
    {
       $child =  Featurelist::where('parent_id',$this->id)->get();

       $user_id = 0;
      if(!empty($id)){
      $car =  Car::where('id',$id)->first();
      if(!empty($car)){
        $user_id = $car->user_id;
      }
      }

      $user =    Auth::user();
      $list  = [];
       if(!$child->isEmpty())
       {
            foreach($child as $chid)
            {
          $exit = Vehiclefeature::where(['feature_id'=>$chid->id,'user_id'=>$user_id]);

          if($id){
            $exit->where('car_id',$id);
          }
          
          
         $exit =  $exit->first();

         if($id)
         {
          if(!empty($exit)){
            $chid->is_selected = true;
          }else{
            $chid->is_selected = false;
          }
        }else{
          $chid->is_selected = false;
        }

         
          $list[] = $chid;

            }
       }

       return $list;
    }


    public function getTitleAttribute($value = '')
    {
       
      $feat =  Featurelist::find($this->id);

        if(App::getLocale()=='es'){
           
        return $feat ? $feat->es_title:$feat->title;
        }

        return $value;
    }

    public function getNameAttribute()
    {
       
      $feat =  Featurelist::find($this->id);

        if(App::getLocale()=='es'){
           
        return $feat ? $feat->es_title:$feat->title;
        }

        return $feat->title;
    }


    




      
    //   protected function subFeature(): Attribute
    //   {
    //       return Attribute::make(
    //           get: fn ($value) => 'wwe',
    //       );
    //   }

}
