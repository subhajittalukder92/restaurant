@extends('admin.layouts.backend')

@section('content')

<section class="profile-section">
    <!-- <div class="container">
       <div class="row">
         <div class="col-md-12">
            <div class="profile-about-box"> 
                <div class="profile-content">
                    <div class="row">
                         <div class="col-md-6">
                                <h4 style="font-size:12px;"><b>Order Id :</b> {{ $order->id }}</h4>
                                @if(!empty($order->delivery_address))
                                  <h4 style="font-size:12px;"><b>Delivered To :</b> {{ $order->delivery_address }}</h4>
                                @else
                                  <h4 style="font-size:12px;"><b>Delivered To :</b></h4>
                                @endif
                                  <h4 style="font-size:12px;"><b>Status :</b> {{ $order->status }}</h4>
                          </div>
                          <div class="col-md-3">
                               <h4 style="font-size:12px;"><b>Date &amp; Time :</b> {{ \Helper::formatDateTime($order->created_at, 13) }}</h4>
                               <h4 style="font-size:12px;"><b>Contact No. :</b> {{ $order->user->mobile }}</h4>
                          </div>
                          <div class="col-md-3">
                                <button id="kot_print_btn" class="custom-button btn btn-primary order-items-print">KOT Print</button>
                                <button id="invoice_print_btn" class="custom-button btn btn-primary order-items-print">Invoice Print</button>
                          </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <p style="font-size:15px;margin-top:10px;"><b>Order Details :</b></p>
                        </div>
                    </div>
                    <div class="table-responsive">
                      <table id="example" class="table table-hover responsive nowrap" style="width:100%;margin-top:20px;">
                            <thead>
                                <tr>
                                    <th scope="col">Item</th>
                                    <th scope="col">Qty</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order_items as $key => $item)
                                  <tr>
                                    @if(!empty($item->menu))
                                        <td>{{$item->menu->name}}</td>
                                    @else
                                        <td></td>
                                    @endif
                                        <td>{{$item->quantity}}</td>
                                        <td>{{$item->price}}</td>
                                        <td>{{$item->total}}</td>
                                 </tr>
                                @endforeach
                             </tbody>
                      </table>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <p class="order-items"><b>Sub Total {{$order->sub_total}}</b></p>
                            <p class="order-items"><b>Discount {{ $order->discount_amount }}</b></p>
                            <p class="order-items"><b>Total {{$order->total_amount}}</b></p>
                        </div>
                     </div>
                </div>
            </div>
         </div>
      </div>
    </div> -->
    <div class="container" >
        <div class="row">
            <table class="table table-sm table-borderless">
                <tr>
                    <td><b>Transaction Id</b></td>
                    <td>{{ $order->txn_id }}</td>
                    <td> <b> Transaction Status <b></td>
                    <td>{{ $order->txn_status }}</td>
                </tr>
                <tr> 
                    <td><b>Order No</b></td>
                    <td># {{ $order->order_no }}</td>
                    <td><b>Payment Mode</b></td>
                    <td>{{ $order->payment_mode }}</td>
                   
                </tr>
            </table>
        </div>
    </div>
    <br/>

     <div class="row">
       <div class="col-md-6" style="max-width:500px;" id="DivKotToPrint">
          <div class="row">
                       <!-- <div class="col-md-6"><h4>Order Details</h4></div> -->
                        
                        <div class="col-md-12">
                          <div class="row">
                                <div class="col-md-12">
                                    <button id="kot_print_btn" class="custom-button btn btn-primary order-items-print">KOT Print</button>
                                    <p class="order-kot-content"><b>Order No: </b> {{ $order->order_no }} </p>
                                    <p class="order-kot-content"><b>Date &amp; Time :</b> {{ \Helper::formatDateTime($order->created_at, 13) }}</p>
                                    <!-- <p class="order-kot-content"><b>Email : </b> @if($order->user->email) {{ $order->user->email }} @endif</p> -->
                                </div>
                           </div>
                           <div class="table-responsive">
                              <table id="example" class="table table-hover responsive nowrap" style="width:100%;margin-top:20px;">
                                <thead>
                                    <tr>
                                        <th scope="col">Item</th>
                                        <th scope="col">Qty</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order_items as $key => $item)
                                        <tr>
                                        @if(!empty($item->menu))
                                            <td>{{$item->menu->name}}</td>
                                        @else
                                            <td></td>
                                        @endif
                                            <td>{{$item->quantity}}</td>
                                        </tr>

                                    @endforeach
                                 </tbody>
                              </table>
                            </div>
                        </div>
                     </div>

      </div>

      <div class="col-md-6" style="max-width: 500px;" id="DivInvoiceToPrint">
      <div class="row">
        <!-- <h4>Order Details</h4> -->
       
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                <button id="invoice_print_btn" class="custom-button btn btn-primary order-items-print">Invoice Print</button>
                <p class="order-kot-content"><b>Order No: </b> {{ $order->order_no }} </p>
                    <p class="order-kot-content"><b>Date &amp; Time :</b> {{ \Helper::formatDateTime($order->created_at, 13) }}</p>
                    <p class="order-kot-content"><b>Name: </b> {{ $order->user->name }}</p>
                    <p class="order-kot-content"><b>Mobile #: </b> {{ $order->user->mobile }} </p>
                    <p class="order-kot-content">{{ $order->delivery_address }} </p>
                    <!-- <p class="order-kot-content"><b>Email : </b> @if($order->user->email) {{ $order->user->email }} @endif</p> -->
                </div>
            </div>
            <div class="table-responsive">
                <table id="example" class="table table-hover responsive nowrap" style="width:100%;margin-top:20px;">
                    <thead>
                        <tr>
                            <th scope="col">Item</th>
                            <th scope="col">Qty</th>
                            <th scope="col">Price</th>
                            <th scope="col">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order_items as $key => $item)
                            <tr>
                            @if(!empty($item->menu))
                                <td>{{$item->menu->name}}</td>
                            @else
                                <td></td>
                            @endif
                                <td>{{$item->quantity}}</td>
                                <td>{{$item->price}}</td>
                                <td>{{$item->total}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                </table>
            </div>
            <div class="row" >
                <div class="col-md-12" style="text-align:right;">
                    <p class="order-kot-content" style="text-align:right;"><b>Sub Total: {{ $billing_total }}</b></p>
                    <p class="order-kot-content" style="text-align:right;"><b>Discount: {{ $total_discount }}</b></p>
                    @if ($order->discount_amount)
                    <p class="order-kot-content" style="text-align:right;"><b>Reward Redeem: {{ $order->discount_amount }}</b></p> 
                    @endif
                    <p class="order-kot-content" style="text-align:right;"><b>Delivery Charge: {{ $order->delivery_charge }}</b></p>
                    <p class="order-kot-content" style="text-align:right;"><b>Total: {{$order->total_amount}}</b></p>
                    <p style="text-align:center;"><img id="barcode_image" src="{{$barcode}}"/></p>
                </div>
            </div>
          </div>
        </div>
     </div>


     </div>



    
    
</section>

@endsection
