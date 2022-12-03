@extends('admin.layouts.backend')

@section('content')

<section class="profile-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                     <div class="profile-about-box">  
                        <div class="profile-content">
                          @if(session('success'))
                            <div class="alert alert-success" role="alert">
                                {{session('success')}}
                            </div>
                          @endif
               <form action="{{route('admin.menus.update',$menus->id)}}" method="POST" class="join-now-form" enctype="multipart/form-data">
                        {{csrf_field()}}

                        {{ method_field('PUT')}}
                     
                    <div class="row">
                        <div class="col-md-12 padd-10">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" placeholder="Enter Name" id="name" name ='name' value="{{$menus->name}}">
                                @error('name')
                                    <div class="alert alert-danger alert-danger-margin">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12 padd-10">
                            <div class="form-group">
                                <label for="price">Price</label>
                                <input type="number" step="0.01" class="form-control" placeholder="Enter price" id="price" name="price" value="{{$menus->price}}">
                                @error('price')
                                    <div class="alert alert-danger alert-danger-margin">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12 padd-10">
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea rows="2" cols="40" class="form-control" placeholder="Enter description" id="description" name="description">{{$menus->description}}</textarea>
                                @error('description')
                                        <div class="alert alert-danger alert-danger-margin">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12 padd-10">
                            <div class="form-group">
                                <label for="name">Veg/Non Veg</label>
                                <select class="form-control" name="menu_type">
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
                                <select class="form-control" name="discount_type" id="offer">
                                  <option selected="" disabled="">Select offer </option>
                                  <option selected="" value="">No offer </option>
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
                                @if($menus->discount_type == '')
                                  <input type="text" class="form-control" placeholder="Enter offer Value" id="offer_value" name ='discount' value="">
                                @else
                                <input type="text" class="form-control" placeholder="Enter offer Value" id="offer_value" name ='discount' value="{{$menus->discount}}">
                                @endif  
                                @error('discount')
                                    <div class="alert alert-danger alert-danger-margin">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12 padd-10">
                            <div class="form-group">
                              <label for="category_id">Service Category</label>
                                <select class="form-control" name="category_id">
                                 <option selected="" disabled="">Select Service Category </option>
                                  @foreach($categories as $key => $value)
                                    <option value="{{$value['id']}}" @if($value['id'] == $menus->category_id) selected="" @endif>{{$value['name']}}</option>
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
                                    <div class="form-group" id="{{'image-div-'.$value['id']}}">
                                    <span class="delete-item-image">
                                      <button type="button" class="delete-item-image-btn" id="{{$value['id']}}">×</button>
                                      <img src="{{url('storage/menus/'.$value['name'])}}" style="width:75px; height:75px;"/>
                                    <span>
                                    </div>
                                @endforeach  
                          </div> 
                        </div>

                        <div class="col-md-12 padd-10" >
                            <div class="form-group">
                                <label for="photos">Upload Images</label>
                                <input class="form-control photo-upload" type="file" name="photos[]" id="photos" multiple>
                                @error('photos')
                                  <div class="alert alert-danger alert-danger-margin">{{ $message }}</div>
                                 @enderror
                            </div>
                        </div>
                        <div class="col-md-12 padd-10">
                            <div class="form-group">
                                <label for="name">Status</label>
                                <select class="form-control" name="status">
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
                                <button class="custom-button btn btn-primary">Submit</button>
                                <a href="{{ route('admin.menus.index') }}" class="btn btn-primary">Cancel</a>
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

@section('script')
<script>
  $(document).ready(function(){
    $('#offer').on('change',function(){
      if($(this).val() != ''){
        $('.dis_val').show();
      }else{
        $('.dis_val').hide();
      }
    });
  });

</script>
@endsection