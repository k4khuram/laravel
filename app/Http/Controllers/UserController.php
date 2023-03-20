<?php

namespace App\Http\Controllers;

use App\Models\Park;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Breed;
use App\Models\Breedable;
use App\Helpers\APIHelper;

class UserController extends Controller
{
  


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
   
     public function associatePark(Request $request)
    {
        $user = User::find($request->user_id);
        $park = Park::find($request->park_id);
        $user->parks()->save($park);
        return APIHelper::successResponse([],'Record saved successfully');
    }

    public function associateBreed(Request $request)
    {
        $user = User::find($request->user_id);
        $breed = Breed::find($request->breed_id);

        Breedable::create(['breed_id'=>$breed->id,
                   'breedable_type'=>'App\Models\User',
                   'breedable_id' => $user->id]);

        return APIHelper::successResponse([],'Record saved successfully');
        
    }
    
}
