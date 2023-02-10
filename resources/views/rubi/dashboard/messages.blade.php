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
        </div>
    </div>
</div>

{{-- content --}}
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">

                <div class="row">
                    <div class="col-lg-3 col-md-4">
                        <div class="card-body inbox-panel">
                            <button data-bs-toggle="modal" data-bs-target="#composeModal" class="btn btn-primary m-b-20 p-10 w-100 waves-effect waves-light text-white">Compose</button>
                            <ul class="list-group list-group-full" id="messageTypeOptions">
                                <li id="openInbox" class="list-group-item d-flex no-block align-items-center active">
                                    <a class="d-flex no-block align-items-center"><i class="mdi mdi-gmail fs-4 me-2 d-flex align-items-center"></i> Inbox </a><span class="badge bg-success ms-auto">6</span>
                                </li>
                                <li id="openStarred" class="list-group-item d-flex no-block align-items-center">
                                    <a class="d-flex no-block align-items-center"><i class="mdi mdi-star fs-4 me-2 d-flex justify-content-center"></i> Starred </a>
                                </li>
                                <li id="openSent" class="list-group-item d-flex no-block align-items-center ">
                                    <a class="d-flex no-block align-items-center"><i class="mdi mdi-file-document-box fs-4 me-2 d-flex align-items-center"></i> Sent Mail </a>
                                </li>
                                <li id="openReplies" class="list-group-item d-flex no-block align-items-center ">
                                    <a class="d-flex no-block align-items-center"><i class="mdi mdi-reply-all fs-4 me-2 d-flex align-items-center"></i> Replies </a>
                                </li>
                                <li id="openTrash" class="list-group-item d-flex no-block align-items-center">
                                    <a class="d-flex no-block align-items-center"><i class="fs-4 me-2 d-flex align-items-center mdi mdi-delete"></i> Trash </a>
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
            </div>
        </div>
    </div>

    {{-- Modals --}}
    <div class="modal bs-example-modal-lg animated fadeIn" id="composeModal" tabindex="-1" aria-hidden="true" style="display:none;">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">Compose Message</h4>
                    <button class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body">
                    <h4>Overflowing text to show scroll behavior</h4>
                    <p>Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor.</p>
                    <p>Aenean lacinia bibendum nulla sed consectetur. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Donec sed odio dui. Donec ullamcorper nulla non metus auctor fringilla.</p>
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
            
            //configure the url that gets the message
            var type = 'inbox';
            var url = "{{ url('rubi/dashboard/readMessages/:type') }}";

            function configureUrl()
            {
                url = "{{ url('rubi/dashboard/readMessages/:type') }}";
                url = url.replace(':type', type);
            }
            
            //buttons to change messageType
            $(document).on('click', '#openInbox', function(e) {
                type = 'inbox'; configureUrl();
                $("#messageTypeOptions li").removeClass("active"); $(this).addClass("active");
            });
            $(document).on('click', '#openStarred', function(e) {
                type = 'starred'; configureUrl();
                $("#messageTypeOptions li").removeClass("active"); $(this).addClass("active");
            });
            $(document).on('click', '#openSent', function(e) {
                type = 'sent'; configureUrl();
                $("#messageTypeOptions li").removeClass("active"); $(this).addClass("active");
            });
            $(document).on('click', '#openTrash', function(e) {
                type = 'trash'; configureUrl();
                $("#messageTypeOptions li").removeClass("active"); $(this).addClass("active");
            });
            $(document).on('click', '#openReplies', function(e) {
                type = 'replies'; configureUrl(); 
                $("#messageTypeOptions li").removeClass("active"); $(this).addClass("active");
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