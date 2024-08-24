<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    use HasFactory;
    
    protected $table = 'route';

    // If your primary key is not 'id', specify it here
    protected $primaryKey = 'id';

    // If the table does not have timestamps, add this
    public $timestamps = false;

    // Specify the fillable fields if you need mass assignment
    protected $fillable = ['route_name'];
}
