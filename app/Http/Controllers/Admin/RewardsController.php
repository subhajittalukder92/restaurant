<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\RewardRepository;
use App\Repositories\MediaRepository;
Use App\Http\Controllers\AppBaseController;
use Flash;
use Hash;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\API\Admin\Reward\CreateRewardRequest;
use App\Http\Requests\API\Admin\Reward\UpdateRewardRequest;
use App\Traits\HelperTrait;
use App\Traits\UploaderTrait;
use Carbon\Carbon;
use Illuminate\Support\Str;

class RewardsController extends AppBaseController
{
    use HelperTrait,UploaderTrait;    
    private $rewardRepository;
    private $mediaRepository;

    public function __construct( RewardRepository $rewardRepo,MediaRepository $mediaRepo) {
        $this->rewardRepository = $rewardRepo;
        $this->mediaRepository = $mediaRepo;
    }

        /**
     * Display a listing of the Reward.
     *
     * @return Response
     */
    public function index(Request $request){
        $all_rewards = $this->rewardRepository->orderBy('id', 'DESC')->get();
        return view('admin.reward.index', ['rewards' => $all_rewards]);
      }
  
       /**
       * Show the form for creating a new Reward.
       *
       * @return Response
       */
     public function create()
     { 
        return view('admin.reward.create');
     }

     /**
    * Store a newly created Reward.
    *
    * @param CreateRewardRequest $request
    *
    * @return Response
    */
   public function store(CreateRewardRequest $request)
   {
       $input = collect($request->all());
       $values = $input->only($request->fillable('rewards'))->all();
       $values['restaurant_id'] = \Helper::getUserRestaurantId();
     
       DB::beginTransaction();
     
       try{
         $reward = $this->rewardRepository->create($values);

         if(!empty($request->photos)){
             $photos = $request->photos;
              $image = $this->storeFileMultipart($photos, 'temp', 'public', false);

              $media = $this->mediaRepository->create([
                'name' => $image['name'],
                'path' => 'reward/'.$image['name'],
                'type' => \File::extension($this->getFile($image['path'])),
                'table_name' => "rewards",
                'table_id' => $reward->id,
                'status' => 1
              ]);

              $resizeImage = $this->imageResize($media->name, 300, 300);
              $photo = $this->moveFileDirectory('temp/'.$media->name , 'reward/'.$resizeImage);
    }

         DB::commit();
      
         return redirect()->route('admin.reward.index')->with("success","Reward saved successfully.");
         
       }catch(\Exception $e){ 
          
         DB::rollBack();
         
      
         return redirect()->route('admin.reward.create')->with("success",$e->getMessage());
       }
       
   }

   /**
    * Display the specified Reward.
    *
    * @param  int $id
    *
    * @return Response
    */
    public function show($id)
    {
        $rewards = $this->rewardRepository->find($id);
        $medias = $this->mediaRepository->where(['table_id' => $id, 'table_name' => 'rewards'])
        ->pluck('name');
 
        if (!$rewards) {
            return redirect()->route('admin.reward.index')->with("success","Reward not found");
        }
        return view('admin.reward.show')->with(['rewards'=> $rewards, 'medias'=> $medias]);
    }
  /**
     * Show the form for editing the specified Reward.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
      $rewards = $this->rewardRepository->find($id);
      $medias = $this->mediaRepository->where(['table_id' => $id, 'table_name' => 'rewards'])
      ->select('id','name')->get();
     
      if (!$rewards) {
          return redirect()->route('admin.reward.index')->with("success","Reward not found");
      }
        return view('admin.reward.edit')->with(['rewards'=> $rewards, 'medias'=> $medias]);
    }
 
      /**
     * Update the specified reward in storage.
     *
     * @param  int $id
     * @param UpdateRewardRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateRewardRequest $request)
    {
      $rewards = $this->rewardRepository->find($id);
 
      if (!$rewards) {
        return redirect()->route('admin.reward.index')->with("success","Reward not found");
      }
      
      $request['restaurant_id'] = \Helper::getUserRestaurantId();    
      $input = collect($request->all()); 
      $values = $input->only($request->fillable('rewards'))->all();
     
      DB::beginTransaction();
      
      try{
        $this->rewardRepository->update($values, $id);
 
        if(!empty($request->photos)){
          $saved_photos =  $this->mediaRepository->where(['table_id' => $id, 'table_name' => 'rewards'])
          ->pluck('name')->toArray();
         
          $saved_photo_ids =  $this->mediaRepository->where(['table_id' => $id, 'table_name' => 'rewards'])
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
             'path' => 'reward/'.$image['name'],
             'type' => \File::extension($this->getFile($image['path'])),
             'table_name' => "rewards",
             'table_id' => $id,
             'status' => 1
           ]);
 
           $resizeImage = $this->imageResize($media->name, 300, 300);
           $photo = $this->moveFileDirectory('temp/'.$media->name , 'reward/'.$resizeImage);
       
      }
            
        DB::commit();
        
        return redirect()->route('admin.reward.index')->with("success","Reward updated successfully");
        
      }catch(\Exception $e){ 
        DB::rollBack(); 
        
   
        return redirect()->route('admin.reward.index')->with("success"," Reward does not updated due to some error !!");
      }
    }
 
     /**
     * Remove the specified Reward from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
      $reward = $this->rewardRepository->find($id);
 
      if (!$reward) {
      
 
        return redirect()->route('admin.reward.index')->with("success","Reward not found.");
      }
      DB::beginTransaction();
      
      try{
 
       $saved_photos =  $this->mediaRepository->where(['table_id' => $id, 'table_name' => 'rewards'])
          ->pluck('name')->toArray();
         
       $saved_photo_ids =  $this->mediaRepository->where(['table_id' => $id, 'table_name' => 'rewards'])
       ->pluck('id');
 
       $this->mediaRepository->whereIn('id', $saved_photo_ids)->delete();
 
       foreach($saved_photos as $saved_photo){
        $this->deleteFile('reward/'.$saved_photo);
       }
  
        $this->rewardRepository->delete($id);
        DB::commit();
  
        return redirect()->route('admin.reward.index')->with("success","Reward deleted successfully.");
        
      }catch(\Exception $e){
        DB::rollBack();
        
      
        return redirect()->route('admin.reward.index')->with("success","Reward does not deleted due to some error");
      }
    }	
 
    public function deleteRewardImage(Request $request){
       $id = $request->image_id;
 
       $saved_photo =  $this->mediaRepository->where('id', $id)->first();
 
       DB::beginTransaction();
      
       try{
 
         if(!empty($saved_photo)){
           $file_name = $saved_photo->file_name;
           $this->deleteFile('reward/'.$file_name);
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
