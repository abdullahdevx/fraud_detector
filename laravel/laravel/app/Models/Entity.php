<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Review;

class Entity extends Model
{
    public function reviews() 
    {
        return $this->hasMany(Review::class);
    }
    
    use HasFactory;

    public function getTotalRating()
    {
        return $this->reviews()->avg('rating');
    }

    public function totalReviews()
    {
        return $this->reviews()->count('rating');

    }
}
