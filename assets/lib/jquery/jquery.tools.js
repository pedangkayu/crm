(function( $ ) {

    $.fn.propery_select = function(options)
    {
        this.each(function(){
            var t = $(this);

            var settings = $.extend({
                init: true,
                target : '.select-properties',
                success : false,
                delete : false,
                btnsize : 'sm'
            }, options);

            var init = function(){
                $(settings.target, t).html('<a class="dropdown-toggle btn btn-'+settings.btnsize+' btn-default " data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"> <span class="vals"><i class="icon ion-plus-round"></i></span> </a> <ul class="dropdown-menu pull-right" aria-labelledby="dropdownMenu1"></ul>').addClass('dropdown');

                $('.property',t).map(function(){
                    $(settings.target+' ul',t).append('<li><a href="#" data-name="'+$(this).attr('data-name')+'">'+$(this).attr('data-title')+'</li></a>');
                });
            }

            var refresh = function()
            {
                $('.property',t).map(function(){
                    if($(this).attr('data-status')=='passive') $(settings.target+' a[data-name='+$(this).attr('data-name')+']',t).show();
                    else $(settings.target+' ul li a[data-name='+$(this).attr('data-name')+']',t).hide();
                    $('.input-status',$(this)).val($(this).attr('data-status')=='passive' ? 0 : 1);
                });

                $(settings.target,t).css('visibility',$('.property[data-status=passive]',t).length==0 ? 'hidden':'visible');
            }

            $(t).on('click',settings.target+' ul li a',function(){
                $('.property[data-name='+$(this).attr('data-name')+']',t).attr('data-status','active');
                $(this).parents('.dropdown').removeClass('open');
                refresh();
                if(settings.success) settings.success($(this));
                return false;
            });


            $(t).on('click','a.delete',function(){
                $(this).parents('.property').attr('data-status','passive');
                refresh();
                if(settings.delete) settings.delete($(this));
            });

            init();
            refresh();
        });

    };


    $.fn.propery_button = function(options)
    {
        this.each(function(){

            var t = $(this);

            var settings = $.extend({
                init: true,
                target : '.button-properties',
                success : false,
                delete : false
            }, options);

            var init = function(){
                $(settings.target, t).html('');
                $('.property',t).map(function(){
                    $(settings.target,t).append('<a href="#" class="btn btn-lg btn-default btn-reverse" data-name="'+$(this).attr('data-name')+'"><i class="icon ion-plus-round"></i> '+$(this).attr('data-title')+'</a> ');
                });
            }

            var refresh = function() {
                $('.property',t).map(function(){
                    if($(this).attr('data-status')=='passive') $(settings.target+' a[data-name='+$(this).attr('data-name')+']',t).show();
                    else $(settings.target+' a[data-name='+$(this).attr('data-name')+']',t).hide();
                    $('.input-status',$(this)).val($(this).attr('data-status')=='passive' ? 0 : 1);
                });

                $(settings.target,t).css('visibility',$('.property[data-status=passive]',t).length==0 ? 'hidden':'visible');
            }

            $(t).on('click',settings.target+' a',function(){
                $('.property[data-name='+$(this).attr('data-name')+']',t).attr('data-status','active');
                refresh();
                if(settings.success) settings.success($(this));
                return false;
            });

            $(t).on('click','a.delete',function(){
                $(this).parents('.property').attr('data-status','passive');
                refresh();
                if(settings.delete) settings.delete($(this));
                return false;
            });

            init();
            refresh();
        });

    };

}( jQuery ));