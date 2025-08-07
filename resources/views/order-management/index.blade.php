@extends('layout.app')
@section('main-content')
<div class="container-fluid py-4">
    <div class="row mx-4">
        <div class="col-3">
            <div class="search-input">
                <input type="search" class=" list-search" placeholder=" Search in the list" id="search_L" style="height: 35px;width: 100%;">
            </div>
        </div>

        <div class="col-3">
            <select class=" select2 faq-filter-select2 order_status" style="width: 100%;">
                <option value=""></option>
                @foreach (config("web_constant.get_order_status") as $k => $t)
                    <option value="{{$k}}">{{$t}}</option>
                @endforeach
            </select>
        </div>

        <div class="col-3">
        </div>

        {{-- <div class="col-3" style="text-align: right;">
            <a class="btn bg-gradient-dark mb-0" href="orders/create"><i class="material-icons text-sm">add</i>&nbsp;&nbsp;Add New
                order</a>
        </div> --}}


        <div class="col-12 my-4">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                    <h6 class="text-white text-capitalize ps-3">Order List Table</h6>
                </div>
                </div>
                <div class="card-body px-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0 data-table">
                    <thead>
                        <tr>
                        <th> No</th>
                        <th>Name</th>
                        <th>Phone Number</th>
                        <th>Address</th>
                        <th>Status</th>
                        <th>Order Date</th>
                        <th>Action </th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                    </table>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
      var table = $('.data-table').DataTable({
                   paging: true,
                   lengthChange: false,
                   searching: true,
                   ordering: false,
                   info: false,
                   autoWidth: true,
                   responsive: true,
                   processing: true,
                   serverSide: true,
                   ajax: "{{ url('orders') }}",
                   columns: [
                       {data: 'DT_RowIndex', name: 'DT_RowIndex', class : 'data-index'},
                       {data: 'customer_name', name: 'customer_name'},
                       {data: 'customer_phone', name: 'customer_phone'},
                       {data: 'customer_address', name: 'customer_address'},
                       {data: 'status', name: 'status' },
                       {data: 'created_at', name: 'created_at' },
                       {data: 'action', name: 'action', orderable: false, searchable: false, className :'action-col'},
                   ]
                 });

      $('.list-search').on( 'keyup', function () {
           table.search( this.value ).draw();
       } );

       $('.list-search').on( 'search', function () {
           table.search( this.value ).draw();
       } );
       $('.order_status').select2({ placeholder : "Filter By Status", allowClear : true});


      $(document).on('change','.order_status',function(){
                   searchFun();
           });

      function searchFun(){
      var order_status = $('.order_status').val();

      table.ajax.url("{{ url('orders')}}"+"?status="+order_status).load();
      }


      $(document).on('click','.delete-data',function(){
        let action = $(this).attr('action');

        let msg = '';
        let method = '';
        if($(this).hasClass('delete-data')){
            msg = "Are you sure you want to delete?";
            method = "DELETE";
        }

        $('#confirm-modal .confirm-message').html(msg);
        $('#confirm-modal .modal-footer #confirm-form').find('input[name=_method]').val(method);

        $('#confirm-modal .modal-footer #confirm-form').attr('action',action);
        $('#confirm-modal').modal('show');
    });

    });





  </script>
@endsection
