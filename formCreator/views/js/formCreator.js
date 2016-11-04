/**
 * Created by dima on 26.10.16.
 */

var formCreator = Class.create({
    initialize: function() {
        this.config = {

            form: {
                blocks: {
                  main         : '.form',
                  element      : '.form-element',
                  elementValue : '.form-element-value'
                },
                fields: {
                    method      : '.form-method',
                    enctype     : '.form-enctype',
                    elementType : '.form-element-type'

                },
                eventBlocks: {
                    saveAll            : '#save-all',
                    addForm            : '.form-add',
                    saveForm           : '.form-save',
                    deleteForm         : '.form-delete',
                    addElement         : '.form-element-add',
                    deleteElement      : '.form-element-delete',
                    addElementValue    : '.form-element-value-add',
                    deleteElementValue : '.form-element-value-delete',
                }
            }

        };

    },
    init: function () {
        var that = this;

        // init form actions
        this.initFormEnctype(this.config.form.fields.enctype);
        this.initElementAdd();
        // init form-element actions
        this.initElementValues();
        this.initElementDelete();
        // init form-element-value actions
        this.initElementValueAdd();
        this.initElementValueDelete();

    },
    initFormEnctype: function(selector) {
        var that = this;
        $$(selector).each(function (item) {
            var formBlock = $(item).up(that.config.form.blocks.main),
                formMethodField = formBlock.down(that.config.form.fields.method);
                if ($(formMethodField).value == 'get') {
                    item.writeAttribute('disabled', 'disabled');
                }
            formMethodField.observe('change', function (event) {
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
