<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stopage extends Model
{
    use HasFactory;
   

    protected $fillable = ['train_id', 'sequence', 'source_station', 'time'];

}
