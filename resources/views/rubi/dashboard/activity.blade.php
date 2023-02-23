@extends('layouts.rubiAdmin')

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

        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <input type="text" id="searchActivities" class="form-control" placeholder="Search here">
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
                                    <th>Activity</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody id="activityTable">
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
    @endsection
    
    
    
    
    
    @section('script')
    <script>
        $(document).ready(function(){
            
            var url = "{{ url('rubi/dashboard/readActivities/:limit') }}";
            function configureUrl()
            {
                var length = $('#searchActivities').val().length;
                if (length == 0) {
                    url = "{{ url('rubi/dashboard/readActivities/:limit') }}";
                    url = url.replace(':limit', limit);
                }
            }
            
            //configuration to limit the number of messages displayed
            var limit = 0;
            $(document).on('click', '#btnNext', function(e) {
                limit = limit + 20; readActivities();
            });
            $(document).on('click', '#btnPrev', function(e) {
                limit = limit - 20; if(limit < 0) { limit = 0; } readActivities();
            });
            
            readActivities();
            
            //read packages
            function readActivities()
            {
                configureUrl();
                $.ajax({
                    type: "GET", url:url, dataType:"json",
                    success:function(response){
                        $('#activityTable').html(''); 
                        
                        $.each(response.data,function(key,item){

                            formatTime(item.created_at);
                            
                            $('#activityTable').append('<tr>\
                                <td><img style="width:30px;" class="m-r-10" src="'+item.logo+'">'+item.business+'</td>\
                                <td>'+item.activity+'</td>\
                                <td>'+date+' '+time+'</td>\
                                </tr>'); 
                            });
                        }
                    });
                }
                
                //search business
                $(document).on('keyup', '#searchActivities', function(e) {
                    url = "{{ url('rubi/dashboard/searchActivities/:search/:limit') }}";
                    url = url.replace(':search', $(this).val());
                    url = url.replace(':limit', limit);
                    readActivities();
                });
        });
        </script>
        @endsection