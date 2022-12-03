<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\SliderRepository;
use App\Repositories\MediaRepository;
Use App\Http\Controllers\AppBaseController;
use Flash;
use Hash;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\API\Admin\Slider\CreateSliderRequest;
use App\Http\Requests\API\Admin\Slider\UpdateSliderRequest;
use App\Traits\HelperTrait;
use App\Traits\UploaderTrait;
use Carbon\Carbon;
use Illuminate\Support\Str;

class SliderController extends AppBaseController
{
    use HelperTrait,UploaderTrait;    
    private $sliderRepository;
    private $mediaRepository;

    public function __construct( SliderRepository $sliderRepo,MediaRepository $mediaRepo) {
        $this->sliderRepository = $sliderRepo;
        $this->mediaRepository = $mediaRepo;
    }

        /**
     * Display a listing of the Slider.
     *
     * @return Response
     */
    public function index(Request $request){
        $all_sliders = $this->sliderRepository->orderBy('id', 'DESC')->get();
        return view('admin.slider.index', ['sliders' => $all_sliders]);
      }
  
       /**
       * Show the form for creating a new Slider.
       *
       * @return Response
       */
     public function create()
     { 
        return view('admin.slider.create');
     }

     /**
    * Store a newly created Slider.
    *
    * @param CreateSliderRequest $request
    *
    * @return Response
    */
   public function store(CreateSliderRequest $request)
   {
       $input = collect($request->all());
       $values = $input->only($request->fillable('sliders'))->all();
       $values['restaurant_id'] = \Helper::getUserRestaurantId();
       DB::beginTransaction();

       try{
         $slider = $this->sliderRepository->create($values);

         if(!empty($request->photos)){
             $photos = $request->photos;
              $image = $this->storeFileMultipart($photos, 'temp', 'public', false);

              $media = $this->mediaRepository->create([
                'name' => $image['name'],
                'path' => 'slider/'.$image['name'],
                'type' => \File::extension($this->getFile($image['path'])),
                'table_name' => "sliders",
                'table_id' => $slider->id,
                'status' => 1
              ]);

              $resizeImage = $this->imageResize($media->name, 300, 300);
              $photo = $this->moveFileDirectory('temp/'.$media->name , 'slider/'.$resizeImage);
    }

         DB::commit();
      
         return redirect()->route('admin.slider.index')->with("success","Slider saved successfully.");
         
       }catch(\Exception $e){ 
         DB::rollBack();
         
      
         return redirect()->route('admin.slider.create')->with("success","does not created due to some error !!");
       }
       
   }

   /**
    * Display the specified slider.
    *
    * @param  int $id
    *
    * @return Response
    */
    public function show($id)
    {
        $sliders = $this->sliderRepository->find($id);
        $medias = $this->mediaRepository->where(['table_id' => $id, 'table_name' => 'sliders'])
        ->pluck('name');
 
        if (!$sliders) {
            return redirect()->route('admin.slider.index')->with("success","Slider not found");
        }
        return view('admin.slider.show')->with(['sliders'=> $sliders, 'medias'=> $medias]);
    }
 
 
    /**
     * Show the form for editing the specified slider.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
      $sliders = $this->sliderRepository->find($id);
      $medias = $this->mediaRepository->where(['table_id' => $id, 'table_name' => 'sliders'])
      ->select('id','name')->get();
     
      if (!$sliders) {
          return redirect()->route('admin.slider.index')->with("success","Slider not found");
      }
        return view('admin.slider.edit')->with(['sliders'=> $sliders, 'medias'=> $medias]);
    }
 
      /**
     * Update the specified sliders in storage.
     *
     * @param  int $id
     * @param UpdateSliderRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSliderRequest $request)
    {
      $slider = $this->sliderRepository->find($id);
      
      if (!$slider) {
        return redirect()->route('admin.slider.index')->with("success","Slider not found");
      }
          
      $input = collect($request->all()); 
      $values = $input->only($request->fillable('sliders'))->all();
      $values['restaurant_id'] = \Helper::getUserRestaurantId();
      DB::beginTransaction();
      
      try{
        $this->sliderRepository->update($values, $id);
 
        if(!empty($request->photos)){
          $saved_photos =  $this->mediaRepository->where(['table_id' => $id, 'table_name' => 'sliders'])
          ->pluck('name')->toArray();
         
          $saved_photo_ids =  $this->mediaRepository->where(['table_id' => $id, 'table_name' => 'sliders'])
          ->pluck('id');
 
          if(count($saved_photos) == 1){
            $validator =  Validator::make($request->all(),[
               'photos' => 'nullable|max:1'
            ]);
            $validator->errors()->add('photos', 'Maximum 1 files can be uploaded so delete old images.');
            $messages = $validator->messages();
            return redirect()->back()->withErrors($messages)->withInput($values); 
          }
 
          $photos = $request->photos;
   
         
           $image = $this->storeFileMultipart($photos, 'temp', 'public', false);
     
           $media = $this->mediaRepository->create([
             'name' => $image['name'], 
             'path' => 'slider/'.$image['name'],
             'type' => \File::extension($this->getFile($image['path'])),
             'table_name' => "sliders",
             'table_id' => $id,
             'status' => 1
           ]);
 
           $resizeImage = $this->imageResize($media->name, 300, 300);
           $photo = $this->moveFileDirectory('temp/'.$media->name , 'slider/'.$resizeImage);
       
      }
            
        DB::commit();
        
        return redirect()->route('admin.slider.index')->with("success","Slider updated successfully");
        
      }catch(\Exception $e){ 
        DB::rollBack(); 
        
   
        return redirect()->route('admin.slider.index')->with("success"," Slider does not updated due to some error !!");
      }
    }
 
     /**
     * Remove the specified slider from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
      $sliders = $this->sliderRepository->find($id);
 
      if (!$sliders) {
      
 
        return redirect()->route('admin.slider.index')->with("success","Slider not found.");
      }
      DB::beginTransaction();
      
      try{
 
       $saved_photos =  $this->mediaRepository->where(['table_id' => $id, 'table_name' => 'sliders'])
          ->pluck('name')->toArray();
         
       $saved_photo_ids =  $this->mediaRepository->where(['table_id' => $id, 'table_name' => 'sliders'])
       ->pluck('id');
 
       $this->mediaRepository->whereIn('id', $saved_photo_ids)->delete();
 
       foreach($saved_photos as $saved_photo){
        $this->deleteFile('slider/'.$saved_photo);
       }
  
        $this->sliderRepository->delete($id);
        DB::commit();
  
        return redirect()->route('admin.slider.index')->with("success","Slider deleted successfully.");
        
      }catch(\Exception $e){
        DB::rollBack();
        
      
        return redirect()->route('admin.slider.index')->with("success","Slider does not deleted due to some error");
      }
    }	
 
    public function deleteSliderImage(Request $request){
       $id = $request->image_id;
 
       $saved_photo =  $this->mediaRepository->where('id', $id)->first();
 
       DB::beginTransaction();
      
       try{
 
         if(!empty($saved_photo)){
           $file_name = $saved_photo->file_name;
           $this->deleteFile('slider/'.$file_name);
           $saved_photo->delete();
         }
 
         DB::commit();
  
        return 'success';
        
      }catch(\Exception $e){
        DB::rollBack();
        return 'failure';
      }
    }
    
}
