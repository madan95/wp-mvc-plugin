(function($){
    $.fn.ajax_action = function(options){

        var settings = $.extend({}, $.fn.ajax_action.defaults, options);

        this.each(function(){
            var elem = $(this);
            elem.on("click", $.fn.ajax_action.onclick());
        });

    };

    $.fn.ajax_action.onclick = function(){
        console.log('clicked');
    };

    $.fn.ajax_action.defaults = {
        selectorClassName: "ajax_action"
    };

}(jQuery));