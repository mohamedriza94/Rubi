(document).ready(function() { $('.textarea_editor').wysihtml5(); });


var created_at = ''; //variable to format time

//FORMAT TIME
var time = ''; var date = '';
function formatTime(timeToBeFormatted)
{
    var created_at = moment.utc(timeToBeFormatted).local(); var now = moment();
    if (created_at.isSame(now, 'day')) {
        date = 'Today'+'&nbsp;&nbsp;';
        time = created_at.format('h:mm A'); // if the message was sent today, only display the time
    } else {
        date = created_at.format('MMM D, YYYY')+'&nbsp;&nbsp;';
        time = created_at.format('h:mm A');
    }
}

//CSRF TOKEN
$(document).ready(function(){
    //csrf token
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
});