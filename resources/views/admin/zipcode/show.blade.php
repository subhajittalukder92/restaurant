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
                          <label for="photos">Old Images</label>
                          <input type="text" name="zipcode" id="zipcode" class="form-control" value="{{ $zipcodes->zipcode}}">
                            
                        </div>

                        <div class="col-md-12 padd-10">
                            <div class="joun-button">
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