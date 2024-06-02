<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Entity;

class Review extends Model
{
    use HasFactory;
    
    public function userBelongsTo() 
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function entityBelongsTo() 
    {
        return $this->belongsTo(Entity::class, 'entity_id');
    }
}
