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
                buttons: {
                    saveAll            : '#save-all',
                    addForm            : '.form-add',
                    saveForm           : '.form-save',
                    deleteForm         : '.form-delete',
                    addElement         : '.form-element-add',
                    deleteElement      : '.form-element-delete',
                    addElementValue    : '.form-element-value-add',
                    deleteElementValue : '.form-element-value-delete',
                }
            },
            templates: {

                element   : '<div class="form-element">' +
                            '<h4>new element</h4>' +
                            '<button class="form-element-delete">delete element</button>' +
                            '<p>name <input name="form[#{f}][element][#{i}][name]" type="text"></p>' +
                            '<p><select class="form-element-type" name="form[#{f}][element][#{i}][type]">' +
                            '<option>text</option><option>textarea</option><option has-values>dropdown</option><option has-values>multiselect</option>' +
                            '<option>file</option><option has-values>checkbox</option><option has-values>radio</option><option>hidden</option>' +
                            '</select><button class="form-element-value-add hidden">add value</button></p>' +
                            '</div>',

                elementValue: '<div class="form-element-value">' +
                              '<label>value</label>' +
                              '<input name="form[#{f}][element][#{i}][value][]" value=""/>' +
                              '<button class="form-element-value-delete">delete</button>' +
                              '</div>'
            }
        };

    },
    init: function () {
        var that = this;

        // init form actions
        this.initEnctype(this.config.form.fields.enctype);
        this.initElementAdd(this.config.form.buttons.addElement);

        // init form-element actions
        this.initElementDelete(this.config.form.buttons.deleteElement);
        this.initElementValues(this.config.form.fields.elementType);

        // init form-element-value actions
        this.initElementValueAdd(this.config.form.buttons.addElementValue);
        this.initElementValueDelete(this.config.form.buttons.deleteElementValue);

    },
    initEnctype: function(enctype) {
        var that = this;
        $$(enctype).each(function (item) {
            var formBlock = $(item).up(that.config.form.blocks.main),
                formMethod = formBlock.down(that.config.form.fields.method);
                if (formMethod.value == 'get') {
                    item.writeAttribute('disabled', 'disabled');
                }
            formMethod.observe('change', function (event) {
                (this.value == 'get')
                    ? item.writeAttribute('disabled', 'disabled')
                    : item.writeAttribute('disabled', null);
            });
        });
    },
    initElementAdd: function(addButton) {
        var that = this;
        $$(addButton).each(function(item) {
            var formBlock = $(item).up(that.config.form.blocks.main);
            $(item).observe('click', function(event) {
                event.stop();
                var template = new Template(that.config.templates.element);
                var elementNum = formBlock.getElementsBySelector(that.config.form.blocks.element).length;
                var formId = formBlock.id ? formBlock.id : 0;
                var data = {f: formId, i: elementNum };
                var t = template.evaluate(data);
                formBlock.down(that.config.form.buttons.addElement)
                    .insert({ before: t});
            });
        });
    },
    initElementDelete: function(deleteElement) {
        var that = this;
            $(document).on('click', deleteElement, function(event) {
                event.stop();
                var elementBlock = $(event.target).up(that.config.form.blocks.element);
                elementBlock.remove();
            });
    },
    initElementValues: function(elementType) {
        var that = this;
        $(document).on('change', elementType, function (event) {
            var typeBlock = $(event.target);
            var addValueButton = typeBlock.adjacent(that.config.form.buttons.addElementValue)[0];
            if (typeBlock.options[typeBlock.selectedIndex].hasAttribute('has-values')) {
                addValueButton.removeClassName('hidden');
            } else {
                addValueButton.addClassName('hidden');
                typeBlock.adjacent(that.config.form.blocks.elementValue).each(function(item) {
                    item.remove();
                });
            }
        });
    },
    initElementValueAdd: function(addValue) {
        var that = this;
        $(document).on('click', addValue, function(event) {
            event.stop();
            var addButton = $(event.target);
            var formBlock = $(addButton).up(that.config.form.blocks.main);

            var formId = formBlock ? formBlock.id : 0;
            var elementBlock = addButton.up(that.config.form.blocks.element);
            var elementId = elementBlock.id.split('_')[1];

            var valueTemplate = new Template(that.config.templates.elementValue);
            var data = {f : formId, i: elementId };
            var res = valueTemplate.evaluate(data);

            addButton.insert({ after: res});

        });
    },
    initElementValueDelete: function (deleteValue) {
        var that = this;
        $(document).on('click', deleteValue, function(event) {
            event.stop();
            $(event.target).closest(that.config.form.blocks.elementValue).remove();
        });
    }
});
