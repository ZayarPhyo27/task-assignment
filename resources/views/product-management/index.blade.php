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
        </div>
         <div class="col-3">
        </div>

        <div class="col-3" style="text-align: right;">
            <a class="btn bg-gradient-dark mb-0" href="products/create"><i class="material-icons text-sm">add</i>&nbsp;&nbsp;Add New
                Product</a>
        </div>


        <div class="col-12 my-4">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                    <h6 class="text-white text-capitalize ps-3">Product List Table</h6>
                </div>
                </div>
                <div class="card-body px-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0 data-table">
                    <thead>
                        <tr>
                        <th> No</th>
                        <th>Image</th>
                        <th>Name</th>
                         <th>Quantity</th>

                        <th>Description</th>
                         <th>Color</th>
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
                   ajax: "{{ url('products') }}",
                   columns: [
                       {data: 'DT_RowIndex', name: 'DT_RowIndex', class : 'data-index'},
                       {data: 'image', name: 'image'},
                       {data: 'name', name: 'name'},
                       {data: 'qty', name: 'qty'},
                       {data: 'description', name: 'description'},
                       {data: 'color', name: 'color'},

                       {data: 'action', name: 'action', orderable: false, searchable: false, className :'action-col'},
                   ]
                 });

      $('.list-search').on( 'keyup', function () {
           table.search( this.value ).draw();
       } );

       $('.list-search').on( 'search', function () {
           table.search( this.value ).draw();
       } );





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
