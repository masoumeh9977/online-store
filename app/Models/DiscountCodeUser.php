<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiscountCodeUser extends Model
{
   protected $fillable = [
       'user_id',
       'discount_id'
   ];

   public function users(){
       return $this->belongsToMany(User::class);
   }

   public function discounts(){
       return $this->belongsToMany(Discount::class);
   }
}
