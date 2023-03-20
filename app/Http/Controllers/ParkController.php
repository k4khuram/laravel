<?php

namespace App\Http\Controllers;

use App\Models\Park;
use Illuminate\Http\Request;
use App\Models\Breed;

class ParkController extends Controller
{
   
    public function associateBreed(Request $request)
    {
        $park = Park::find($request->park_id);
        $breed = Breed::find($request->breed_id);
        
    }

   
}
