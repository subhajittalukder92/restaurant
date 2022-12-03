$(document).ready(function() {
    
    /*==============Page Loader=======================*/

    $(".loader-wrapper").fadeOut("slow");

    /*===============Page Loader=====================*/

    /*============Dynamic modal content ============*/
    $('#exampleModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var recipient = button.data('whatever') // Extract info from data-* attributes
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        modal.find('.modal-title').text('New message to ' + recipient)
        modal.find('.modal-body input').val(recipient)
    });
    /*============Dynamic modal content ============*/

    //Tooltips
    $('[data-toggle="tooltip"]').tooltip();

    //Popovers
    $('[data-toggle="popover"]').popover();

    //Dismissed popover
    $('.popover-dismiss').popover({
        trigger: 'focus'
    })

    /*===============Sweet alert =============== */

    $("#show_alert").on('click', function() {
        swal("Hello world!");
    });

    //With title
    $("#show_with_title").on('click', function() {
        swal("Here's the title!", "...and here's the text!");
    });

    //Sweet Alert types
    //Info
    $("#show_alert_info").on('click', function() {
        swal("Info!", "You clicked the button info!", "info");
    });

    //Success
    $("#show_alert_success").on('click', function() {
        swal("Success!", "You clicked the button successfully!", "success");
    });

    //Error
    $("#show_alert_error").on('click', function() {
        swal("Error!", "You clicked the button, problem encountered!", "error");
    });

    //Warning
    $("#show_alert_warning").on('click', function() {
        swal("Warning!", "You clicked the warning button!", "warning");
    });

    //Sweet Alert Promises
    $("#show_alert_promise_one").on('click', function() {
        swal("Click on either the button or outside the modal.")
        .then((value) => {
        swal(`The returned value is: ${value}`);
        });
    });

    $("#show_alert_promise_two").on('click', function() {
        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this imaginary file!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
          })
          .then((willDelete) => {
            if (willDelete) {
              swal("Poof! Your imaginary file has been deleted!", {
                icon: "success",
              });
            } else {
              swal("Your imaginary file is safe!");
            }
        });
    });

    /*==============Sweet alert===============*/

    /* =========== Alertify notifier ========== */

    $('#alertify_nofify').on('click', function() {
        //using custom CSS
        // .ajs-message.ajs-custom { color: #31708f;  background-color: #d9edf7;  border-color: #31708f; }
        alertify.set('notifier','position', 'bottom-right');
        alertify.notify('custom message.', 'custom', 2, function(){console.log('dismissed');}).dismissOthers();
    });

    $('#alertify_success').on('click', function() {
        alertify.set('notifier','position', 'bottom-right');
        alertify.success('Success notification message.').dismissOthers(); 
    });

    $('#alertify_error').on('click', function() {
        alertify.set('notifier','position', 'bottom-right');
        alertify.error('Error notification message.').dismissOthers();
    });

    $('#alertify_warning').on('click', function() {
        alertify.set('notifier','position', 'bottom-right');
        alertify.warning('Warning notification message.').dismissOthers(); 
    });

    /*Top positioned alert */
    $('#alertify_nofify_top').on('click', function() {
        //using custom CSS
        // .ajs-message.ajs-custom { color: #31708f;  background-color: #d9edf7;  border-color: #31708f; }
        alertify.set('notifier','position', 'top-right');
        alertify.notify('custom message.', 'custom', 2, function(){console.log('dismissed');}).dismissOthers();
    });

    $('#alertify_success_top').on('click', function() {
        alertify.set('notifier','position', 'top-right');
        alertify.success('Success notification message.').dismissOthers(); 
    });

    $('#alertify_error_top').on('click', function() {
        alertify.set('notifier','position', 'top-right');
        alertify.error('Error notification message.').dismissOthers();
    });

    $('#alertify_warning_top').on('click', function() {
        alertify.set('notifier','position', 'top-right');
        alertify.warning('Warning notification message.').dismissOthers(); 
    });

});

/*========== Toggle Sidebar width ============ */
function toggle_sidebar() {
    $('#sidebar-toggle-btn').toggleClass('slide-in');
    $('.sidebar').toggleClass('shrink-sidebar');
    $('.content').toggleClass('expand-content');
    
    //Resize inline dashboard charts
    $('#incomeBar canvas').css("width","100%");
    $('#expensesBar canvas').css("width","100%");
    $('#profitBar canvas').css("width","100%");
}


/*==== Header menu toggle navigation show and hide =====*/

function toggle_dropdown(elem) {
    $(elem).parent().children('.dropdown').slideToggle("fast");
    $(elem).parent().children('.dropdown').toggleClass("animated flipInY");
}

$("body").not(document.getElementsByClassName('dropdown-toggle')).click(function() {
    if($('.dropdown').hasClass('animated')) {
        //$('.dropdown').removeClass("animated flipInY");
    }
});
/*==== Header menu toggle navigation show and hide =====*/


/*==== Sidebar toggle navigation show and hide =====*/

function toggle_menu(ele) {
    //close all ul with children class that are open except the one with the selected id
    $( '.children' ).not( document.getElementById(ele) ).slideUp("Normal");
    $( "#"+ele ).slideToggle("Normal");
    localStorage.setItem('lastTab', ele);
}

function pageLoad() {
    $.each($('.children'), function () {
        let ele = localStorage.getItem('lastTab');
        if ($(this).attr('id') == ele) {
            $( "#"+ele ).slideDown("Normal");
        }
    });
}

pageLoad();
