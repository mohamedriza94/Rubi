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
                                {{-- <li id="openReplies" class="list-group-item d-flex no-block align-items-center ">
                                    <a class="d-flex no-block align-items-center"><i class="mdi mdi-reply-all fs-4 me-2 d-flex align-items-center"></i> Replies </a>
                                </li> --}}
                                <li id="openTrash" class="list-group-item d-flex no-block align-items-center">
                                    <a class="d-flex no-block align-items-center"><i class="fs-4 me-2 d-flex align-items-center mdi mdi-delete"></i> Trash </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    

                    {{-- MESSAGE LIST DISPLAY --}}
                    <div class="col-lg-9 col-md-8 bg-light border-start" id="messageListDisplay">
                        <div class="card-body">
                            <div class="btn-group m-b-10 m-r-10">
                                <input id="searchMessage" class="form-control" placeholder="Search Inbox"> {{-- Search --}}
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

                    


                    {{-- OPEN SINGLE MESSAGE --}}
                    <div class="col-xlg-10 col-lg-9 col-md-8 bg-light border-start" id="openSingleMessage" style="display:none">
                        <div class="card-body">
                            <div class="btn-group m-b-10 m-r-10" role="group" aria-label="Button group with nested dropdown">
                                <button id="btnBack" class="btn btn-dark"><i class="mdi mdi-keyboard-backspace"></i></button>
                            </div>
                        </div>
                        <div class="card-body p-t-0">
                            <div class="card b-all shadow-none">
                                <div class="card-body">
                                    <h3 class="card-title m-b-0" id="messageTitle">Subject</h3>
                                </div>
                                <div>
                                    <hr class="m-t-0">
                                </div>
                                <div class="card-body">
                                    <div class="d-flex m-b-40">
                                        <div>
                                            <h4 class="m-b-0" id="senderName">Sender Name</h4>
                                            <small class="text-muted"><b>From</b>: <span id="messageEmail">Sender Email</span></small>
                                            &nbsp;
                                            <small class="text-muted"><b>Contact</b>: <span id="messageContact">Sender Number</span></small>
                                            &nbsp;
                                            <small class="text-muted"><b>Time</b>: <span id="messageTime">Message Time</span></small>
                                        </div>
                                    </div>
                                    <p id="messageDescription"></p>
                                    
                                </div>
                                <div>
                                    <hr class="m-t-0">
                                </div>
                                <div class="card-body">
                                    <div class="row" id="sendReply" style="display:none">
                                        <h4><b>Reply</b></h4>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <textarea class="reset textarea_editor form-control" rows="8" id="replyMessage" placeholder="Enter reply..."></textarea>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="d-md-flex align-items-center">
                                                <button id="btnSendReply" class="col-12 btn btn-primary">Send Reply</button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row" id="viewReply" style="display:none">
                                        <h4><b>Reply</b></h4>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                               <p id="replyText"></p>
                                               <small class="text-muted"><b>Sent On</b>: <span id="replyDate"></span></small>
                                            </div>
                                        </div>
                                    </div>
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
{{-- COMPOSE MESSAGE --}}
<div class="modal bs-example-modal-lg animated fadeIn" id="composeModal" tabindex="-1" aria-hidden="true" style="display:none;">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">Compose Mail</h4>
                <button class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="reset form-control" id="email"
                                            placeholder="Enter the recipient's email">
                                            <label for="tb-fname">Email</label>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-floating mb-3">
                                            <input type="text" id="subject" class="reset form-control" placeholder="Enter the subject">
                                            <label for="subject">Subject</label>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <textarea class="reset textarea_editor form-control" rows="8" id="message" placeholder="Enter message..."></textarea>
                                        </div>
                                    </div>
                                    
                                    <div class="col-12">
                                        <div class="d-md-flex align-items-center">
                                            <button type="submit" id="btnSend" class="col-12 btn btn-dark">Send</button>
                                        </div>
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
        
        //configure the url that gets the message
        var type = 'inbox';
        var url = "{{ url('rubi/dashboard/readMessages/:type/:limit') }}";
        
        function configureUrl()
        {
            var length = $('#searchMessage').val().length;
            if (length == 0) {
                url = "{{ url('rubi/dashboard/readMessages/:type/:limit') }}";
                url = url.replace(':type', type);
                url = url.replace(':limit', limit);
            }
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
            type = 'sent'; $('#sendReply').hide(); $('#viewReply').hide();  //HIDE REPLY SECTION
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
        
        //read message
        function readMessage()
        {
            configureUrl(); selectedMessages = [];
            $.ajax({
                type: "GET", url:url, dataType:"json",
                success:function(response){
                    $('#messageTable').html(''); 
                    
                    //Get INBOX COUNT
                    $('#inboxCount').text(response.count);
                    $.each(response.data,function(key,item){
                        //display badges
                        var status_badge = '';
                        var star_badge = '';
                        var delete_and_star = '';
                        
                        //sorting STATUS
                        switch(item.status) {
                            case 'unread':
                            status_badge = '<span class="label label-warning m-r-10">Unread</span>' //UNREAD
                            break;
                            case 'read':
                            status_badge = '<span class="label label-info m-r-10">Read</span>' //READ
                            break;
                            case 'replied':
                            status_badge = '<span class="label label-success m-r-10">Replied</span>' //REPLIED
                            break;
                            default:
                            status_badge = '';
                            break;
                        }
                        
                        //sorting STARRED MESSAGE
                        switch(item.is_starred) {
                            case 1:
                            star_badge = '<i id="star" class="fas fa-star text-warning"></i>' //STARRED
                            break;
                            case 0:
                            star_badge = '<i id="star" class="far fa-star"></i>' //UN-STARRED
                            break;
                        }
                        
                        //sorting TRASH MESSAGE
                        switch(item.is_deleted) {
                            case 1: case 3: //case 3 is a fake number for SENT messages
                            //IN TRASH
                            delete_and_star = '<td><input type="checkbox" class="form-check-input" id="check" value="'+item.id+'"></td>';
                            status_badge = '<span class="label label-danger m-r-10">Deleted</span>' //REPLIED
                            break;
                            case 0:
                            //NOT IN TRASH
                            delete_and_star = '<td><input type="checkbox" class="form-check-input" id="check" value="'+item.id+'"></td>\
                            <td class="hidden-xs-down"><button class="btn" value="'+item.id+'" id="btnStar">'+star_badge+'</button></td>';
                            break;
                        }
                        
                        //SORTING Data
                        var name = item.name.slice(0,15);
                        var subject = item.subject.slice(0,20);
                        var message = item.message.slice(0,25)+'...';
                        
                        //format time
                        formatTime(item.created_at);
                        
                        //sorting MESSAGE
                        switch (type) {
                            case 'inbox': case 'starred': case 'trash': case 'sent':// INBOX or STARRED MESSAGES or TRASH MESSAGES or SENT MESSAGES
                            
                            //append data to Message List
                            $('#messageTable').append('<tr>\
                                '+delete_and_star+'\
                                <td id="messageRow" data-id="'+item.id+'" class="text-center bg-secondary text-info"><i class="fa fa-eye"></i></td>\
                                <td class="hidden-xs-down">'+name+'</td>\
                                <td class="max-texts">'+status_badge+' <strong>'+subject+'</strong> - '+message+'</td>\
                                <td class="text-end">'+date+'<b>'+time+'</b></td>\
                                </tr>'); 
                                
                                break;
                                case 'replies':
                                // REPLIES
                                break;
                            }
                        });
                    }
                });
        }

        //search message
        $(document).on('keyup', '#searchMessage', function(e) {
            url = "{{ url('rubi/dashboard/searchMessages/:search/:limit') }}";
            url = url.replace(':search', $(this).val());
            url = url.replace(':limit', limit);
            readMessage();
        });
        
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
        
        //Deleting Messages
        var selectedMessages = [];
        $(document).on('click', '#check', function() {
            var value = $(this).val();
            if ($(this).is(':checked')) 
            { selectedMessages.push(value); } 
            else 
            { var index = selectedMessages.indexOf(value); if (index > -1) { selectedMessages.splice(index, 1); } }
        });
        $(document).on('click', '#btnDelete', function(e) {
            
            var deleteURL = '';
            var confirmationText = '';
            //CHOOSE WHICH TYPE OF MESSAGE TO DELETE
            switch (type) {
                case 'sent':
                deleteURL = '{{ url("rubi/dashboard/moveToTrash/sent") }}'; //DELETE SENT MESSAGES
                confirmationText = 'Messages will be deleted completely';
                break;
                case 'inbox':
                deleteURL = '{{ url("rubi/dashboard/moveToTrash/inbox") }}';
                confirmationText = 'Messages will be moved to trash';
                break;
                case 'trash':
                deleteURL = '{{ url("rubi/dashboard/moveToTrash/trash") }}';
                confirmationText = 'Messages will be deleted completely';
                break;
            }
            
            if(selectedMessages.length == 0)
            {
                toastType = 'warning'; toastMessage = 'Select a message first'; showToast(); //TOAST ALERT
            }
            else
            {
                Swal.fire({
                    title: 'Are you sure?',
                    text: confirmationText,
                    icon: 'warning', showCancelButton: true, confirmButtonColor: '#3085d6', cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) 
                    { 
                        //Delete ajax code
                        var data = { 'ids' : selectedMessages }
                        $.ajax({
                            type:"PUT",
                            url: deleteURL,
                            data:data,
                            dataType:"json",
                            success: function(response){
                                if(response.status == 400)
                                {
                                    toastType = 'error'; toastMessage = response.message; showToast(); //TOAST ALERT
                                    readMessage();
                                }
                                else if(response.status == 200)
                                {
                                    toastType = 'success'; toastMessage = response.message; showToast(); //TOAST ALERT
                                    readMessage();
                                }
                            }
                        });
                    }
                })
            }
        });
        
        //send message
        $(document).on('click', '#btnSend', function(e) {
            $("#btnSend").prop("disabled", true).text("Sending...");
            var data = { 'email' : $('#email').val(),  'subject' : $('#subject').val(), 'message' : $('#message').val() }
            $.ajax({
                type:"POST",
                url: '{{ url("rubi/dashboard/sendMessage") }}',
                data:data,
                dataType:"json",
                success: function(response){
                    if(response.status == 600)
                    {
                        $.each(response.errors,function(key,error)
                        {
                            toastMessage = '';
                            toastType = 'error'; toastMessage += error; showToast(); //TOAST ALERT
                        });
                        
                        $("#btnSend").prop("disabled", false).text("Send");
                    }
                    else if(response.status == 400)
                    {
                        $("#btnSend").prop("disabled", false).text("Send");

                        toastType = 'error'; toastMessage = response.message; showToast(); //TOAST ALERT
                    }
                    else if(response.status == 200)
                    {
                        $("#btnSend").prop("disabled", false).text("Send");
                        $('.reset').val(''); //UNIVERSAL RESET INPUT

                        Swal.fire({ title: 'Success', text: "Message Sent",
                        icon: 'success', confirmButtonColor: '#3085d6', confirmButtonText: 'OK' });
                    }
                }
            })
        });

        //open a message
        //VARIABLES TO STORE MESSAGE DATA INORDER TO SEND REPLY
        var subject = ''; var email = ''; var inquiry_id = ''; var messageTime = '';

        $(document).on('click', '#messageRow', function(e){
            e.preventDefault();
            var id = $(this).attr("data-id"); //get message id
            var urlOpenMessage = '{{ url("rubi/dashboard/seeMessage/:id/:type") }}'; urlOpenMessage = urlOpenMessage.replace(':id', id);
            urlOpenMessage = urlOpenMessage.replace(':type', type);
            $.ajax({
                type:"GET", url:urlOpenMessage, dataType:"json",
                success: function(response)
                {
                    $('#messageListDisplay').hide(); $('#openSingleMessage').show();  //OPEN MESSAGE
                    
                    //format time
                    formatTime(response.inquiry.created_at);
                    
                    //STORE DATA INTO MESSAGE VARIABLES
                    subject = response.inquiry.subject; email = response.inquiry.email; inquiry_id = response.inquiry.id; messageTime = date+time;
                    
                    $('#messageTime').html(messageTime); $('#messageTitle').text(subject);
                    $('#senderName').text(response.inquiry.name); $('#messageEmail').text(email);
                    $('#messageContact').text(response.inquiry.number); $('#messageDescription').text(response.inquiry.message);
                    
                    switch(response.inquiry.status) {
                        case 'unread': case 'read':
                        $('#sendReply').show(); $('#viewReply').hide();  //NOT REPLIED
                        break;
                        case 'replied':
                        $('#sendReply').hide(); $('#viewReply').show(); //REPLIED
                        $('#replyText').html(response.reply.reply);

                        formatTime(response.reply.created_at);
                        $('#replyDate').html(date+time);
                        break;
                    }
                }
            });
        });

        //send reply
        $(document).on('click', '#btnSendReply', function(e) {
            $("#btnSendReply").prop("disabled", true).text("Sending Reply...");
            var data = { 'reply' : $('#replyMessage').val(), 'subject' : subject, 'messageTime' : messageTime, 'email' : email, 'inquiry_id' : inquiry_id }
            $.ajax({
                type:"POST",
                url: '{{ url("rubi/dashboard/sendReply") }}',
                data:data,
                dataType:"json",
                success: function(response){
                    if(response.status == 600)
                    {
                        $.each(response.errors,function(key,error)
                        {
                            toastMessage = '';
                            toastType = 'error'; toastMessage += error; showToast(); //TOAST ALERT
                        });
                        
                        $("#btnSendReply").prop("disabled", false).text("Send Reply");
                    }
                    else if(response.status == 400)
                    {
                        $("#btnSendReply").prop("disabled", false).text("Send Reply");
                        toastType = 'error'; toastMessage = response.message; showToast(); //TOAST ALERT
                    }
                    else if(response.status == 200)
                    {
                        $("#btnSendReply").prop("disabled", false).text("Send Reply");
                        $('.reset').val(''); //UNIVERSAL RESET INPUT
                        readMessage();
                        $('#messageListDisplay').show(); $('#openSingleMessage').hide();  //CLOSE MESSAGE
                        
                        Swal.fire({ title: 'Success', text: "Reply Sent",
                        icon: 'success', confirmButtonColor: '#3085d6', confirmButtonText: 'OK' });
                    }
                }
            })
        });

        //go back
        $(document).on('click', '#btnBack', function(e){
            e.preventDefault();
            $('#messageListDisplay').show(); $('#openSingleMessage').hide();  //CLOSE MESSAGE
        });
        });
    </script>
    @endsection