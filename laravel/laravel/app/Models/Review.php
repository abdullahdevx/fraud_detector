<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Entity;

class Review extends Model
{
    use HasFactory;

      // Append the custom attribute to the model's JSON form
    protected $appends = ['human_readable_created_at'];

   //accessor method for the custom attribute
    public function getHumanReadableCreatedAtAttribute()
    {
        return $this->created_at->diffForHumans();
    }


    public function userBelongsTo() 
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function entityBelongsTo() 
    {
        return $this->belongsTo(Entity::class, 'entity_id');
    }
}
