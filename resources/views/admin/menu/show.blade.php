@extends('admin.layouts.backend')

@section('content')

<section class="profile-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="profile-about-box">  
                 <div class="profile-content">
                    <div class="row">
                        <div class="col-md-12 padd-10">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" placeholder="Enter Name" id="name" name ='name' value="{{$services->name}}" readonly>
                            </div>
                        </div>
                        <div class="col-md-12 padd-10">
                            <div class="form-group">
                                <label for="price">Price</label>
                                <input type="number" class="form-control" placeholder="Enter price" id="price" name="price" value="{{$services->price}}" readonly>
                            </div>
                        </div>

                        <div class="col-md-12 padd-10">
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea rows="2" cols="40" class="form-control" placeholder="Enter description" id="description" name="description" readonly>{{$services->description}}</textarea>
                            </div>
                        </div>
                        <div class="col-md-12 padd-10">
                            <div class="form-group">
                                <label for="name">Veg/Non Veg</label>
                                <select class="form-control" name="menu_type" disabled>
                                  <option selected="" disabled="">Select Menu Type </option>
                                  <option value="veg" @if($menus->menu_type == 'veg') selected="" @endif>Veg </option>
                                  <option value="non-veg" @if($menus->menu_type == 'non-veg') selected="" @endif>Non Veg </option>
                                </select>
                                @error('menu_type')
                                    <div class="alert alert-danger alert-danger-margin">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12 padd-10">
                            <div class="form-group">
                                <label for="name">offer</label>
                                <select class="form-control" name="discount_type" id="offer" disabled>
                                  <option selected="" disabled="">Select offer </option>
                                  <option value="percent" @if($menus->discount_type == 'percent') selected="" @endif>Percent(%) </option>
                                  <option value="flat" @if($menus->discount_type == 'flat') selected="" @endif>Flat Discount </option>
                                </select>
                                @error('discount_type')
                                    <div class="alert alert-danger alert-danger-margin">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12 padd-10 dis_val" @if($menus->discount_type == '') style="display:none" @endif>
                            <div class="form-group">
                                <label for="name">Offer Value</label>
                                <input type="text" class="form-control" placeholder="Enter offer Value" id="offer_value" name ='discount' value="{{$menus->discount}}" readonly>
                                @error('discount')
                                    <div class="alert alert-danger alert-danger-margin">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12 padd-10">
                            <div class="form-group">
                              <label for="category_id">Service Category</label>
                                <select class="form-control" name="category_id" disabled>
                                 <option selected="" disabled="">Select Service Category </option>
                                  @foreach($categories as $key => $value)
                                    <option value="{{$value['id']}}" @if($value['id'] == $services->category_id) selected="" @endif>{{$value['name']}}</option>
                                  @endforeach
                                </select>
                                @error('category_id')
                                        <div class="alert alert-danger alert-danger-margin">{{ $message }}</div>
                                @enderror
                            </div>
                        </div> 

                        <div class="col-md-12 padd-10">
                          <label for="photos">Old Images</label>
                          <div class="old-images">
                                @foreach($medias as $value)
                                    <div class="form-group">
                                    <img src="{{url('storage/services/'.$value)}}" style="width:75px; height:75px;"/>
                                    </div>
                                @endforeach  
                          </div> 
                        </div>
                        <div class="col-md-12 padd-10">
                            <div class="form-group">
                                <label for="name">Status</label>
                                <select class="form-control" name="status" disabled>
                                  <option value="active" @if($menus->status == 'active') selected="" @endif>Active </option>
                                  <option value="inactive" @if($menus->status == 'inactive') selected="" @endif>Inactive </option>
                                </select>
                                @error('status')
                                    <div class="alert alert-danger alert-danger-margin">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12 padd-10">
                            <div class="joun-button">
                            <a href="{{ route('admin.services.index') }}" class="btn btn-primary">Cancel</a>
                            </div>
                        </div>
                     </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
        </div>
    </section>

@endsection