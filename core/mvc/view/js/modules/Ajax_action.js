
//immediately invoked function to wrap code
(function(){

    //constructor
    this.Action = function(selector){
        this.$selector = selector;

        //default values
        var defaults = {
            className: 'ajax_action'
        }

        //if objects passed in arguments to extend defaults
        // if(arguments[0] && typeof arguments[0] === "object"){
        // this.options = extendDefaults(defaults, arguments[0]);
        // }

    }

    //Public Methods (Attached to Action object prototype)
    Action.prototype.open = function(){
        //public method go here
    }

    Action.prototype.performAction = function(){
        var _ = this;
        console.log(this);
        console.log(this.$selector.getAttribute('ajax_action'));
    }

    Action.prototype.init = function(){
        //initialize event listener
        initializeEvents.call(this);
    }

    //listen to click
    function initializeEvents(){
        this.$selector.addEventListener('click', this.performAction.bind(this));
    }


    //util to extend defaults with user options
    function extendDefaults(source, properties){
        var property;
        for(property in properties){
            //if property is it's own and not inherited then use that property to extend options
            if(properties.hasOwnProperty(property)){
                source[property] = properties[property];
            }
        }
        return source;
    }

}());