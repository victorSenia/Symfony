(function($){
    /**
     * FORMS - PROTOTYPE ADD
     */
    $('body').on('click', 'button.prototype-add', function(event){
        var fieldHolder = $('#' + $(event.target).data('id'));
        if(!fieldHolder.length) return;

        var fieldPrototype = fieldHolder.data('prototype');
        if(!fieldPrototype) return;

        var index = $('.form-group', fieldHolder).length;
        var newField = $(fieldPrototype.replace(/__name__/g, index));

        fieldHolder.data('index', index);

        fieldHolder.append(newField);
    });
    /**
     * FORMS - PROTOTYPE REMOVE
     */
    $('body').on('click', 'button.prototype-remove', function(event){
        $(event.target).prev().remove();
        $(event.target).remove();
    });
})(jQuery);