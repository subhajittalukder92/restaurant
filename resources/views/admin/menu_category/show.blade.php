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
                        <form action="" method="POST" class="join-now-form">
                        
                     
                        <div class="row">
                          <div class="col-md-12 padd-10">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="name" class="form-control" placeholder="Enter Name" id="name" name ='name' value="{{$serviceCategory->name}}" readonly>
                            </div>
                          </div>
                          <div class="col-md-12 padd-10">
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea rows="2" cols="40" class="form-control" placeholder="Enter description" id="description" name="description" readonly>{{$serviceCategory->description}}</textarea>      
                                @error('description')
                                        <div class="alert alert-danger alert-danger-margin">{{ $message }}</div>
                                @enderror
                            </div>
                          </div>
                          <div class="col-md-12 padd-10">
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select class="form-control" name="status" disabled>
                                  <option @if($serviceCategory->status == 'active') selected="" @endif value="active">Active</option>
                                  <option @if($serviceCategory->status == 'inactive') selected="" @endif value="inactive">Inactive</option>
                                </select>
                            </div>
                        </div> 
                        
                       
                        <div class="col-md-12 padd-10">
                            <div class="joun-button">
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