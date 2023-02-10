@extends('layouts.admin')

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
            <button type="button" class="btn btn-info d-none d-lg-block m-l-15 text-white"><i class="fas fa-location-arrow"></i> Compose</button>
        </div>
    </div>
</div>

{{-- content --}}
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                
                <ul class="nav nav-pills m-b-30">
                    <li class=" nav-item"> <a id="seeInquiries" href="#messageTab" class="nav-link active" data-bs-toggle="tab" aria-expanded="false">Inquiries</a> </li>
                    <li class=" nav-item"> <a id="seeUserMessages" href="#messageTab" class="nav-link" data-bs-toggle="tab" aria-expanded="false">User Messages</a> </li>
                    <li class="nav-item"> <a id="seeReplies" href="#repliesTab" class="nav-link" data-bs-toggle="tab" aria-expanded="false">Replies</a> </li>
                </ul>
                
                {{-- inquiries tab --}}
                <div class="tab-content br-n pn">
                    <div id="messageTab" class="tab-pane active">
                        <div class="row">
                            
                            <div class="col-lg-3 col-md-4">
                                <div class="card-body inbox-panel">
                                    <ul class="list-group list-group-full">
                                        <li class="list-group-item d-flex no-block align-items-center active">
                                            <a id="openInbox" class="d-flex no-block align-items-center"><i class="mdi mdi-gmail fs-4 me-2 d-flex align-items-center"></i> Inbox </a><span class="badge bg-success ms-auto">6</span>
                                        </li>
                                        <li class="list-group-item d-flex no-block align-items-center">
                                            <a id="openStarred" class="d-flex no-block align-items-center"><i class="mdi mdi-star fs-4 me-2 d-flex justify-content-center"></i> Starred </a>
                                        </li>
                                        <li class="list-group-item d-flex no-block align-items-center ">
                                            <a id="openSent" class="d-flex no-block align-items-center"><i class="mdi mdi-file-document-box fs-4 me-2 d-flex align-items-center"></i> Sent Mail </a>
                                        </li>
                                        <li class="list-group-item d-flex no-block align-items-center">
                                            <a id="openTrash" class="d-flex no-block align-items-center"><i class="fs-4 me-2 d-flex align-items-center mdi mdi-delete"></i> Trash </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            
                            <div class="col-lg-9 col-md-8 bg-light border-start">
                                <div class="card-body">
                                    <div class="btn-group m-b-10 m-r-10">
                                        <input id="searchMessage" class="form-control" placeholder="Search Here"> {{-- Search --}}
                                    </div>
                                    
                                    <div class="btn-group m-b-10 m-r-10">
                                        <button id="btnDelete" class="btn btn-outline-danger font-18"><i class="fas fa-trash"></i></button>
                                    </div>
                                    
                                    <div class="btn-group m-b-10 m-r-10">
                                        <button id="btnReload" class="btn btn-success font-18"><i class="fas fa-sync-alt"></i></button>
                                    </div>
                                    
                                    <div class="btn-group m-b-10 m-r-10">
                                        <button id="btnPrev" class="btn btn-outline-dark font-18"><i class="fas fa-angle-double-left"></i></button>
                                        <button id="btnNext" class="btn btn-outline-dark font-18"><i class="fas fa-angle-double-right"></i></button>
                                    </div>
                                </div>
                                
                                {{-- message list --}}
                                <div class="card-body p-t-0">
                                    <div class="card b-all shadow-none">
                                        <div class="inbox-center table-responsive">
                                            <table class="table table-hover no-wrap font-12">
                                                <tbody id="messageTable">
                                                    <tr class="">
                                                        <td>
                                                            <input type="checkbox" class="form-check-input" id="checkbox0" value="check">
                                                        </td>
                                                        <td class="hidden-xs-down"><a id="star"><i class="fas fa-star text-primary"></i></a></td>
                                                        <td class="hidden-xs-down">Hritik Roshan</td>
                                                        <td class="max-texts"> <a href=""><span class="label label-info m-r-10">Work</span> Lorem ipsum perspiciatis unde omnis iste natus error sit voluptatem</td>
                                                            <td class="text-end"> 12:30 PM </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        
                        {{-- replies tab --}}
                        <div id="repliesTab" class="tab-pane">
                            <div class="row">
                                
                            </div>
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
            
            //configure the url that gets the message
            var messageType = 'inquiries';
            var url = "{{ url('rubi/dashboard/readMessages/:messageType/:starredOrTrash/:type') }}";
            //starredOrTrash - to get starred and trash messages
            //type - to get sent or received messages
            //
            function configureUrl()
            {
                url = "{{ url('rubi/dashboard/readMessages/:messageType') }}";
                url = url.replace(':messageType', messageType);
            }
            
            //buttons to change message type
            $(document).on('click', '#seeInquiries', function(e) {
                messageType = 'inquiries'; configureUrl();
            });
            $(document).on('click', '#seeUserMessages', function(e) {
                messageType = 'userMessages'; configureUrl();
            });
            $(document).on('click', '#seeReplies', function(e) {
                messageType = 'replies'; configureUrl();
            });
            
            //configuration to limit the number of messages displayed
            var limit = 0;
            $(document).on('click', '#btnNext', function(e) {
                limit = limit + 12;
            });
            $(document).on('click', '#btnPrev', function(e) {
                limit = limit - 12; if(limit < 0) { limit = 0; }
            });

        });
    </script>
    @endsection