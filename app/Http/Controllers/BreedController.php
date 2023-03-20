<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Helpers\APIHelper;
use App\Models\Breed;
use Illuminate\Support\Facades\Redis;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;

class BreedController extends Controller
{

    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            
            $breeds = Breed::all();  
            if (!$breeds->isEmpty()){
            return APIHelper::successResponse($breeds);
           
        }else{
                
                $this->cloneAllBreedsFromDogAPI();
                $breeds = Breed::all();
                return APIHelper::successResponse($breeds);
            }

        } catch (\Exception $ex) {
            
            return APIHelper::successResponse([],$ex->getMessage());
        }
    
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->cloneAllBreedsFromDogAPI();  
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
        
            $breed = json_decode((Redis::get('breed_'.$id)));
            if (empty($breed))
            $breed = Breed::findOrFail($id);
            return APIHelper::successResponse($breed,'');
            
        } catch (\Exception $ex) {
            
            return APIHelper::failedResponse([],$ex->getMessage());
        }
       
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            
            $breed = Breed::findOrFail($id);
            $breed->name = $request->name;
            $res = $breed->save();

            if ($res)
            Redis::set('breed_'.$id,json_encode($breed));

            return APIHelper::successResponse([],'Record updated successfully');
        } catch (\Exception $ex) {
            return APIHelper::failedResponse([],$ex->getMessage());
        }
        
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {

            Breed::findOrFail($id)->delete();
            Redis::del('breed_'.$id);

            return APIHelper::successResponse([],'Record deleted successfully');

        } catch (\Exception $ex) {

            return APIHelper::failedResponse([],$ex->getMessage());
        }
        
    }

    public function getImageByBreedId ($id){
 
        try {
            $breed = json_decode((Redis::get('breed_'.$id)));
            if (empty($breed))
            $breed = Breed::findOrFail($id);
    
            if ($breed){    
            $response = APIHelper::get("/breed/$breed->name/images");
            $response = json_decode($response,true);
            $response = $response['message'];
            return APIHelper::successResponse($response[0],'');    
        }
            
        return APIHelper::successResponse([],'No Image found');
           
        } catch (\Exception $ex) {
            
            return APIHelper::failedResponse([],$ex->getMessage());
        }
        
    }

    public function cloneAllBreedsFromDogAPI (){
 
        try {
         
            $response = APIHelper::get('/breeds/list/all');
            $response = json_decode($response,true);
            $response = $response['message'];
    
           // $breeds = Breed::hydrate(array_keys($response));
    
            Breed::saveBreedsToDBAndRedis($response);
            
            return APIHelper::successResponse([],'Breeds from Dog API saved successfully');
           
           
    
        } catch (\Exception $ex) {
            
            return APIHelper::failedResponse([],$ex->getMessage());
        }
        
       }

       public function getRandomBreed (){
 
        try {
            
            $breed = Breed::orderBy(DB::raw('RAND()'))->take(1)->get();
                
            return APIHelper::successResponse($breed);
    
        } catch (\Exception $ex) {
            
            return APIHelper::failedResponse([],$ex->getMessage());
        }
        
       }
    

}
