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
                
                <div class="btn-group m-b-10 m-r-10">
                    <button id="btnSetPayroll" class="btn btn-secondary font-18">Payroll</button>
                    <button id="btnSortAll" class="btn btn-outline-primary font-18">All</button>
                    <button id="btnSortPending" class="btn btn-outline-warning font-18">Pending</button>
                    <button id="btnSortPaid" class="btn btn-outline-success font-18">Paid</button>
                    <input placeholder="Search" class="form-control" id="search">
                </div>
                
                <div class="table-responsive">
                    <table class="table color-table purple-table">
                        <thead>
                            <tr>
                                <th>Employee</th>
                                <th>Payment Status</th>
                                <th>Due</th>
                                <th>Paid</th>
                                <th>Pay Date</th>
                                <th>Action</th>
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

{{-- view modal --}}
<div class="modal bs-example-modal-lg animated fadeIn" id="viewModal" tabindex="-1" aria-hidden="true" style="display:none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">Make Payment</h4>
                <button class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form class="row" id="createForm">
                                    
                                    <div class="form-group col-12">
                                        <label class="form-label">Amount</label>
                                        <input class="form-control" id="amount" name="amount">
                                    </div>
                                    
                                    <div class="col-12">
                                        <div class="d-md-flex align-items-center">
                                            <button id="btnPay" class="col-12 btn btn-danger">Pay</button>
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
        
        var url = "{{ url('sub/dashboard/readPayroll/all') }}";
        readPayroll();
        
        //read payroll
        function readPayroll()
        {
            $.ajax({
                type: "GET", url:url, dataType:"json",
                success:function(response){
                    $('#table').html(''); 
                    
                    $.each(response.data,function(key,item){
                        //display badges
                        var status_badge = ''; var pay_button = ''; var payDate = '';
                        
                        //sorting STATUS
                        switch(item.status) {
                            case 'pending':
                            payDate = '-';
                            status_badge = '<span class="label label-warning">PENDING</span>'; //PENDING
                            pay_button = '<button id="btnView" value="'+item.id+'" class="btn btn-primary">Pay</button>';
                            break;
                            case 'paid':
                            //format time
                            formatTime(item.updated_at);
                            payDate = date+time;
                            status_badge = '<span class="label label-success">PAID IN FULL</span>'; //PAID
                            pay_button = '-';
                            break;
                        }
                        
                        $('#table').append('<tr>\
                            <td>'+item.fullname+'</td>\
                            <td>'+status_badge+'</td>\
                            <td>LKR '+item.due+'</td>\
                            <td>LKR '+item.paid+'</td>\
                            <td>'+payDate+'</td>\
                            <td>\
                                <div class="btn-group m-b-10 m-r-10">\
                                    '+pay_button+'\
                                </div>\
                            </td>\
                        </tr>'); 
                    });
                }
            });
        }
        
        var payrollID = '';
        //View
        $(document).on('click', '#btnView', function(e){
            e.preventDefault();
            payrollID = $(this).val(); //get payroll id
            $('#viewModal').modal('show');
        });
        
        //sort all
        $(document).on('click','#btnSortAll',function(e){
            e.preventDefault();
            url = "{{ url('sub/dashboard/readPayroll/:type') }}";
            url = url.replace(":type","all");
            readPayroll();
        });
        //sort shortlisted
        $(document).on('click','#btnSortPending',function(e){
            e.preventDefault();
            url = "{{ url('sub/dashboard/readPayroll/:type') }}";
            url = url.replace(":type","pending");
            readPayroll();
        });
        //sort rejected
        $(document).on('click','#btnSortPaid',function(e){
            e.preventDefault();
            url = "{{ url('sub/dashboard/readPayroll/:type') }}";
            url = url.replace(":type","paid");
            readPayroll();
        });
        //search
        $(document).on('keyup','#search',function(e){
            e.preventDefault();
            if($(this).val().length == 0)
            {
                url = "{{ url('sub/dashboard/readPayroll/:type') }}";
                url = url.replace(":type","all");
            }
            else
            {
                url = "{{ url('sub/dashboard/searchPayroll/:search') }}";
                url = url.replace(":search",$(this).val());
            }
            readPayroll();
        });
        //set payroll
        $(document).on('click','#btnSetPayroll',function(e){
            $.ajax({
                type: "GET", url:"{{ url('sub/dashboard/setPayroll') }}", dataType:"json",
                success:function(response){
                    readPayroll();
                }
            });
        });
        //pay
        $(document).on('click', '#btnPay', function(e) {
            e.preventDefault();
            
            $("#btnPay").prop("disabled", true).text("Paying...");

            var id = payrollID;
            var amount = $('#amount').val();
            var data = { 'id':id, 'amount':amount}
            $.ajax({
                type:"PUT",
                url: "{{ url('sub/dashboard/pay') }}",
                data:data,
                dataType:"json",
                success: function(response){
                    if(response.status == 400)
                    {
                        $("#btnPay").prop("disabled", false).text("Pay");
                        toastType = 'error'; toastMessage = response.message; showToast(); //TOAST ALERT
                        readPayroll();
                    }
                    else if(response.status == 200)
                    {
                        $("#btnPay").prop("disabled", false).text("Pay");
                        toastType = 'success'; toastMessage = response.message; showToast(); //TOAST ALERT
                        readPayroll();
                        $('#amount').val('');
                    }
                }
            });
        });
    });
</script>
@endsection