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
                    <table class="table color-table purple-table text-center">
                        <thead id="tableHead">
                        </thead>
                        <tbody id="tableData">
                        </tbody>
                    </table> 
                </div>
            </div>
        </div>
    </div>
</div>

@endsection





@section('script')
<script>
    $(document).ready(function(){
        
        var url = "{{ url('business/dashboard/readCashOut/:type') }}";
        var type = 'pettyExpense';
        url = url.replace(':type',type);
        
        function configureURL()
        {
            url = "{{ url('business/dashboard/readCashOut/:type') }}";
            url = url.replace(':type',type);
        }
        
        readCashOut();

        //read payrol
        function readPayroll()
        {
            $('#tableHead').html('<tr>\
                <th>No.</th>\
                <th>Status</th>\
                <th>Due</th>\
                <th>Paid</th>\
                <th>Date</th>\
                </tr>');

            configureURL();
            $.ajax({
                type: "GET", url:url, dataType:"json",
                success:function(response){
                    $('#tableData').html(''); 
                    
                    $.each(response.data,function(key,item){
                        
                        //display badges
                        var status_badge = '';
                        
                        //sorting STATUS
                        switch(item.status) {
                            case 'pending':
                            status_badge = '<span class="label label-danger font-18 p-2">PENDING</span>'; //PENDING
                            break;
                            case 'paid':
                            status_badge = '<span class="label label-success font-18 p-2">PAID</span>'; //PAID
                            break;
                        }
        
                        formatTime(item.created_at);
                        
                        $('#tableData').append('<tr>\
                            <td>'+item.id+'</td>\
                            <td>'+status_badge+'</td>\
                            <td>'+item.due+'</td>\
                            <td>'+item.paid+'</td>\
                            <td>'+date+time+'</td>\
                        </tr>'); 
                    });
                }
            });
        }

        //read petty expense
        function readPettyExpense()
        {
            $('#tableHead').html('<tr>\
                <th>No.</th>\
                <th>Purpose</th>\
                <th>Amount</th>\
                <th>Date</th>\
                </tr>');

            configureURL();
            $.ajax({
                type: "GET", url:url, dataType:"json",
                success:function(response){
                    $('#tableData').html(''); 
                    
                    $.each(response.data,function(key,item){
        
                        formatTime(item.created_at);
                        
                        $('#tableData').append('<tr>\
                            <td>'+item.no+'</td>\
                            <td>'+item.purpose+'</td>\
                            <td>LKR '+item.amount+'</td>\
                            <td>'+date+time+'</td>\
                        </tr>'); 
                    });
                }
            });
        }

        function readCashOut()
        {
            switch (type) {
                case 'payroll':
                    readPayroll();
                    break;
                case 'pettyExpense':
                    readPettyExpense();
                    break;
            }
        }
        
        //sort
        $(document).on('click', '#btnPayrollSort', function(e){
            type = 'payroll'; readCashOut();
        });
        $(document).on('click', '#btnPettyExpenseSort', function(e){
            type = 'pettyExpense'; readCashOut();
        });
    });
</script>
@endsection