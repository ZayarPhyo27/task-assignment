<!DOCTYPE html>
<html lang="en">
    <head>
        @include('layout.header')
    </head>

    <body class="g-sidenav-show  bg-gray-200">
        @include('layout.side-bar')

        <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
                @include('layout.nav-bar')
                @yield('main-content')

        </main>
            @include('layout.footer')



        <!-- The confirm modal Start -->
        <div class="modal fade custom-view-modal" id="confirm-modal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content" style="width:100%!important;">
                    <div class="modal-header">
                        <h5 class="modal-title">Confirm</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span class="modal-close-btn" aria-hidden="true">&#x2715</span>
                        </button>
                    </div>
                    <div class="modal-body view-modal-body" >
                        <h5 class="confirm-message">Are you sure you want to delete?</h5>
                    </div>
                    <div class="modal-footer bg-gray-light text-center">
                        <form action="" method="post" id="confirm-form">
                            @method('DELETE')
                            @csrf

                            <a class="btn btn-success bg-blue dark-text save-btn confirm-delete-button">Sure</a>
                            <a class="btn btn-danger cancel-btn" data-dismiss="modal">Cancel</a>

                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- The confirm modal End -->
    </body>

</html>
<script>
    $(document).on('click','.save-btn',function(){
        $(this).addClass('disabled');
        $(this).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> processing...');
        $(this).parent().submit();
    });
    $(document).on('click','.close, .cancel-btn',function(){
       $('#confirm-modal').modal('hide');
    });


</script>
