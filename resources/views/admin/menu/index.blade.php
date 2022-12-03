@extends('admin.layouts.backend')

@section('content')
@if(session('success'))
  <div class="alert alert-success" role="alert">
  {{session('success')}}
  </div>
@endif

        <div class="page-header float-left trn-list">
            <a href="{{ route('admin.menus.create') }}">

                <button type="button" class="btn btn-success" style="margin-bottom: 15px;">
                  <i class="fa fa-plus-circle"></i> Add New</button>
            </a>
        </div>


<div class="table-responsive">
<table id="example" class="table table-hover responsive nowrap" style="width:100%">
  <thead>
    <tr>
      
      <th scope="col">Name</th>
      <th scope="col">Price</th>
      <th scope="col">Veg / Non Veg</th>
      <th scope="col">Discount Type</th>
      <th scope="col">Discount</th>
      <th scope="col">Status</th>
      <th scope="col" >Action </th>
    </tr>
  </thead>
  <tbody>
      @foreach($menus as $key => $itemData)
          <tr class="custom-table-row" data-url="{{ route('admin.menus.show', $itemData->id) }}">
          
             <td>{{$itemData->name}}</td>
             <td>{{$itemData->price}}</td>
             <td>{{ucfirst($itemData->menu_type)}}</td>
             <td>{{ucfirst($itemData->discount_type)}}</td>
             <td>{{$itemData->discount}}</td>
             <td>{{$itemData->status}}</td>
             <td>
             <a href="{{ route('admin.menus.edit', $itemData->id) }}"
              title="Edit Trainer" class="cmn-btn btn_blue"><button class=""><i class="fa fa-edit"></i></button></a>
             
              <form method="POST" id="delete-form-{{ $itemData->id }}" action="{{ route('admin.menus.destroy', $itemData->id) }}" style="display: none;">
                  {{ csrf_field() }}
                  {{ method_field('delete') }}
              </form>
              <button onclick="if (confirm('Are you sure to delete this data?')) {
                  event.preventDefault();
                  document.getElementById('delete-form-{{ $itemData->id }}').submit();

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

  $('.custom-table-row').on("click", function() {
    //window.location = $(this).data("url");
  });   
});
</script>
@endsection
