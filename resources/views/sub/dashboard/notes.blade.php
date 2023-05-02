@extends('layouts.sub')

@section('content')

@php
$user = auth('businessAdmin')->user();
$department = \App\Models\Department::find($user->department);
@endphp

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
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                
                    <button data-bs-toggle="modal" data-bs-target="#viewModal" class="btn btn-dark text-white">
                        Old Notes</button>
                        <hr>

                    <form class="row" id="createForm" enctype="multipart/form-data" method="post">
                        <div class="form-group col-12">
                            <label class="form-label">Subject</label>
                            <input class="form-control" name="subject">
                        </div>
                        
                        <div class="form-group col-12">
                            <label class="form-label">Note</label>
                            <textarea class="form-control" rows="10" name="note"></textarea>
                        </div>
                        
                        <div class="col-12">
                            <div class="d-md-flex align-items-center">
                                <button type="submit" id="btnCreate" class="col-12 btn btn-info">Make Note</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    {{-- Modals --}}
    {{-- create modal --}}
    <div class="modal bs-example-modal-lg animated fadeIn" id="viewModal" tabindex="-1" aria-hidden="true" style="display:none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">Old Notes</h4>
                    <button class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title text-uppercase" id="dataCount">{{ $department->name }} DEPARTMENT NOTES</h5>
                                    <div class="table-responsive">
                                        <table class="text-center table color-table red-table">
                                            <thead>
                                                <tr class="text-uppercase">
                                                    <th>No.</th>
                                                    <th>Subject</th>
                                                    <th>Status</th>
                                                    <th>Made On</th>
                                                </tr>
                                            </thead>
                                            <tbody id="notesTable">
                                            </tbody>
                                        </table> 
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
            
            var url = "{{ url('sub/dashboard/readNotes') }}";
            function configureUrl()
            {
                url = "{{ url('sub/dashboard/readNotes') }}";
            }
            
            readNotes();
            
            //read notes
            function readNotes()
            {
                configureUrl();
                $.ajax({
                    type: "GET", url:url, dataType:"json",
                    success:function(response){
                        $('#notesTable').html(''); 
                        
                        $.each(response.data,function(key,item){
                            //display badges
                            var status_badge = ''; var status_button = ''; var nickname = '';
                            
                            //sorting STATUS
                            switch(item.isViewed) {
                                case 1:
                                status_badge = '<span class="label label-success">Opened</span>'; //ACTIVE
                                break;
                                case 0:
                                status_badge = '<span class="label label-info">Unopened</span>'; //INACTIVE
                                break;
                            }
                            
                            //format time
                            formatTime(item.created_at);
                            
                            $('#notesTable').append('<tr>\
                            <td>'+item.no+'</td>\
                            <td>'+item.subject+'</td>\
                            <td>'+status_badge+'</td>\
                            <td>'+date+''+time+'</td>\
                            </tr>'); 
                        });
                    }
                });
            }
            
            //Create
            $(document).on('click', '#btnCreate', function(e) {
                e.preventDefault();
                
                $("#btnCreate").prop("disabled", true).text("Making Note...");
                
                let formData = new FormData($('#createForm')[0]);
                $.ajax({
                    type: "POST", url: "{{ url('sub/dashboard/createNote') }}",
                    data: formData, contentType:false, processData:false,
                    success: function(response){
                        if(response.status==800)
                        {
                            $.each(response.errors,function(key,error)
                            {
                                toastMessage = '';
                                toastType = 'error'; toastMessage += error; showToast(); //TOAST ALERT
                            });
                            
                            $("#btnCreate").prop("disabled", false).text("Make Note");
                        }
                        else if(response.status == 400 || response.status == 600)
                        {
                            $("#btnCreate").prop("disabled", false).text("Make Note");
                            toastType = 'error'; toastMessage = response.message; showToast(); //TOAST ALERT
                        }
                        else if(response.status == 200)
                        {
                            $("#btnCreate").prop("disabled", false).text("Make Note");
                            $('#createForm')[0].reset(); //FORM RESET INPUT
                            readNotes();
                            
                            Swal.fire({ title: 'Success', text: "Note made",
                            icon: 'success', confirmButtonColor: '#3085d6', confirmButtonText: 'OK' });
                            
                        }
                    }
                });
            });
        });
    </script>
    
    @endsection