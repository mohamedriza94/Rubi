@extends('layouts.business')

@section('content')

{{-- breadcrumb --}}
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">{{ $title }}</h4>
    </div>
    <div class="col-md-7 align-self-center text-end">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb justify-content-end">
                <li class="breadcrumb-item"><a href="{{ route('rubi.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">{{ $title }}</li>
            </ol>
            </div>
        </div>
    </div>
    
    {{-- content --}}
    <div class="row">

        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        
                        <div class="col-4">
                            <button id="btnPayrollSort" class="btn btn-success">Show Payroll Expense</button>
                            <button id="btnPettyExpenseSort" class="btn btn-danger">Show Petty Expenses</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title" id="dataCount"></h4>
                    <div class="table-responsive">
                        <table class="table color-table purple-table">
                            <thead>
                                <tr>
                                    <th>Business</th>
                                    <th>Type</th>
                                    <th>Product</th>
                                    <th>Country</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="businessTable">
                            </tbody>
                        </table> 
                        
                        <div class="btn-group m-b-10 m-r-10">
                            <button id="btnPrev" class="btn btn-outline-dark"><i class="fas fa-angle-double-left"></i></button>
                            <button id="btnNext" class="btn btn-outline-dark"><i class="fas fa-angle-double-right"></i></button>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    {{-- Modals --}}
    {{-- view modal --}}
    <div class="modal bs-example-modal-lg animated fadeIn" id="viewModal" tabindex="-1" aria-hidden="true" style="display:none;">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">View Business</h4>
                    <button class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    
                                    <div class="row">
                                        
                                        <div class="form-group col-3">
                                            <img style="width: 100px; border-radius:50px;" class="form-control" id="businessLogo">
                                        </div>

                                        <div class="form-group col-9">
                                            <label class="form-label" id="registeredOn">Registered On</label>
                                        </div>
                                        
                                        <div class="form-group col-3">
                                            <label class="form-label">No</label>
                                            <input readonly class="form-control" id="no">
                                        </div>

                                        <div class="form-group col-3">
                                            <label class="form-label">Status</label>
                                            <input readonly class="form-control" id="status">
                                        </div>

                                        <div class="form-group col-3">
                                            <label class="form-label">Verified On</label>
                                            <input readonly class="form-control" id="verifiedOn">
                                        </div>

                                        <div class="form-group col-12">
                                            <label class="form-label">Name</label>
                                            <input readonly class="form-control" id="name">
                                        </div>
                                        
                                        <div class="form-group col-3">
                                            <label class="form-label">Type</label>
                                            <input readonly class="form-control" id="type">
                                        </div>
                                        
                                        <div class="form-group col-3">
                                            <label class="form-label">Product</label>
                                            <input readonly class="form-control" id="product">
                                        </div>
                                        
                                        <div class="form-group col-6">
                                            <label class="form-label">Email</label>
                                            <input readonly class="form-control" id="email">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    
    @endsection
    
    
    
    
    
    @section('script')
    <script>
        $(document).ready(function(){
            
            var status = 'all'; //for sorting
            var url = "{{ url('rubi/dashboard/readBusinesses/:limit/:status') }}";
            function configureUrl()
            {
                var length = $('#searchBusinesses').val().length;
                if (length == 0) {
                    url = "{{ url('rubi/dashboard/readBusinesses/:limit/:status') }}";
                    url = url.replace(':limit', limit);
                    url = url.replace(':status', status);
                }
            }
            
            //configuration to limit the number of messages displayed
            var limit = 0;
            $(document).on('click', '#btnNext', function(e) {
                limit = limit + 12; readBusinesses();
            });
            $(document).on('click', '#btnPrev', function(e) {
                limit = limit - 12; if(limit < 0) { limit = 0; } readBusinesses();
            });
            
            readBusinesses();
            
            //read packages
            function readBusinesses()
            {
                configureUrl();
                $.ajax({
                    type: "GET", url:url, dataType:"json",
                    success:function(response){
                        $('#businessTable').html(''); 
                        
                        $.each(response.data,function(key,item){

                            //display badges
                            var status_badge = ''; var status_button = '';
                            
                            //sorting STATUS
                            switch(item.status) {
                                case 'active':
                                status_badge = '<span class="label label-success">Active</span>'; //ACTIVE
                                status_button = '<button id="btnChangeStatus" value="'+item.id+'" class="btn btn-danger">Deactivate</button>';
                                break;
                                case 'inactive':
                                status_badge = '<span class="label label-danger">Inactive</span>'; //INACTIVE
                                status_button = '<button id="btnChangeStatus" value="'+item.id+'" class="btn btn-success">Activate</button>';
                                break;
                            }

                            $('#businessTable').append('<tr>\
                                <td><img style="width:30px; border-radius:10px;" class="m-r-10" src="'+item.photo+'">'+item.name+'</td>\
                                <td>'+item.type+'</td>\
                                <td>'+item.product+'</td>\
                                <td>'+item.country+'</td>\
                                <td>'+status_badge+'</td>\
                                <td>\
                                    <div class="btn-group m-b-10 m-r-10">\
                                        '+status_button+'\
                                        <button id="btnView" value="'+item.id+'" class="btn btn-dark"><i class="fas fa-eye"></i></button>\
                                    </div>\
                                </td>\
                                </tr>'); 
                            });
                        }
                    });
            }
            
            //search business
            $(document).on('keyup', '#searchBusinesses', function(e) {
                url = "{{ url('rubi/dashboard/searchBusinesses/:search/:limit/:status') }}";
                url = url.replace(':search', $(this).val());
                url = url.replace(':limit', limit);
                url = url.replace(':status', status);
                readBusinesses();
            });

            //Update status
            $(document).on('click', '#btnChangeStatus', function(e) {
                e.preventDefault();
                var id = $(this).val();
                var data = { 'id':id }
                $.ajax({
                    type:"PUT",
                    url: "{{ url('rubi/dashboard/updateBusinessStatus') }}",
                    data:data,
                    dataType:"json",
                    success: function(response){
                        if(response.status == 400)
                        {
                            toastType = 'error'; toastMessage = response.message; showToast(); //TOAST ALERT
                            readBusinesses();
                        }
                        else if(response.status == 200)
                        {
                            toastType = 'success'; toastMessage = response.message; showToast(); //TOAST ALERT
                            readBusinesses();
                        }
                    }
                });
            });

            //sort
            $(document).on('click', '#btnActive', function(e){
                status = 'active'; readBusinesses();
            });
            $(document).on('click', '#btnInactive', function(e){
                status = 'inactive'; readBusinesses();

            });
            $(document).on('click', '#btnAll', function(e){
                status = 'all'; readBusinesses();
            });
            
            //View
            $(document).on('click', '#btnView', function(e){
                e.preventDefault();
                var id = $(this).val(); //get message id
                var urlView = '{{ url("rubi/dashboard/readOneBusiness/:id") }}'; urlView = urlView.replace(':id', id);
                $.ajax({
                    type:"GET", url:urlView, dataType:"json",
                    success: function(response)
                    {
                        formatTime(response.data.created_at);

                        $('#viewModal').modal('show');  //OPEN MODAL
                        $('#no').val(response.data.no);
                        $('#status').val(response.data.status);
                        $('#registeredOn').html('Registered On: <b>'+date+time+'</b>');
                        $('#verifiedOn').val(response.data.verifiedDate);
                        $('#name').val(response.data.name);
                        $('#type').val(response.data.type);
                        $('#product').val(response.data.product);
                        $('#email').val(response.data.email);
                        $('#businessLogo').attr('src', response.data.photo);
                    }
                });
            });
        });
    </script>
    @endsection