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
            <form action="{{ route('admin.slider.store') }}" method="post" class="join-now-form" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                        <div class="col-md-12 padd-10" >
                        <div class="form-group">
                            <label for="photos">Slider Position</label>
                              <select class="form-control" name="position">
                                <option value="top">Top</option>
                                <option value="middle">Middle</option>
                                <option value="bottom">Bottom</option>
                              </select>
                                @error('position')
                                    <div class="alert alert-danger alert-danger-margin">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12 padd-10" >
                        <div class="form-group">
                            <label for="photos">Upload Images</label>
                              <input class="form-control photo-upload" type="file" name="photos" id="photos">
                                @error('photos')
                                    <div class="alert alert-danger alert-danger-margin">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12 padd-10">
                            <div class="joun-button">
                                <button class="custom-button btn btn-primary">Submit</button>
                                <a href="{{ route('admin.slider.index') }}" class="btn btn-primary">Cancel</a>
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