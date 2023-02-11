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
                
                <div class="row">
                    <div class="col-lg-3 col-md-4">
                        <div class="card-body inbox-panel">
                            <button data-bs-toggle="modal" data-bs-target="#composeModal" class="btn btn-primary m-b-20 p-10 w-100 waves-effect waves-light text-white">Compose</button>
                            <ul class="list-group list-group-full" id="messageTypeOptions">
                                <li id="openInbox" class="list-group-item d-flex no-block align-items-center active">
                                    <a class="d-flex no-block align-items-center"><i class="mdi mdi-gmail fs-4 me-2 d-flex align-items-center"></i> Inbox </a><span class="badge bg-success ms-auto" id="inboxCount"></span>
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
                                    <table class="table table-hover no-wrap font-13">
                                        <tbody id="messageTable">
                                            
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
        var url = "{{ url('rubi/dashboard/readMessages/:type/:limit') }}";
        
        function configureUrl()
        {
            url = "{{ url('rubi/dashboard/readMessages/:type/:limit') }}";
            url = url.replace(':type', type);
            url = url.replace(':limit', limit);
        }
        
        //Run methon on document load
        readMessage();
        
        //buttons to change messageType
        $(document).on('click', '#openInbox', function(e) {
            type = 'inbox';
            $("#messageTypeOptions li").removeClass("active"); $(this).addClass("active"); readMessage();
        });
        $(document).on('click', '#openStarred', function(e) {
            type = 'starred';
            $("#messageTypeOptions li").removeClass("active"); $(this).addClass("active"); readMessage();
        });
        $(document).on('click', '#openSent', function(e) {
            type = 'sent';
            $("#messageTypeOptions li").removeClass("active"); $(this).addClass("active"); readMessage();
        });
        $(document).on('click', '#openTrash', function(e) {
            type = 'trash';
            $("#messageTypeOptions li").removeClass("active"); $(this).addClass("active"); readMessage();
        });
        $(document).on('click', '#openReplies', function(e) {
            type = 'replies';
            $("#messageTypeOptions li").removeClass("active"); $(this).addClass("active"); readMessage();
        });
        
        //configuration to limit the number of messages displayed
        var limit = 0;
        $(document).on('click', '#btnNext', function(e) {
            limit = limit + 12; readMessage();
        });
        $(document).on('click', '#btnPrev', function(e) {
            limit = limit - 12; if(limit < 0) { limit = 0; } readMessage();
        });
        
        //reload message list
        $(document).on('click', '#btnReload', function(e) {
            readMessage();
        });
        
        function readMessage()
        {
            configureUrl();
            $.ajax({
                type: "GET", url:url, dataType:"json",
                success:function(response){
                    $('#messageTable').html(''); 

                    //Get INBOX COUNT
                    $('#inboxCount').text(response.count);
                    $.each(response.data,function(key,item){
                        //variables to sort message
                        var status = item.status;
                        var is_starred = item.is_starred;
                        var is_deleted = item.is_deleted;
                        
                        var selectedArray = []; //array to select rows using checkboxes
                        //display badges
                        var status_badge = '';
                        var star_badge = '';
                        
                        //sorting STATUS
                        switch(status) {
                            case 'unread':
                            status_badge = '<span class="label label-warning m-r-10">Unread</span>' //UNREAD
                            break;
                            case 'read':
                            status_badge = '<span class="label label-info m-r-10">Read</span>' //READ
                            break;
                            case 'replied':
                            status_badge = '<span class="label label-success m-r-10">Replied</span>' //REPLIED
                            break;
                        }
                        
                        //sorting STARRED MESSAGE
                        switch(is_starred) {
                            case 1:
                            star_badge = '<i id="star" class="fas fa-star text-warning"></i>' //STARRED
                            break;
                            case 0:
                            star_badge = '<i id="star" class="far fa-star"></i>' //UN-STARRED
                            break;
                        }
                        
                        //sorting TRASH MESSAGE
                        switch(is_deleted) {
                            case '1':
                            //IN TRASH
                            break;
                            case '0':
                            //NOT IN TRASH
                            break;
                        }
                        
                        //SORTING Data
                        var name = item.name.slice(0,15);
                        var subject = item.subject.slice(0,20);
                        var message = item.message.slice(0,25)+'...';
                        
                        //format time
                        var created_at = moment.utc(item.created_at).local(); var now = moment(); var time = ''; var date = '';
                        if (created_at.isSame(now, 'day')) {
                            time = created_at.format('h:mm A'); // if the message was sent today, only display the time
                        } else {
                            date = created_at.format('MMM D, YYYY')+'&nbsp;&nbsp;';
                            time = created_at.format('h:mm A');
                        }
                        
                        //sorting MESSAGE
                        switch (type) {
                            case 'inbox': case 'starred': // INBOX OR STARRED MESSAGES
                            
                            //append data to Message List
                            $('#messageTable').append('<tr>\
                                <td><input type="checkbox" class="form-check-input" id="check" value="'+item.id+'"></td>\
                                <td class="hidden-xs-down"><button class="btn" value="'+item.id+'" id="btnStar">'+star_badge+'</button></td>\
                                <td class="hidden-xs-down">'+name+'</td>\
                                <td class="max-texts"> <a href="">'+status_badge+' <strong>'+subject+'</strong> - '+message+'</td>\
                                    <td class="text-end">'+date+'<b>'+time+'</b></td>\
                                </tr>');
                                
                                break;
                                case 'trash':
                                // TRASH MESSAGES
                                break;
                                case 'replies':
                                // REPLIES
                                break;
                                case 'sent':
                                // SENT MESSAGES
                                break;
                            }
                        });
                    }
                });
            }
            
            //Starring Messages
            $(document).on('click', '#btnStar', function(e) {
                if($(this).find("#star").hasClass('far'))
                {
                    //STAR A MESSAGE
                    var starURL = "{{ url('rubi/dashboard/starMessage/:id/1') }}";
                    starURL = starURL.replace(':id', $(this).val());
                    
                    $.ajax({
                        type:"GET", url:starURL, dataType:"json"
                    });
                    
                    $(this).find("#star").removeClass('far'); $(this).find("#star").addClass('fas text-warning');
                }
                else
                {
                    //UN-STAR A MESSAGE
                    var starURL = "{{ url('rubi/dashboard/starMessage/:id/0') }}";
                    starURL = starURL.replace(':id', $(this).val());
                    
                    $.ajax({
                        type:"GET", url:starURL, dataType:"json"
                    });
                    
                    $(this).find("#star").removeClass('fas text-warning'); $(this).find("#star").addClass('far');
                }
            });
            
        });
    </script>
    @endsection