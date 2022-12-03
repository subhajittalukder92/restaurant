<?php

namespace App\Http\Controllers\API\App\Customer\Address;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\AddressRepository;
use App\Repositories\ZipCodeRepository;
use App\Http\Controllers\AppBaseController;
use Prettus\Repository\Criteria\RequestCriteria;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use App\Http\Resources\API\App\Customer\AddressCollection;
use App\Http\Criteria\API\App\Customer\Address\AddressCriteria;
use App\Http\Requests\API\App\Customer\Address\CreateAddressApiRequest;
use App\Http\Requests\API\App\Customer\Address\UpdateAddressApiRequest;


class AddressApiController extends AppBaseController
{
    protected $addressRepository;
    protected $zipRepository;

    public function __construct(AddressRepository $address, ZipCodeRepository $zipcode)
    {
        $this->addressRepository = $address;
        $this->zipRepository = $zipcode;
    }

    /**
    *   @OA\Get(
    *     path="/api/app/customer/addresses",
    *      tags={"Customer App: All Addresses"}, 
    *       @OA\Response(
    *           response=200,
    *           description="Success",
    *            @OA\MediaType(
    *               mediaType="application/json",
    *           )
    *       ),
    * )
    */
    public function index(Request $request){
        $this->addressRepository->pushCriteria(new RequestCriteria($request));
        $this->addressRepository->pushCriteria(new LimitOffsetCriteria($request));
        $this->addressRepository->pushCriteria(new AddressCriteria($request));
        $items = $this->addressRepository->paginate($request->limit);
        
        return $this->sendResponse(['item'=> AddressCollection::collection($items), 'total' => $items->total()], '');
    }


    // Store Address

	/**
    *   @OA\Post(
    *     path="/api/app/customer/addresses",
	*      tags={"Customer App: Store Address"}, 
	*       @OA\Parameter(
    *           name="user_id",
    *           in="query",
    *           required=true,
    *           @OA\Schema(
    *               type="integer"
    *           )
    *       ),
	*       @OA\Parameter(
    *           name="name",
    *           in="query",
    *           required=true,
    *           @OA\Schema(
    *               type="string"
    *           )
    *       ),
	*       @OA\Parameter(
    *           name="street",
    *           in="query",
    *           required=true,
    *           @OA\Schema(
    *               type="string"
    *           )
	*       ),
	*       @OA\Parameter(
    *           name="landmark",
    *           in="query",
    *           required=true,
    *           @OA\Schema(
    *               type="string"
    *           )
	*       ),
	*       @OA\Parameter(
    *           name="city",
    *           in="query",
    *           required=true,
    *           @OA\Schema(
    *               type="string"
    *           )
	*       ),
	*       @OA\Parameter(
    *           name="state",
    *           in="query",
    *           required=true,
    *           @OA\Schema(
    *               type="string"
    *           )
	*       ),
	*       @OA\Parameter(
    *           name="zipcode",
    *           in="query",
    *           required=true,
    *           @OA\Schema(
    *               type="string"
    *           )
	*       ),
	*       @OA\Parameter(
    *           name="country",
    *           in="query",
    *           required=true,
    *           @OA\Schema(
    *               type="string"
    *           )
	*       ),
	*       @OA\Parameter(
    *           name="contact",
    *           in="query",
    *           required=true,
    *           @OA\Schema(
    *               type="digit"
    *           )
	*       ),
    *       @OA\Response(
    *           response=200,
    *           description="Success",
    *            @OA\MediaType(
    *               mediaType="application/json",
    *           )
    *       ),
    * )
	*/
    public function store(CreateAddressApiRequest $request){
        $data = $this->zipRepository->checkZipcodeStatus($request);
        if(count($data) == 0){
            return $this->sendError($this->getLangMessages('Sorry, service not available in this zipcode.', 'Address'));
        }
        $address =  $this->addressRepository->createAddress($request);
        
        return $this->sendResponse($address->toArray(), $this->getLangMessages('admin/messages.store_success', 'Address'));

    }


    /**
    * @OA\Get(
    *     path="/api/app/customer/addresses/{id}",
    *      tags={"Customer App: Show Specific Address"},
    *
    *       @OA\Response(
    *           response=200,
    *           description="Success",
    *            @OA\MediaType(
    *               mediaType="application/json",
    *           )
    *       ),
    *       @OA\Response(
    *           response=401,
    *           description="Failure"
    *       )
    *
    * )
    */
    public function show($id, Request $request){
        $address = $this->addressRepository->findWithoutFail($id);
        if (empty($address)) {
            return $this->sendError($this->getLangMessages('admin/messages.not_found', 'Address'));
        }

        return $this->sendResponse($address->toArray(), $this->getLangMessages('admin/messages.retrieve_success', 'Address'));
    }


	// Edit Address

	/**
    *   @OA\Put(
    *     path="/api/app/customer/addresses/{id}",
	*      tags={"Customer App: Edit Address"}, 
	*       @OA\Parameter(
    *           name="user_id",
    *           in="query",
    *           required=true,
    *           @OA\Schema(
    *               type="integer"
    *           )
    *       ),
	*       @OA\Parameter(
    *           name="name",
    *           in="query",
    *           required=true,
    *           @OA\Schema(
    *               type="string"
    *           )
    *       ),
	*       @OA\Parameter(
    *           name="street",
    *           in="query",
    *           required=true,
    *           @OA\Schema(
    *               type="string"
    *           )
	*       ),
	*       @OA\Parameter(
    *           name="landmark",
    *           in="query",
    *           required=true,
    *           @OA\Schema(
    *               type="string"
    *           )
	*       ),
	*       @OA\Parameter(
    *           name="city",
    *           in="query",
    *           required=true,
    *           @OA\Schema(
    *               type="string"
    *           )
	*       ),
	*       @OA\Parameter(
    *           name="state",
    *           in="query",
    *           required=true,
    *           @OA\Schema(
    *               type="string"
    *           )
	*       ),
	*       @OA\Parameter(
    *           name="zipcode",
    *           in="query",
    *           required=true,
    *           @OA\Schema(
    *               type="string"
    *           )
	*       ),
	*       @OA\Parameter(
    *           name="country",
    *           in="query",
    *           required=true,
    *           @OA\Schema(
    *               type="string"
    *           )
	*       ),
	*       @OA\Parameter(
    *           name="contact",
    *           in="query",
    *           required=true,
    *           @OA\Schema(
    *               type="digit"
    *           )
	*       ),
    *       @OA\Response(
    *           response=200,
    *           description="Success",
    *            @OA\MediaType(
    *               mediaType="application/json",
    *           )
    *       ),
    * )
	*/
    public function update($id, UpdateAddressApiRequest $request){
        $address = $this->addressRepository->findWithoutFail($id);
        if (empty($address)) {
            return $this->sendError($this->getLangMessages('admin/messages.not_found', 'Address'));
        }
        $data = $this->zipRepository->checkZipcodeStatus($request);
        if(count($data) == 0){
            return $this->sendError($this->getLangMessages('Sorry, service not available in this zipcode.', 'Address'));
        }
        $address = $this->addressRepository->updateAddress($id, $request);
        
        return $this->sendResponse($address->toArray(), $this->getLangMessages('admin/messages.update_success', 'Address'));
    }


    /**
    * @OA\Delete(
    *     path="/api/app/customer/addresses/{id}",
    *      tags={"Customer App: Delete Address"},
    *
    *       @OA\Response(
    *           response=200,
    *           description="Success",
    *            @OA\MediaType(
    *               mediaType="application/json",
    *           )
    *       ),
    *       @OA\Response(
    *           response=401,
    *           description="Failure"
    *       )
    *
    * )
    */
    public function destroy($id, Request $request){
        $address = $this->addressRepository->findWithoutFail($id);
        if (empty($address)) {
            return $this->sendError($this->getLangMessages('admin/messages.not_found', 'Address'));
        }
       
        $address->delete();
        return $this->sendResponse($id, $this->getLangMessages('admin/messages.delete_success', 'Address'));
    }

}
