<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'email',
        'location',
    ];
    
    protected $table = 'users';

    public function breeds()
    {
        return $this->morphMany(Breed::class,'breedable');
    } 

    public function parks()
    {
        return $this->morphToMany(Park::class, 'parkable');
    }

}
