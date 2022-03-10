window.alertBox = function(msg='msg here',title='Alert!'){
    $.alert({
        title: title,
        content: msg,
    });
};
window.confirmBox = function(msg,callback,title='Confirm!'){
$.confirm({
    title: title,
    content: msg,
    buttons: {
        confirm: function () {
            callback(true);
        },
        cancel: function () {
            callback(false);
        }
    }
});
};

window.promptBox = function(msg,callback,title='Prompt!'){
    $.confirm({
        title: title,
        content: '' +
        '<form action="" class="formName">' +
        '<div class="form-group">' +
        '<label>'+ msg +'</label>' +
        '<input type="text" class="name form-control" required />' +
        '</div>' +
        '</form>',
        buttons: {
            formSubmit: {
                text: 'Submit',
                btnClass: 'btn-blue',
                action: function () {
                    var name = this.$content.find('.name').val();
                    if(!name){
                        $.alert('provide a valid name');
                        return false;
                    }else{
                        callback(name);
                    }
                    
                }
            },
            cancel: function () {
                //close
            },
        },
        onContentReady: function () {
            // bind to events
            var jc = this;
            this.$content.find('form').on('submit', function (e) {
                // if the user submits the form by pressing enter in the field.
                e.preventDefault();
                jc.$$formSubmit.trigger('click'); // reference the button and click it
            });
        }
    });
};

window.MessageBox = function(msg,title='Message Box'){
     $.dialog({
        title: title,
        content: msg
    });
}


