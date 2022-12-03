@extends('admin.layouts.backend')

@section('content')
@if(session('success'))
  <div class="alert alert-success" role="alert">
  {{session('success')}}
  </div>
@endif

<div class="container" >
  <div class="row">
      <div class="col-md-2"><b>Search Date</b></div>
      <div class="col-md-2">
        <input type="date" name="date" id="date" value="{{ date('Y-m-d') }}" class="form-control">
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
      <th scope="col">Payment Mode</th>
      <th scope="col">Name</th>
      <th scope="col">Phone</th>
      <th scope="col">Address</th>
      <th scope="col">Total Price</th>
      <th scope="col">Txn Status</th>
      <th scope="col">Txn id</th>
     
    </tr>
  </thead>
  <tbody>
      @foreach($orders as $key => $itemData)
          <tr class="custom-table-row" data-url="">
             <td>Today</td>
             <td>{{$itemData->order_no}}</td>
             @if(!empty($itemData->payment_mode))
               @if($itemData->payment_mode == 'cash_payment')
                 <td>Cash</td>
               @elseif($itemData->payment_mode == 'online_payment')
                <td>Online</td>
               @else
                <td></td>
               @endif
             @else
              <td></td>
             @endif   
             <td>{{\App\Utils\Helper::getUser($itemData->user_id)->name}}</td>
             <td>{{\App\Utils\Helper::getUser($itemData->user_id)->mobile}}</td>
             <td>{{ $itemData->delivery_address }}
             </td>
             <td>{{ $itemData->total_amount }}</td>
             <td>{{ $itemData->txn_status }}</td>
             <td>{{ $itemData->txn_id }}</td>
          </tr>

      @endforeach
  </tbody>
</table>
</div>
<br/>
<table cellpadding="10" cellspacing="10" style="width:30%;margin: 0px -7px;">
      <tr>
        <td><b> Total Sell</b></td>
        <td id="totalSale">{{ \Helper::twoDecimalPoint($total_sale) }}</td>
      </tr>
      <tr>
        <td><b> Upi Sell</b></td>
        <td id="onlineSale">{{ \Helper::twoDecimalPoint($online_sale) }}</td>
      </tr>
      <tr>
        <td><b> Cash Sell</b></td>
        <td id="cashSale"> {{ \Helper::twoDecimalPoint($cash_sale) }}</td>
      </tr>
    
</table>
<br/>
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
    if($('#date').val() != ""){
    $.ajax({
        url: "{{ route('admin.payment.history.search') }}",
        type: "POST",
        data:{
        _token: "{{ csrf_token() }}",
         date: $('#date').val(),
        
        },
        success: function(response) {
          if(response.orders.length > 0){
            let tr = '';
            for(var i = 0; i < response.orders.length; i++)
						{
            
              tr +='<tr>'+
                          '<td>'+response.orders[i].date+'</td>'+
                          '<td>'+response.orders[i].order_no+'</td>'+
                          '<td>'+response.orders[i].payment_mode+'</td>'+
                          '<td>'+response.orders[i].name+'</td>'+
                          '<td>'+response.orders[i].mobile+'</td>'+
                          '<td>'+response.orders[i].delivery_address+'</td>'+
                          '<td>'+response.orders[i].total_amount+'</td>'+
                          '<td>'+response.orders[i].txn_id+'</td>'+
                          '<td>'+response.orders[i].txn_status+'</td>'+
                   '</tr>'
               
            }
            $('#example').DataTable().destroy();
            $('#example tbody').show();
            $('#example tbody').html(tr);
            $('#cashSale').html(response.cash_sale);
            $('#totalSale').html(response.total_sale);
            $('#onlineSale').html(response.upi_sale);
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
        
            $('#example tbody').hide();
            $('#cashSale').text("");
            $('#totalSale').text("");
            $('#onlineSale').text("");
          }  
        },
        error: function(xhr) {
           
        }
    });
    }else{
      alert("Date field is required");
    }
  });  
});
</script>
@endsection
