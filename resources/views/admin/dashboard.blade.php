
@extends('admin.layouts.backend')

@section('content')
@if(session('success'))
  <div class="alert alert-success" role="alert">
  {{session('success')}}
  </div>
@endif

<div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info dashboard-box">
              <div class="inner">
                <h3>{{$user_count}}</h3>

                <p>New Users</p>
              </div>
              <div class="icon">
              <i class="ion ion-stats-bars"></i>
              </div>
              <a  href="{{route('admin.customers.index')}}" class="small-box-footer dashboard-link">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success dashboard-box">
              <div class="inner">
                <h3>{{$menu_count}}</h3>

                <p>Menus</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="{{route('admin.menus.index')}}" class="small-box-footer dashboard-link">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          {{-- <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning dashboard-box">
              <div class="inner">
                <h3>{{$menucat_count}}</h3>

                <p>Menu Category</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="{{route('admin.menu-category.index')}}" class="small-box-footer dashboard-link">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div> --}}
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger dashboard-box">
              <div class="inner">
                <h3>{{$slider_count}}</h3>

                <p>Sliders</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="{{route('admin.slider.index')}}" class="small-box-footer dashboard-link">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->

          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning dashboard-box">
              <div class="inner">
                <h3>{{$reward_count}}</h3>

                <p>Rewards</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="{{route('admin.reward.index')}}" class="small-box-footer dashboard-link">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          
        </div>
        <br/>
        <div class="row">
        
        </div>
        
@endsection

@section('script')
<script>

</script>
@endsection