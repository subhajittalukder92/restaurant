@extends('admin.layouts.backend')

@section('content')
@if(session('success'))
  <div class="alert alert-success" role="alert">
  {{session('success')}}
  </div>
@endif

<div class="table-responsive">
<table id="example" class="table table-hover responsive nowrap" style="width:100%">
  <thead>
    <tr>
      <th scope="col">Created At</th>
      <th scope="col">Name</th>
      <th scope="col">Email</th>
      <th scope="col">Address</th>
      <th scope="col">Phone</th>
    </tr>
  </thead>
  <tbody>
      @foreach($users as $key => $user)
          <tr >
             <td>{{\Helper::formatDateTime($user->created_at, 12)}}</td>
             <td>{{$user->name}}</td>
             <td>{{$user->email}}</td>
             @if(!empty($user->addresses))
              <td>
                  @foreach($user->addresses as $key => $value)
                    {{ $value['name'].', '.$value['street'].', '.$value['landmark'].', '.$value['city'].
                      ', '.$value['state'].', '.$value['zipcode'].', '.$value['country']}}<br>
                  @endforeach
               </td>
             @else
             <td></td>
             @endif
             <td><a target="_blank" href="{{'https://api.whatsapp.com/send?phone=+'.$user->mobile.'&text=Hi%20requesting%20a%20callback.%20Thanks'}}">{{$user->mobile}}</a></td>
          </tr>

      @endforeach
  </tbody>
</table>
</div>
@endsection

@section('script')
<script>
$(document).ready(function() {
  $("#example").DataTable({
    aaSorting: [],
    responsive: true,
    language: { search: "" },

    columnDefs: [
      {
        responsivePriority: 1,
        targets: 0
      },
      {
        responsivePriority: 2,
        targets: -1
      },


    ]
  });

  $(".dataTables_filter input")
    .attr("placeholder", "Search here...")
    .css({
      width: "300px",
      display: "inline-block"
    });

  $('[data-toggle="tooltip"]').tooltip();

});
</script>
@endsection
