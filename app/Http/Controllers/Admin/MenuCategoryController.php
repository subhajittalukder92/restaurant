<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Repositories\MenuCategoryRepository;
Use App\Http\Controllers\AppBaseController;
use App\Repositories\MediaRepository;
use Flash;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\API\Admin\MenuCategory\CreateMenuCategoryRequest;
use App\Http\Requests\API\Admin\MenuCategory\UpdateMenuCategoryRequest;
use App\Traits\HelperTrait;
use App\Traits\UploaderTrait;
use Carbon\Carbon;
use Illuminate\Support\Str;

class MenuCategoryController extends AppBaseController
{
    use HelperTrait,UploaderTrait;   
   private $serviceCategoryRepository;
   private $mediaRepository;
   
   public function __construct(MenuCategoryRepository $serviceCategoryRepo, MediaRepository $mediaRepo)
    {
        $this->menuCategoryRepository = $serviceCategoryRepo;
        $this->mediaRepository = $mediaRepo;
    }
     
    public function index(Request $request){
      $serviceCategories = $this->menuCategoryRepository->orderBy('id', 'DESC')->get();
      return view('admin.menu_category.index', ['menuCategories' => $serviceCategories]);

  }

      /**
     * Show the form for creating a new Menu Category.
     *
     * @return Response
     */
    public function create()
   {
       return view('admin.menu_category.create');
   }
    /**
     * Store a newly created Menu Category.
     *
     * @param CreateMenuCategoryRequest $request
     *
     * @return Response
     */
    public function store(CreateMenuCategoryRequest $request)
    {
        $input = collect($request->all());
        $values = $input->only($request->fillable('menu_categories'))->all();
        $values['slug'] = Str::slug($values['name'],'-');
        $values['restaurant_id'] = \Helper::getUserRestaurantId();
        DB::beginTransaction();
        
        try{
          $serviceCategory = $this->menuCategoryRepository->create($values);
          if(!empty($request->photos)){
            $photos = $request->photos;
     
            foreach ($photos as $key=> $value) {
             $image = $this->storeFileMultipart($value, 'temp', 'public', false);

             $media = $this->mediaRepository->create([
               'name' => $image['name'],
               'path' => 'menus_category/'.$image['name'],
               'type' => \File::extension($this->getFile($image['path'])),
               'table_name' => "menu_categories",
               'table_id' => $serviceCategory->id,
               'status' => 1
             ]);

             $resizeImage = $this->imageResize($media->name, 300, 300);
             $photo = $this->moveFileDirectory('temp/'.$media->name , 'menus_category/'.$resizeImage);
     }
   }
          DB::commit();
       
          return redirect()->route('admin.menu-category.index')->with("success","Menu Category added");
          
        }catch(\Exception $e){
          DB::rollBack();
          return redirect()->route('admin.menu-category.index')->with("success","Menu Category does not created due to some error !!");
        }
				
    }

    /**
     * Display the specified Service Category.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $serviceCategory = $this->menuCategoryRepository->find($id);
        $medias = $this->mediaRepository->where(['table_id' => $id, 'table_name' => 'menu_categories'])
       ->pluck('name');
        if (!$serviceCategory) {
            
            return redirect()->route('admin.menu-category.index')->with("success","Menu Category not found");
        }
        return view('admin.menu_category.show')->with(['menuCategory'=> $serviceCategory,'medias'=> $medias]);
    }


    /**
     * Show the form for editing the specified Menu Category.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
      $serviceCategory = $this->menuCategoryRepository->find($id);
      $medias = $this->mediaRepository->where(['table_id' => $id, 'table_name' => 'menu_categories'])
     ->select('id','name')->get();        
      if (!$serviceCategory) {
          return redirect()->route('admin.menu-category.index')->with("success","Menu Category not found");
      }
        return view('admin.menu_category.edit')->with(['menuCategory'=> $serviceCategory,'medias'=> $medias]);
    }

      /**
     * Update the specified Menu Category in storage.
     *
     * @param  int $id
     * @param UpdateMenuCategoryRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateMenuCategoryRequest $request)
    {
      $serviceCategory = $this->menuCategoryRepository->find($id);

      if (!$serviceCategory) {
        

        return redirect()->route('admin.menu-category.index')->with("success","Menu Category not found");
      }
          
      $input = collect($request->all()); 
      $values = $input->only($request->fillable('menu_categories'))->all();
      $values['slug'] = Str::slug($values['name'],'-');
                
      DB::beginTransaction();
      
      try{
        $this->menuCategoryRepository->update($values, $id);
        if(!empty($request->photos)){
            $saved_photos =  $this->mediaRepository->where(['table_id' => $id, 'table_name' => 'menu_categories'])
            ->pluck('name')->toArray();
           
            $saved_photo_ids =  $this->mediaRepository->where(['table_id' => $id, 'table_name' => 'menu_categories'])
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
               'path' => 'menus_category/'.$image['name'],
               'type' => \File::extension($this->getFile($image['path'])),
               'table_name' => "menu_categories",
               'table_id' => $id,
               'status' => 1
             ]);
   
             $resizeImage = $this->imageResize($media->name, 300, 300);
             $photo = $this->moveFileDirectory('temp/'.$media->name , 'menus_category/'.$resizeImage);
           }
        }    
        DB::commit();
        
      
        return redirect()->route('admin.menu-category.index')->with("success","Menu Category updated successfully.");
        
      }catch(\Exception $e){
        DB::rollBack();
        
        
        return redirect()->route('admin.menu-category.index')->with("success","Menu Category does not updated due to some error !!.");
      }
    }

     /**
     * Remove the specified Service Category from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
      $serviceCategory = $this->menuCategoryRepository->find($id);

      if (!$serviceCategory) {

        return redirect()->route('admin.menu-category.index')->with("success","Menu Category not found.");
      }
			DB::beginTransaction();
			
			try{
				$saved_photos =  $this->mediaRepository->where(['table_id' => $id, 'table_name' => 'menu_categories'])
                    ->pluck('name')->toArray();
                    
                $saved_photo_ids =  $this->mediaRepository->where(['table_id' => $id, 'table_name' => 'menu_categories'])
                ->pluck('id');

                $this->mediaRepository->whereIn('id', $saved_photo_ids)->delete();

                foreach($saved_photos as $saved_photo){
                $this->deleteFile('menus_category/'.$saved_photo);
                }
				$this->menuCategoryRepository->delete($id);
				DB::commit();
			
        return redirect()->route('admin.menu-category.index')->with("success","Menu Category deleted successfully.");
				
			}catch(\Exception $e){
				DB::rollBack();
				
	
        return redirect()->route('admin.menu-category.index')->with("success","Menu Category does not deleted due to some error !!");
			}
    }	
    public function deleteMenuCatImage(Request $request){
      $id = $request->image_id;

      $saved_photo =  $this->mediaRepository->where('id', $id)->first();

      DB::beginTransaction();
     
      try{

        if(!empty($saved_photo)){
          $file_name = $saved_photo->file_name;
          $this->deleteFile('menus_category/'.$file_name);
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
