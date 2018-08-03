"use strict";

$(document).ready(function() {

    var message = $('#message');
    var upload  = $('#upload');

    //this function is used to submit installation from data
    var form    = $('#setupForm');
    form.submit(function(e) {
        e.preventDefault();
        $.ajax({
            url     : form.attr('action'),                      
            type    : form.attr('method'),
            dataType: "json",   
            data    : form.serialize(),
            beforeSend:function(){
                message.html('<i class="fa fa-cog fa-spin"></i> Please Wait...').addClass('alert alert-success').removeClass('alert-danger'); ;
            },
            success: function(data){
                if (data.status === false) {
                  message.html(data.exception).addClass('alert alert-danger').removeClass('alert-success');
                } else if (data.status === true) {
                    document.location = '?step=complete';
                }
            },
            error:function()
            {
                message.html('<i class="fa fa-times"></i> Please Try Again').addClass('alert alert-danger');
            }
        }); 

    });
    

    //this function is used to upload Load.sql file
    upload.change(function() {
        var file_data = upload.prop('files')[0];   
        var form_data = new FormData();    
        form_data.append('file', file_data);                            
        $.ajax({
            url: './app/controller/Upload_process.php', // point to server-side PHP script 
            dataType: 'text',  // what to expect back from the PHP script, if anything
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,                         
            type: 'post',
            beforeSend:function(){
                message.html('<i class="fa fa-cog fa-spin"></i> Please Wait...').addClass('alert alert-success').removeClass('alert-danger'); ;
            },
            success: function(data){
                if ( data==2 ) {
                    message.html("Invalid file!");
                } else if( data==3 ){
                    message.html("File contain error!");
                } else{
                    message.html( data + " is uploaded");
                }
            },
            error:function()
            {
                message.html('<i class="fa fa-times"></i> Please Try Again').addClass('alert alert-danger');
                setInterval(function () { 
                  history.go(0);
                }, 2000);
            }
        });
    });  

    //this function is used to show/hide .htaccess fields in installation form
    $("#is_htaccess").on('click', function(){
        $(this).parent().next().toggle().removeClass('hide');
    });

});

//window load
$(window).on('load', function() {
    var message = $('#completeMessage');
    var browse  = $('#browse');
    message.html('<i class="fa fa-cog fa-spin"></i> Please Wait...');
    setInterval(function () { 
        message.html('<i class="fa fa-check"></i> Install Successfully!');
        browse.removeClass('hidden');
    }, 15000);
});

