<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Train extends Model
{
    protected $table = 'train_list';

    public function stopages()
    {
        return $this->hasMany(Stopage::class, 'train_id');
    }
}
