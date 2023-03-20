<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;
use Carbon\Carbon;

class Breed extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    protected $table = 'breeds';

    public static function saveBreedsToDBAndRedis($breeds){

        $breedsArr = array();
        Breed::truncate(); 
        foreach ($breeds as $breed => $key){

            $arr  = array('name' => $breed, 
                         'created_at'=>Carbon::now('UTC'),
                         'updated_at' =>Carbon::now('UTC') );
            $breedsArr[] = $arr;
        }

       $res = Breed::insert($breedsArr);

       if($res){

        $breeds = Breed::all();

        self::saveBreedsToRedis($breeds);
       
        }
        
    }

    public static function saveBreedsToRedis($breeds){
         
        
        foreach ($breeds->toArray() as $breed){
            
            Redis::set('breed_'.$breed['id'],json_encode($breed));
        }
 
    }

    public function parks()
    {
        return $this->morphedByMany(Park::class, 'breedable');
    }

}
