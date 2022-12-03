<?php

namespace App\Http\Controllers\Admin;

use Hash;
use Flash;
use Validator;
use Carbon\Carbon;
Use App\Http\Controllers\AppBaseController;
use App\Http\Requests;
use App\Traits\HelperTrait;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Traits\UploaderTrait;
use Illuminate\Support\Facades\DB;
use App\Repositories\MenuRepository;
use App\Repositories\MediaRepository;
use Illuminate\Support\Facades\Storage;
use App\Repositories\MenuCategoryRepository;
use App\Http\Requests\API\Admin\Menu\CreateMenuRequest;
use App\Http\Requests\API\Admin\Menu\UpdateMenuRequest;

class MenuController extends AppBaseController
{
    use HelperTrait,UploaderTrait;    
   private $serviceRepository;
   private $mediaRepository;
   private $serviceCategoryRepository;

   public function __construct(
     MenuRepository $menuRepo,
     MediaRepository $mediaRepo, 
     MenuCategoryRepository $menuCategoryRepo
     )
    {
        $this->menuRepository = $menuRepo;
        $this->mediaRepository = $mediaRepo;
        $this->menuCategoryRepository = $menuCategoryRepo;
    }
     
     /**
     * Display a listing of the Service.
     *
     * @return Response
     */
    public function index(Request $request){
      $services = $this->menuRepository->orderBy('id', 'DESC')->get();
      return view('admin.menu.index', ['menus' => $services]);
    }

     /**
     * Show the form for creating a new Service.
     *
     * @return Response
     */
   public function create()
   {
      $categories = $this->menuCategoryRepository->where('deleted_at', null)->select('id', 'name')->get(); 
      return view('admin.menu.create')->with('categories', $categories);
   }

   /**
    * Store a newly created Menu.
    *
    * @param CreateMenuRequest $request
    *
    * @return Response
    */
   public function store(CreateMenuRequest $request)
   {
       $input = collect($request->all());
       $values = $input->only($request->fillable('menus'))->all();
       $values['slug'] = Str::slug($values['name'],'-');
       $values['restaurant_id'] = \Helper::getUserRestaurantId();
       $values['price'] = \Helper::twoDecimalPoint($request->price);
      
       DB::beginTransaction();

       try{
         $service = $this->menuRepository->create($values);

         if(!empty($request->photos)){
             $photos = $request->photos;
      
             foreach ($photos as $key=> $value) {
              $image = $this->storeFileMultipart($value, 'temp', 'public', false);

              $media = $this->mediaRepository->create([
                'name' => $image['name'],
                'path' => 'menus/'.$image['name'],
                'type' => \File::extension($this->getFile($image['path'])),
                'table_name' => "menus",
                'table_id' => $service->id,
                'status' => 1
              ]);

              $resizeImage = $this->imageResize($media->name, 300, 300);
              $photo = $this->moveFileDirectory('temp/'.$media->name , 'menus/'.$resizeImage);
      }
    }

         DB::commit();
      
         return redirect()->route('admin.menus.index')->with("success","Menu saved successfully.");
         
       }catch(\Exception $e){ 
         DB::rollBack();
         
      
         return redirect()->route('admin.menus.create')->with("success","does not created due to some error !!");
       }
       
   }

   /**
    * Display the specified Service.
    *
    * @param  int $id
    *
    * @return Response
    */
   public function show($id)
   {
       $services = $this->menuRepository->find($id);
       $medias = $this->mediaRepository->where(['table_id' => $id, 'table_name' => 'menus'])
       ->pluck('name');
       $categories = $this->menuCategoryRepository->where('deleted_at', null)->select('id', 'name')->get(); 

       if (!$services) {
           return redirect()->route('admin.menus.index')->with("success","Menu not found");
       }
       return view('admin.menu.show')->with(['menus'=> $services, 'medias'=> $medias, 'categories' => $categories]);
   }


   /**
    * Show the form for editing the specified Menu.
    *
    * @param  int $id
    *
    * @return Response
    */
   public function edit($id)
   {
     $services = $this->menuRepository->find($id);
     $medias = $this->mediaRepository->where(['table_id' => $id, 'table_name' => 'menus'])
     ->select('id','name')->get();
     $categories = $this->menuCategoryRepository->where('deleted_at', null)->select('id', 'name')->get(); 
             
     if (!$services) {
         return redirect()->route('admin.menus.index')->with("success","Menu not found");
     }
    
       return view('admin.menu.edit')->with(['menus'=> $services, 'medias'=> $medias, 'categories' => $categories]);
   }

     /**
    * Update the specified Service in storage.
    *
    * @param  int $id
    * @param UpdateMenuRequest $request
    *
    * @return Response
    */
   public function update($id, UpdateMenuRequest $request)
   {
     $services = $this->menuRepository->find($id);

     if (!$services) {
       return redirect()->route('admin.menus.index')->with("success","Menu not found");
     }
         
     $input = collect($request->all()); 
     $values = $input->only($request->fillable('menus'))->all();
     $values['slug'] = Str::slug($values['name'],'-');
     $values['price'] = \Helper::twoDecimalPoint($request->price);
     $values['sale_price'] = \Helper::twoDecimalPoint($request->sale_price);
     $values['discount'] = !empty($values['discount_type']) ? $values['discount'] : null;

     if(!empty($values['discount_type'])){
      $values['discount'] = !empty($values['discount']) ? $values['discount'] : 0;
     }
     else{
      $values['discount'] = null;
     }
    
     DB::beginTransaction();
     
     try{
       $this->menuRepository->update($values, $id);

       if(!empty($request->photos))
       {
         $saved_photos =  $this->mediaRepository->where(['table_id' => $id, 'table_name' => 'menus'])
         ->pluck('name')->toArray();
        
         $saved_photo_ids =  $this->mediaRepository->where(['table_id' => $id, 'table_name' => 'menus'])
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
  
         foreach ($photos as $key=> $value) {
          $image = $this->storeFileMultipart($value, 'temp', 'public', false);
    
          $media = $this->mediaRepository->create([
            'name' => $image['name'], 
            'path' => 'menus/'.$image['name'],
            'type' => \File::extension($this->getFile($image['path'])),
            'table_name' => "menus",
            'table_id' => $id,
            'status' => 1
          ]);

          $resizeImage = $this->imageResize($media->name, 300, 300);
          $photo = $this->moveFileDirectory('temp/'.$media->name , 'menus/'.$resizeImage);
        }
      }
           
       DB::commit();
       
       return redirect()->route('admin.menus.index')->with("success","Menu updated successfully");
       
     }catch(\Exception $e){ 
       DB::rollBack(); 
       
  
       return redirect()->route('admin.menus.index')->with("success"," Menu does not updated due to some error !!");
     }
   }

    /**
    * Remove the specified Service from storage.
    *
    * @param  int $id
    *
    * @return Response
    */
   public function destroy($id)
   {
     $services = $this->menuRepository->find($id);

     if (!$services) {
     

       return redirect()->route('admin.menus.index')->with("success","Menu not found.");
     }
     DB::beginTransaction();
     
     try{

      $saved_photos =  $this->mediaRepository->where(['table_id' => $id, 'table_name' => 'menus'])
         ->pluck('name')->toArray();
        
      $saved_photo_ids =  $this->mediaRepository->where(['table_id' => $id, 'table_name' => 'menus'])
      ->pluck('id');

      $this->mediaRepository->whereIn('id', $saved_photo_ids)->delete();

      foreach($saved_photos as $saved_photo){
       $this->deleteFile('menus/'.$saved_photo);
      }
 
       $this->menuRepository->delete($id);
       DB::commit();
 
       return redirect()->route('admin.menus.index')->with("success","Menu deleted successfully.");
       
     }catch(\Exception $e){
       DB::rollBack();
       
     
       return redirect()->route('admin.menus.index')->with("success","Menu does not deleted due to some error");
     }
   }	

   public function deleteMenuImage(Request $request){
      $id = $request->image_id;

     $image =  $this->mediaRepository->where('id', $id)->first();
      DB::beginTransaction();
     
      try{

        if(!empty($image)){
         
          $file_name = $image->file_name;
          $this->deleteFile('menus/'.$file_name);
          $image->delete(); 
    		 
        }
       
        DB::commit();
 
       return 'success';
       
     }catch(\Exception $e){
       DB::rollBack();
       return 'failure';
     }
   }
}
