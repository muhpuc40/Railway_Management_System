<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fare extends Model
{
    use HasFactory;

    protected $fillable = [
        'train_id', 'source_id', 'destination_id', 'class', 'fare'
    ];
}
