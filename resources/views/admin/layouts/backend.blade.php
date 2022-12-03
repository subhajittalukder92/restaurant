<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="description" content="" >
    <meta name="author" content="">
    <meta name="keywords" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!--Meta Responsive tag-->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!--Favicon Icon-->
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <!--Bootstrap CSS-->
    <link rel="stylesheet" href="{{asset('assets/admin/css/bootstrap.min.css')}}">
    <!--Custom style.css-->
    <link rel="stylesheet" href="{{asset('assets/admin/css/style.css')}}">
    <!--Font Awesome-->
    <link rel="stylesheet" href="{{asset('assets/admin/css/fontawesome-all.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/admin/css/fontawesome.css')}}">
    <!--Animate CSS-->
    <link rel="stylesheet" href="{{asset('assets/admin/css/animate.min.css')}}">
    <!--Nice select -->
    <link rel="stylesheet" href="{{asset('assets/admin/css/nice-select.css')}}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css">
    <title>{{ config('app.name') }} | Admin</title>
  </head>
  <body>
    <!--Page loader-->
    <div class="loader-wrapper">
        <div class="loader-circle">
            <div class="loader-wave"></div>
        </div>
    </div>
    <!--Page loader-->
    
    <!--Page Wrapper-->

    <div class="container-fluid">

        <!--Header-->
        <div class="row header shadow-sm">
        
            
            <!--Logo-->
            <div class="col-sm-4 col-md-4 col-lg-2 pl-0 text-center header-logo">
               <div class="bg-theme mr-3 pt-3 pb-2 mb-0">
                    <!-- <h3 class="logo"><a href="#" class="text-secondary logo"><i class="fa fa-rocket"></i> Admin Panel</a></h3> -->
                    <h3 class="logo"><img class="admin-logo" src="{{asset('images/logo.png')}}" alt="Bluedot"></h3>
                   
               </div>
            </div>
            <!--Logo-->

            <!--Header Menu-->
            <div class="col-sm-8 col-md-8 col-lg-10 header-menu pt-2 pb-0">
                <div class="row">
                    
                    <!--Menu Icons-->
                    <div class="col-sm-4 col-8 pl-0">
                        <!--Toggle sidebar-->
                        <span class="menu-icon" onclick="toggle_sidebar()">
                            <span id="sidebar-toggle-btn"></span>
                        </span>
                        <!--Toggle sidebar-->
                    </div>
                    <!--Menu Icons-->

                    <!--Search box and avatar-->
                    <div class="col-sm-8 col-4 text-right flex-header-menu justify-content-end align-items-center">
                        <div class="menu_button mr-4"><a href="{{route('admin.order.index')}}">Orders</a></div>
                        <div class="mr-4">
                            <a class="" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="{{asset('assets/images/user_icon.png')}}" alt="Adam" class="rounded-circle" width="40px" height="40px">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right mt-13" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="{{route('admin.profile.edit')}}"><i class="fa fa-user pr-2"></i> Profile</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{!! url('/admin/logout') !!}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-sign-out pr-2"></i>Log Out</a>
                                <form id="logout-form" action="{!! url('/admin/logout') !!}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </div>
                        </div>
                    </div>
                    <!--Search box and avatar-->
                </div>    
            </div>
            <!--Header Menu-->
        </div>
        <!--Header-->


        <!--- Main Body -->
        <div class="row main-content">
            <!--Sidebar left-->
            @include('admin.layouts.sidebar')
            <!--Sidebar left-->

            <!--Content right-->
            <div class="col-sm-10 col-xs-12 content pt-3 pl-0">
                @yield('content')
            </div>
        </div>
        <!--- Main Body -->


        <!--Footer-->
        <div class="row mt-2 mb-2 footer">
            <div class="col-sm-12 text-center">
                <span>&copy; All rights reserved <?php echo date('Y') ?> designed by <a class="text-theme" href="https://webappssol.com/" target="_blank">webappsSOL</a></span>
            </div>
        </div>
        <!--Footer-->

        </div>
    </div>

        <!--Main Content-->

</div>

    <!--Page Wrapper-->

    <!-- Page JavaScript Files-->
    <script src="{{asset('assets/admin/js/jquery.min.js')}}"></script>
    <script src="{{asset('assets/admin/js/jquery-1.12.4.min.js')}}"></script>
    <!--Popper JS-->
    <script src="{{asset('assets/admin/js/popper.min.js')}}"></script>
    <!--Bootstrap-->
    <script src="{{asset('assets/admin/js/bootstrap.min.js')}}"></script>
    <!--Sweet alert JS-->
    <script src="{{asset('assets/admin/js/sweetalert.js')}}"></script>
    <!--Progressbar JS-->
    <script src="{{asset('assets/admin/js/progressbar.min.js')}}"></script>
    <!--Nice select-->
    <script src="{{asset('assets/admin/js/jquery.nice-select.min.js')}}"></script>

    <!--Custom Js Script-->
    <script src="{{asset('assets/admin/js/custom.js')}}"></script>
    <script src="{{asset('assets/admin/js/admin.js')}}"></script>
    <!--Custom Js Script-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script>
        //Nice select
        $('.bulk-actions').niceSelect();
    </script>
    <script>
       $("#price").blur(function(){
          let price =  Number.parseFloat($("#price").val());
          let sale_price = Number.parseFloat($("#sale_price").val());

          if(price >= sale_price){
            $("#price").val('');
          }
       });

       $("#sale_price").blur(function(){
          let price =  Number.parseFloat($("#price").val());
          let sale_price = Number.parseFloat($("#sale_price").val());

          if(price >= sale_price){
            $("#sale_price").val('');
          }
       });

       $('.delete-item-image-btn').click(function(){
        let id = $(this).attr('id');

                swal({
                title: "Are you sure to delete the image?",
                //text: "You will not be able to recover this imaginary file!",
                icon: "warning",
                buttons: [
                    'No',
                    'Yes'
                ],
                dangerMode: true,
                }).then(function(isConfirm) {
                if (isConfirm) {
                    $.ajax({
                    url: "{{url('/admin/menus/delete-menu-image')}}",
                    type: "POST",
                    data:{
                    _token: "{{ csrf_token() }}",
                    image_id: id,
                    },
                    success: function(response) {
                      if(response == 'success'){
                        $('#image-div-' + id).hide();
                         swal({
                                text: "Image is Deleted Succesfully",
                                icon: "success",
                         });
                      }  
                    },
                    error: function(xhr) {
                        swal({
                                text: "Image not Deleted Succesfully",
                        });
                    }
                });
                }
            });
      });
      $('.delete-item-cat-image-btn').click(function(){
        let id = $(this).attr('id');

                swal({
                title: "Are you sure to delete the image?",
                icon: "warning",
                buttons: [
                    'No',
                    'Yes'
                ],
                dangerMode: true,
                }).then(function(isConfirm) {
                if (isConfirm) {
                    $.ajax({
                    url: "{{url('/admin/menu-category/delete-menucat-image')}}",
                    type: "POST",
                    data:{
                    _token: "{{ csrf_token() }}",
                    image_id: id,
                    },
                    success: function(response) {
                      if(response == 'success'){
                        $('#image-div-' + id).hide();
                         swal({
                                text: "Image is Deleted Succesfully",
                                icon: "success",
                         });
                      }  
                    },
                    error: function(xhr) {
                        swal({
                                text: "Image not Deleted Succesfully",
                        });
                    }
                });
                }
            });
      });

      $('.delete-itemslider-image-btn').click(function(){
        let id = $(this).attr('id');

                swal({
                title: "Are you sure to delete the image?",
                icon: "warning",
                buttons: [
                    'No',
                    'Yes'
                ],
                dangerMode: true,
                }).then(function(isConfirm) {
                if (isConfirm) {
                    $.ajax({
                    url: "{{url('/admin/slider/delete-slider-image')}}",
                    type: "POST",
                    data:{
                    _token: "{{ csrf_token() }}",
                    image_id: id,
                    },
                    success: function(response) {
                      if(response == 'success'){
                        $('#image-div-' + id).hide();
                         swal({
                                text: "Image is Deleted Succesfully",
                                icon: "success",
                         });
                      }  
                    },
                    error: function(xhr) {
                        swal({
                                text: "Image not Deleted Succesfully",
                        });
                    }
                });
                }
            });
      });
      $('.delete-itemreward-image-btn').click(function(){
        let id = $(this).attr('id');

                swal({
                title: "Are you sure to delete the image?",
                icon: "warning",
                buttons: [
                    'No',
                    'Yes'
                ],
                dangerMode: true,
                }).then(function(isConfirm) {
                if (isConfirm) {
                    $.ajax({
                    url: "{{url('/admin/reward/delete-reward-image')}}",
                    type: "POST",
                    data:{
                    _token: "{{ csrf_token() }}",
                    image_id: id,
                    },
                    success: function(response) {
                      if(response == 'success'){
                        $('#image-div-' + id).hide();
                         swal({
                                text: "Image is Deleted Succesfully",
                                icon: "success",
                         });
                      }  
                    },
                    error: function(xhr) {
                        swal({
                                text: "Image not Deleted Succesfully",
                        });
                    }
                });
                }
            });
      });

    </script>

     @yield('script')
  </body>
</html>