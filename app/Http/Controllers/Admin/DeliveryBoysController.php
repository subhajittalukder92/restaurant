<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\API\Admin\DeliveryBoy\CreateDeliveryBoyRequest;
use App\Http\Requests\API\Admin\DeliveryBoy\UpdateDeliveryBoyRequest;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Validator;

class DeliveryBoysController extends Controller
{
    private $userRepository;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepository = $userRepo;
    }

    public function index(Request $request){
        $role_id = \Helper::deliveryBoyRoleId();
        $users = $this->userRepository->where('role_id', $role_id)->orderBy('id', 'DESC')->get();

        return view('admin.delivery-boys.index', ['users' => $users]);
    }

    /**
     * Show the form for creating a new Delivery Boy.
     *
     * @return Response
     */
    public function create()
   {
       return view('admin.delivery-boys.create');
   }
    /**
     * Store a newly created Delivery Boy.
     *
     * @param CreateDeliveryBoyRequest $request
     *
     * @return Response
     */
    public function store(CreateDeliveryBoyRequest $request)
    {
        $input = collect($request->all());
        $values = $input->only($request->fillable('delivery_boy'))->all();
        $values['role_id'] = \Helper::deliveryBoyRoleId();
        $values['password'] = Hash::make($request->password);

        $validator =  Validator::make($request->all(),[]);

        $exisiting_email = null;
        $otherRoleIds = [\Helper::superAdminRoleId(), \Helper::adminRoleId(), \Helper::managerRoleId()];
      
        if(!empty($request->email)){
          $exisiting_email = $this->userRepository->where('email', $request->email)
          ->whereIn('role_id', $otherRoleIds)->first();
        }

        $exisiting_mobile = $this->userRepository->where('mobile', $request->mobile)
                                 ->whereIn('role_id', $otherRoleIds)->first();
                          
        if(!empty($exisiting_email)){
           $validator->errors()->add('email', 'This email is already exists.');
        }   
        
        if(!empty($exisiting_mobile)){
          $validator->errors()->add('mobile', 'This mobile is already exists.');
        }   
  
       $messages = $validator->messages();
       $message_count = count($messages->toArray());
  
       if($message_count > 0){
          return redirect()->back()->withErrors($messages)->withInput($values); 
       }
      
        DB::beginTransaction();
        
        try{
          $deliveryBoy = $this->userRepository->create($values);
          
          DB::commit();
       
          return redirect()->route('admin.delivery-boys.index')->with("success","Delivery Boy added successfully");
          
        }catch(\Exception $e){ 
          DB::rollBack();
          return redirect()->route('admin.delivery-boys.index')->with("success","Delivery Boy does not created due to some error !!");
        }
				
    }

    /**
     * Display the specified Delivery Boy.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $deliveryBoy = $this->userRepository->find($id);
       
        if (!$deliveryBoy) {
            
            return redirect()->route('admin.delivery-boys.index')->with("success","Delivery Boy not found");
        }
        return view('admin.delivery-boys.show')->with('deliveryBoy', $deliveryBoy);
    }


    /**
     * Show the form for editing the specified Delivery Boy.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
      $deliveryBoy = $this->userRepository->find($id);
               
      if (!$deliveryBoy) {
          return redirect()->route('admin.delivery-boys.index')->with("success","Delivery Boy not found");
      }
        return view('admin.delivery-boys.edit')->with('deliveryBoy', $deliveryBoy);
    }

      /**
     * Update the specified Delivery Boy in storage.
     *
     * @param  int $id
     * @param UpdateDeliveryBoyRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateDeliveryBoyRequest $request)
    {
      $deliveryBoy = $this->userRepository->find($id);
    
      if (!$deliveryBoy) {
        return redirect()->route('admin.delivery-boys.index')->with("success","Delivery Boy not found");
      }

      $input = collect($request->all()); 
      $values = $input->only($request->fillable('delivery_boy'))->all();
      $values['role_id'] = \Helper::deliveryBoyRoleId();

      if($request->password){
        $values['password'] = Hash::make($request->password);
      }
      else{
        unset($values['password']);
      }

      $validator =  Validator::make($request->all(),[]);

      $exisiting_email = null;
      $otherRoleIds = [\Helper::superAdminRoleId(), \Helper::adminRoleId(), \Helper::managerRoleId()];
    
      if(!empty($request->email)){
        $exisiting_email = $this->userRepository->where('email', $request->email)
        ->where('id', '!=', $id)->whereIn('role_id', $otherRoleIds)->first();
      }

      $exisiting_mobile = $this->userRepository->where('mobile', $request->mobile)
       ->where('id', '!=', $id)->whereIn('role_id', $otherRoleIds)->first();
                        
      if(!empty($exisiting_email)){
         $validator->errors()->add('email', 'This email is already exists.');
      }   
      
      if(!empty($exisiting_mobile)){
        $validator->errors()->add('mobile', 'This mobile is already exists.');
     }   

     $messages = $validator->messages();
     $message_count = count($messages->toArray());

     if($message_count > 0){
        return redirect()->back()->withErrors($messages)->withInput($values); 
     }
     
      DB::beginTransaction();
      
      try{
        $this->userRepository->update($values, $id);
      
        DB::commit();
        
        return redirect()->route('admin.delivery-boys.index')->with("success","Delivery Boy updated successfully.");
        
      }catch(\Exception $e){ 
        DB::rollBack();
        
        return redirect()->route('admin.delivery-boys.index')->with("success","Delivery Boy does not updated due to some error !!.");
      }
    }

     /**
     * Remove the specified Delivery Boy from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
      $deliveryBoy = $this->userRepository->find($id);
     
      if (!$deliveryBoy) {
        return redirect()->route('admin.delivery-boys.index')->with("success","Delivery Boy not found.");
      }
			DB::beginTransaction();
			
			try{
				
        $this->userRepository->delete($id);

				DB::commit();
			
        return redirect()->route('admin.delivery-boys.index')->with("success","Delivery Boy deleted successfully.");
				
			}catch(\Exception $e){
				DB::rollBack();
				
        return redirect()->route('admin.delivery-boys.index')->with("success","Delivery Boy does not deleted due to some error !!");
			}
    }
}
