<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Park extends Model
{
    use HasFactory;

    
    protected $fillable = [
        'name'
    ];
    protected $table = 'parks';


    public function users()
    {
        return $this->morphedByMany(User::class, 'parkable');
    }

    public function breeds()
    {
        return $this->morphToMany(Breed::class, 'breedable');
    }
   
}
