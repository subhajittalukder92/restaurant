@extends('admin.layouts.backend')

@section('content')
@if(session('success'))
  <div class="alert alert-success" role="alert">
  {{session('success')}}
  </div>
@endif

 <div class="page-header float-left trn-list">
        <a href="{{ route('admin.delivery-boys.create') }}">

            <button type="button" class="btn btn-success" style="margin-bottom: 15px;">
              <i class="fa fa-plus-circle"></i> Add New</button>
        </a>

    </div>

<div class="table-responsive">
<table id="example" class="table table-hover responsive nowrap" style="width:100%">
  <thead>
    <tr>
      <th scope="col">Created At</th>
      <th scope="col">Name</th>
      <th scope="col">Email</th>
      <th scope="col">Phone</th>
      <th scope="col" >Action </th>
    </tr>
  </thead>
  <tbody>
      @foreach($users as $key => $user)
          <tr>
             <td>{{\Helper::formatDateTime($user->created_at, 12)}}</td>
             <td>{{$user->name}}</td>
             <td>{{$user->email}}</td>
             <td><a target="_blank" href="{{'https://api.whatsapp.com/send?phone=+'.$user->mobile.'&text=Hi%20requesting%20a%20callback.%20Thanks'}}">{{$user->mobile}}</a></td>
             <td>
              <a href="{{ route('admin.delivery-boys.edit', $user->id) }}"
                title="Edit Item Categories" class="cmn-btn btn_blue"><button class=""><i class="fa fa-edit"></i></button></a>
              
                <form method="POST" id="delete-form-{{ $user->id }}" action="{{ route('admin.delivery-boys.destroy', $user->id) }}" style="display: none;">
                    {{ csrf_field() }}
                    {{ method_field('delete') }}
                </form>
                <button onclick="if (confirm('Are you sure to delete this data?')) {
                    event.preventDefault();
                    document.getElementById('delete-form-{{ $user->id }}').submit();

                }else{
                    event.preventDefault();
                }

                " class="btn delete-button" href=" "><i class="fas fa-trash"></i>
            </button>
            </td>
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
