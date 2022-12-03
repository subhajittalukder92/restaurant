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
                    <form action="{{ route('admin.menu-category.store') }}" method="post" class="join-now-form" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                          <div class="col-md-12 padd-10">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="name" class="form-control" placeholder="Enter Name" id="name" name ='name' value="">
                                @error('name')
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
                                  <option selected="active" value="active">Active</option>
                                  <option value="inactive">Inactive</option>
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