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
               <form action="{{route('admin.reward.update',$rewards->id)}}" method="POST" class="join-now-form" enctype="multipart/form-data">
                        {{csrf_field()}}

                        {{ method_field('PUT')}}
                     
                    <div class="row">
                    <div class="col-md-12 padd-10">
                            <div class="form-group">
                                <label for="name">Coin</label>
                                <input type="text" class="form-control" placeholder="Enter No of Coin" id="coins" name ='coins' value="{{$rewards->coins}}">
                                @error('coins')
                                    <div class="alert alert-danger alert-danger-margin">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12 padd-10">
                          <div class="form-group">
                            <label for="price">Amount</label>
                            <input type="number" step="0.01" class="form-control" placeholder="Enter amount" id="amount" name="amount" value="{{$rewards->amount}}">
                            @error('amount')
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
                                      <button type="button" class="delete-itemreward-image-btn" id="{{$value['id']}}">×</button>
                                      <img src="{{url('storage/reward/'.$value['name'])}}" style="width:75px; height:75px;"/>
                                    <span>
                                    </div>
                                @endforeach  
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
                                <a href="{{ route('admin.reward.index') }}" class="btn btn-primary">Cancel</a>
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

