/**
 * Created by dima on 26.10.16.
 */

var formCreator = Class.create({
    initialize: function() {
        this.config = {
            form : {
                block         : '.form',
                enctype       : '.form-enctype',
                method        : '.form-method',
                addElement    : '.add-element',
                element : {
                    remove      : '.remove-new-element',
                    changeType  : '.change-element-type',
                    addValue    : '.add-new-value',
                    newElementValue : {
                        remove : '.remove-new-value'
                    }
                },
            }
        };

    },
    init: function () {
        var that = this;
        this.initEnctype(this.config.form.enctype);
        this.initElements(this.config.form.element);
        /*Event.observe($$(this.config.newForm.changeMethod)[0], 'change', function() {
            if (this.value == 'post') {
                $$(that.config.newForm.enctype)[0].writeAttribute('disabled', null);

            } else {
                $$(that.config.newForm.enctype)[0].writeAttribute('disabled', 'disabled');
            }
        });*/
    },
    initChange : function () {

    },

    initClick: function () {

    },
    initEnctype: function(selector) {
        var that = this;
        $$(selector).each(function (item) {
            var formMethod = $(item).up(that.config.form.block).down(that.config.form.method);
            formMethod.observe('change', function (event) {
                (formMethod.value == 'get')
                    ? item.writeAttribute('disabled', 'disabled')
                    : item.writeAttribute('disabled', null);
            });
        });
    },
    initElements: function() {

    },
    initNewElement: function() {

    }

});
