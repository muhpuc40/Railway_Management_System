<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stopage extends Model
{
    protected $table = 'train_stopage';

    public function train()
    {
        return $this->belongsTo(Train::class, 'train_id');
    }
}
