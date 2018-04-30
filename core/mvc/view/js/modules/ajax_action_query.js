(function($){
    $.fn.ajax_action = function(options){

        var settings = $.extend({}, $.fn.ajax_action.defaults, options);
        var full_ajax_url = settings.ajax_url + "?action=" + settings.action;

        this.each(function(){
            $(this).on('click', function(){
                $.fn.ajax_action.onclick(this, full_ajax_url);
            });
        });
    };

    $.fn.ajax_action.onclick = function(elem, post_url){
        //what to do upon clicking ajax_action btn
        console.log('clicked default method, Element : ');
        createAjaxPost(post_url, elem.dataset);
    };

    function createAjaxPost(post_url, data_to_send){
        $.post(post_url, data_to_send, function(returnData){
            console.log('post sucessfull : ' + returnData);
        }).fail(function(returnData){
            console.log('failed post : ' + returnData);
        });
    }

    $.fn.ajax_action.defaults = {
        selectorClassName: "ajax_action",
        ajax_url: params.ajaxurl,
        action: "custom_ajax"
    };
}(jQuery));