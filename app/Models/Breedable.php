<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Breedable extends Model
{
    use HasFactory;

    
    protected $fillable = [
        'breed_id',
        'breedable_type',
        'breedable_id'
    ];

    protected $table = 'breedables'; 

    public function breedable()
    {
        return $this->morphTo();
    }
}
