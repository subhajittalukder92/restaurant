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
            <form action="{{ route('admin.menus.store') }}" method="post" class="join-now-form" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                          <div class="col-md-12 padd-10">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" placeholder="Enter Name" id="name" name ='name' value="">
                                @error('name')
                                    <div class="alert alert-danger alert-danger-margin">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12 padd-10">
                          <div class="form-group">
                            <label for="price">Price</label>
                            <input type="number" step="0.01" class="form-control" placeholder="Enter price" id="price" name="price" value="">
                            @error('price')
                                <div class="alert alert-danger alert-danger-margin">{{ $message }}</div>
                            @enderror
                          </div>
                        </div>

                        <div class="col-md-12 padd-10">
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea rows="2" cols="40" class="form-control" placeholder="Enter description" id="description" name="description"></textarea>      
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
                                  <option value="veg">Veg </option>
                                  <option value="non-veg">Non Veg </option>
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
                                  <option value="percent">Percent(%) </option>
                                  <option value="flat">Flat Discount </option>
                                </select>
                                @error('discount_type')
                                    <div class="alert alert-danger alert-danger-margin">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12 padd-10 dis_val" style="display:none">
                            <div class="form-group">
                                <label for="name">Offer Value</label>
                                <input type="text" class="form-control" placeholder="Enter offer Value" id="offer_value" name ='discount' value="">
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
                                    <option value="{{$value['id']}}">{{$value['name']}}</option>
                                  @endforeach
                                </select>
                                @error('category_id')
                                        <div class="alert alert-danger alert-danger-margin">{{ $message }}</div>
                                @enderror
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
                                  <option value="active">Active </option>
                                  <option value="inactive">Inactive </option>
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