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
               <form action="{{route('admin.zipcodes.update',$zipcodes->id)}}" method="POST" class="join-now-form" enctype="multipart/form-data">
                        {{csrf_field()}}

                        {{ method_field('PUT')}}
                     
                    <div class="row">
                    <div class="col-md-12 padd-10" >
                        <div class="form-group">
                            <label for="photos">Zipcode</label>
                            <input type="text" name="zipcode" id="zipcode" class="form-control" value="{{ $zipcodes->zipcode}}">
                                @error('zipcode')
                                    <div class="alert alert-danger alert-danger-margin">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12 padd-10">
                            <div class="joun-button">
                                <button class="custom-button btn btn-primary">Submit</button>
                                <a href="{{ route('admin.zipcodes.index') }}" class="btn btn-primary">Cancel</a>
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

