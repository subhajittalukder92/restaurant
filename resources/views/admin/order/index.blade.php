@extends('admin.layouts.backend')

@section('content')
@if(session('success'))
  <div class="alert alert-success" role="alert">
  {{session('success')}}
  </div>
@endif

 <div class="container" >
  <div class="row">
      <div class="col-md-2"><b>From Date</b></div>
      <div class="col-md-2">
        <input type="date" name="fromDate" id="fromDate" class="form-control">
      </div>
      <div class="col-md-2"><b>To date</b></div>
      <div class="col-md-2">
        <input type="date" name="toDate" id="toDate" class="form-control" >
      </div>
      <div class="col-md-4">
        <button type="button" name="search" id="search" class="btn btn-success">Search</button>
      </div>
  </div>
</div>
<br/>
 
<div class="table-responsive">
<table id="example" class="table table-hover responsive nowrap" style="width:100%">
  <thead>
    <tr>
      
      <th scope="col">Date</th>
      <th scope="col">Order No.</th>
      <th scope="col">Name</th>
      <th scope="col">Phone</th>
      <th scope="col">Total Amount</th>
      <th scope="col">Order Status</th>
      <th scope="col">Address</th>
      <th scope="col" >Action </th>
    </tr>
  </thead>
  <tbody>
      @foreach($orders as $key => $itemData)
          <tr class="custom-table-row" data-url="">
          
             <td>{{\App\Utils\Helper::formatDateTime($itemData->created_at, 12)}}</td>
             <td>{{$itemData->order_no}}</td>
             <td>{{\App\Utils\Helper::getUser($itemData->user_id)->name}}</td>
             <td>{{\App\Utils\Helper::getUser($itemData->user_id)->mobile}}</td>
             
             <td>₹ {{$itemData->total_amount}}</td>
             @if ($itemData->status == "Pending")
              <td><span class="badge badge-primary">{{ $itemData->status }}</span></td>
             @elseif ($itemData->status == "Out for delivery")
              <td><span class="badge badge-warning">{{ $itemData->status }}</span></td>
             @elseif ($itemData->status == "Delivered")
              <td><span class="badge badge-success">{{ $itemData->status }}</span></td>
             @elseif ($itemData->status == "Not delivered")
              <td><span class="badge badge-danger">{{ $itemData->status }}</span></td>
             @endif
             <td>{{ $itemData->delivery_address }}
            </td>
             <td>
              <a href="{{ route('admin.orders.show', $itemData->id) }}"
                title="Show Order Details" class="cmn-btn btn_blue"><button class="">View</button></a>
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

  $('#search').on('click', function(e){
    if($('#fromDate').val() != "" && $('#toDate').val() != ""){
    $.ajax({
        url: "{{ route('admin.orders.search') }}",
        type: "POST",
        data:{
        _token: "{{ csrf_token() }}",
         fromDate: $('#fromDate').val(),
         toDate:   $('#toDate').val(),
        },
        success: function(response) {
          if(response.length > 0){
            let tr = '';
            let addrs = "{{ route('admin.orders.show', ':id') }}";
            for(var i = 0; i < response.length; i++)
						{
              addrs = addrs.replace(":id", response[i].id);
              tr +='<tr>'+
                          '<td>'+response[i].date+'</td>'+
                          '<td>'+response[i].order_no+'</td>'+
                          '<td>'+response[i].name+'</td>'+
                          '<td>'+response[i].mobile+'</td>'+
                          '<td>₹ '+response[i].total_amount+'</td>'+
                          '<td>'+getStatus(response[i].status)+'</td>'+
                          '<td>'+response[i].delivery_address+'</td>'+
                          '<td> <a href="'+addrs+'" title="Show Order Details" class="cmn-btn btn_blue"><button class="">View</button></a></td>'+
                    '</tr>'
               
            }
            $('#example').DataTable().destroy();
            $('#example tbody').html(tr);
            $('#example').DataTable({
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
                }).draw();
          }
          else{
            $('#example tbody').html("");
          

          }  
        },
        error: function(xhr) {
           
        }
    });
    }else{
      alert("From date & to date is required");
    }
  });
  function getStatus(status)
  {
    let data = status;
    if (status == "Pending"){
      data = '<span class="badge badge-primary">'+status+'</span>';
    }
    else if (status == "Out for delivery"){
      data = '<span class="badge badge-warning">'+status+'</span>';
    }
    else if (status == "Delivered"){
      data = '<span class="badge badge-success">'+status+'</span>';
    }
    else if (status == "Not delivered"){
      data = '<span class="badge badge-danger">'+status+'</span>';
    }
    return data ;
  
  }
});


</script>
@endsection
