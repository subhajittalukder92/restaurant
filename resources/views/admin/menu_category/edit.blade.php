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
                        <form action="{{route('admin.menu-category.update',$menuCategory->id)}}" method="POST" class="join-now-form" enctype="multipart/form-data">
                        {{csrf_field()}}

                        {{ method_field('PUT')}}
                     
                        <div class="row">
                        <div class="col-md-12 padd-10">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="name" class="form-control" placeholder="Enter Name" id="name" name ='name' value="{{$menuCategory->name}}">
                                @error('name')
                                    <div class="alert alert-danger alert-danger-margin">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12 padd-10">
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea rows="2" cols="40" class="form-control" placeholder="Enter description" id="description" name="description">{{$menuCategory->description}}</textarea>      
                                @error('description')
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
                                      <button type="button" class="delete-item-cat-image-btn" id="{{$value['id']}}">×</button>
                                      <img src="{{url('storage/menus_category/'.$value['name'])}}" style="width:75px; height:75px;"/>
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
                                <label for="status">Status</label>
                                <select class="form-control" name="status">
                                  <option @if($menuCategory->status == 'active') selected="" @endif value="active">Active</option>
                                  <option @if($menuCategory->status == 'inactive') selected="" @endif value="inactive">Inactive</option>
                                </select>
                            </div>
                        </div> 
                        
                       
                        <div class="col-md-12 padd-10">
                            <div class="joun-button">
                                <button class="custom-button btn btn-primary">Submit</button>
                                <a href="{{ route('admin.menu-category.index') }}" class="btn btn-primary">Cancel</a>
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