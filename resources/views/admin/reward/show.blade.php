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
                                <label for="name">Coin</label>
                                <input type="text" class="form-control" placeholder="Enter No of Coin" id="coin" name ='coin' value="{{$rewards->coin}}" readonly>
                                
                            </div>
                        </div>
                        <div class="col-md-12 padd-10">
                          <div class="form-group">
                            <label for="price">Amount</label>
                            <input type="number" step="0.01" class="form-control" placeholder="Enter amount" id="amount" name="amount" value="{{$rewards->amount}}" readonly>
                            
                          </div>
                        </div>
                        <div class="col-md-12 padd-10">
                          <label for="photos">Old Images</label>
                          <div class="old-images">
                                @foreach($medias as $value)
                                    <div class="form-group">
                                    <img src="{{url('storage/reward/'.$value)}}" style="width:75px; height:75px;"/>
                                    </div>
                                @endforeach  
                          </div> 
                        </div>

                        <div class="col-md-12 padd-10">
                            <div class="joun-button">
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