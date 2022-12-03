<?php

namespace App\Http\Controllers\Admin;

Use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Repositories\ZipCodeRepository;
use App\Http\Requests\API\Admin\Zipcode\CreateZipCodeRequest;
use App\Http\Requests\API\Admin\Zipcode\UpdateZipCodeRequest;

class ZipCodeController extends AppBaseController
{
  
    private $zipRepository;
  

    public function __construct( ZipCodeRepository $zip) {
        $this->zipRepository = $zip;
     
    }

        /**
     * Display a listing of the zipcodes.
     *
     * @return Response
     */
    public function index(Request $request){
        $zipCodes = $this->zipRepository->where('restaurant_id', \Helper::getUserRestaurantId())->orderBy('id', 'DESC')->get();
        return view('admin.zipcode.index', ['zipcodes' => $zipCodes]);
    }
  
       /**
       * Show the form for creating a new zipcode.
       *
       * @return Response
       */
     public function create()
     { 
        return view('admin.zipcode.create');
     }

     /**
    * Store a newly created zipcode.
    *
    * @param CreateZipCodeRequest $request
    *
    * @return Response
    */
   public function store(CreateZipCodeRequest $request)
   {
       $input = collect($request->all());
       $values = $input->only($request->fillable('zipcode'))->all();
       $values['restaurant_id'] = \Helper::getUserRestaurantId();
       DB::beginTransaction();

       try{
         $zipcode = $this->zipRepository->create($values);
         DB::commit();
         return redirect()->route('admin.zipcodes.index')->with("success","Zipcode saved successfully.");
         
       }catch(\Exception $e){ 
         DB::rollBack();
         return redirect()->route('admin.zipcodes.create')->with("success","does not created due to some error !!");
       }
       
   }

   /**
    * Display the specified zipcodes.
    *
    * @param  int $id
    *
    * @return Response
    */
    public function show($id)
    {
        $zipcodes = $this->zipRepository->find($id);
       
        if (!$zipcodes) {
            return redirect()->route('admin.zipcodes.index')->with("success","Zipcode not found");
        }
        return view('admin.zipcode.show')->with(['zipcodes'=> $zipCodes]);
    }
 
 
    /**
     * Show the form for editing the specified zipcode.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
      $zipcode = $this->zipRepository->find($id);
     
      if (!$zipcode) {
          return redirect()->route('admin.zipcodes.index')->with("success","Zipcode not found");
      }
        return view('admin.zipcode.edit')->with(['zipcodes'=> $zipcode]);
    }
 
      /**
     * Update the specified zipcode in storage.
     *
     * @param  int $id
     * @param UpdateZipCodeRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateZipCodeRequest $request)
    {
      $zipCode = $this->zipRepository->find($id);
      
      if (!$zipCode) {
        return redirect()->route('admin.zipcodes.index')->with("success","Zip code not found");
      }
          
      $input = collect($request->all()); 
      $values = $input->only($request->fillable('zipcode'))->all();
      $values['restaurant_id'] = \Helper::getUserRestaurantId();
      DB::beginTransaction();
      
      try{
        $this->zipRepository->update($values, $id);
            
        DB::commit();
        
        return redirect()->route('admin.zipcodes.index')->with("success", "Zipcode updated successfully");
        
      }catch(\Exception $e){ 
        DB::rollBack(); 
        return redirect()->route('admin.zipcodes.index')->with("success"," Zipcode does not updated due to some error !!");
      }
    }
 
     /**
     * Remove the specified zipcodes from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
      $zipcode = $this->zipRepository->find($id);
      if (!$zipcode) {
        return redirect()->route('admin.zipcodes.index')->with("success","Zipcode not found.");
      }
      DB::beginTransaction();
      try{
        $this->zipRepository->delete($id);
        DB::commit();
        return redirect()->route('admin.zipcodes.index')->with("success","Zipcode deleted successfully.");
      }
      catch(\Exception $e){
        DB::rollBack();
        return redirect()->route('admin.zipcodes.index')->with("success","Zipcode does not deleted due to some error");
      }
    }	
 
    
    
}
