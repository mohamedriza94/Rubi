@extends('layouts.sub')

@section('content')

{{-- breadcrumb --}}
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">{{ $title }}</h4>
    </div>
    <div class="col-md-7 align-self-center text-end">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb justify-content-end">
                <li class="breadcrumb-item"><a href="{{ route('sub.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">{{ $title }}</li>
            </ol>
        </div>
    </div>
</div>

{{-- content --}}

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <button data-bs-toggle="modal" data-bs-target="#viewModal" class="btn btn-primary text-white">
                    <i class="fa fa-plus-circle"></i> 
                    Record an Expense
                </button><hr>
                    <div class="table-responsive">
                        <table class="text-center table color-table red-table">
                            <thead>
                                <tr class="text-uppercase">
                                    <th>No.</th>
                                    <th>Purpose</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody id="table">
                            </tbody>
                        </table> 
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    {{-- Modals --}}
    {{-- create modal --}}
    <div class="modal bs-example-modal-sm animated fadeIn" id="viewModal" tabindex="-1" aria-hidden="true" style="display:none;">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">Petty Expense</h4>
                    <button class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <form class="row" id="createForm" enctype="multipart/form-data" method="post">
                                        <div class="form-group col-12">
                                            <label class="form-label">Purpose</label>
                                            <input class="form-control" name="purpose">
                                        </div>
                                        
                                        <div class="form-group col-12">
                                            <label class="form-label">Note</label>
                                            <textarea class="form-control" rows="3" name="note"></textarea>
                                        </div>
                                        
                                        <div class="form-group col-12">
                                            <label class="form-label">Amount (LKR)</label>
                                            <input class="form-control" name="amount">
                                        </div>
                                        
                                        <div class="col-12">
                                            <div class="d-md-flex align-items-center">
                                                <button type="submit" id="btnCreate" class="col-12 btn btn-info">Record</button>
                                            </div>
                                        </div>
                                    </form>
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
            
            var url = "{{ url('sub/dashboard/readExpenses') }}";
            function configureUrl()
            {
                url = "{{ url('sub/dashboard/readExpenses') }}";
            }
            
            readExpenses();
            
            //read notes
            function readExpenses()
            {
                configureUrl();
                $.ajax({
                    type: "GET", url:url, dataType:"json",
                    success:function(response){
                        $('#table').html(''); 
                        
                        $.each(response.data,function(key,item){
                            
                            //format time
                            formatTime(item.created_at);
                            
                            $('#table').append('<tr>\
                                <td>'+item.no+'</td>\
                                <td>'+item.purpose+'</td>\
                                <td> LKR '+item.amount+'</td>\
                                <td>'+date+''+time+'</td>\
                            </tr>'); 
                        });
                    }
                });
            }
            
            //Create
            $(document).on('click', '#btnCreate', function(e) {
                e.preventDefault();
                
                $("#btnCreate").prop("disabled", true).text("Recording Expense...");
                
                let formData = new FormData($('#createForm')[0]);
                $.ajax({
                    type: "POST", url: "{{ url('sub/dashboard/recordExpense') }}",
                    data: formData, contentType:false, processData:false,
                    success: function(response){
                        if(response.status==800)
                        {
                            $.each(response.errors,function(key,error)
                            {
                                toastMessage = '';
                                toastType = 'error'; toastMessage += error; showToast(); //TOAST ALERT
                            });
                            
                            $("#btnCreate").prop("disabled", false).text("Record");
                        }
                        else if(response.status == 400 || response.status == 600)
                        {
                            $("#btnCreate").prop("disabled", false).text("Record");
                            toastType = 'error'; toastMessage = response.message; showToast(); //TOAST ALERT
                        }
                        else if(response.status == 200)
                        {
                            $("#btnCreate").prop("disabled", false).text("Record");
                            $('#createForm')[0].reset(); //FORM RESET INPUT
                            readExpenses();
                            
                            Swal.fire({ title: 'Success', text: "Expense Recorded",
                            icon: 'success', confirmButtonColor: '#3085d6', confirmButtonText: 'OK' });
                            
                        }
                    }
                });
            });
        });
    </script>
    
    @endsection