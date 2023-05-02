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
                    <h4 class="card-title" id="dataCount"></h4>
                    <div class="table-responsive">
                        <table class="table color-table purple-table text-center">
                            <thead>
                                <tr>
                                    <th>Log No.</th>
                                    <th>Employee</th>
                                    <th>Department</th>
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
    
    @endsection
    
    
    
    
    
    @section('script')
    
    <script>
        $(document).ready(function(){
            
            var url = "{{ url('sub/dashboard/readAttendance') }}";
            function configureUrl()
            {
                url = "{{ url('sub/dashboard/readAttendance') }}";
            }
            
            readAttendance();
            
            //read packages
            function readAttendance()
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
                                <td><img src="'+item.employeePhoto+'" style="width:50px;"> &nbsp;&nbsp; '+item.employeeName+'</td>\
                                <td>'+item.department+'</td>\
                                <td>'+date+''+time+'</td>\
                            </tr>'); 
                        });
                    }
                });
            }
            
        });
    </script>
    
    @endsection