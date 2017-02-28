module.exports = {
    template: require('html!./form.html'),

    props: {
        method: String,
        action: String,
        class: String
    },

    data() {
        return {
            isOccupied: false,
            isReady: false
        }
    },

    computed: {
        normalizedMethod() {
            return (this.method + '').toLowerCase();
        },

        normalizedAction() {
            return this.action;
        },

        normalizedClass() {
            return this.class;
        }
    },

    methods: {
        onSubmit() {
            if (this.isOccupied) {
                Event.notify('Form is occupied');
                return;
            }

            this.beforeSend();
            axios[this.normalizedMethod](this.action, this.getFormData())
                .then(this.onSuccess.bind(this))
                .catch(this.onError.bind(this))
                .finally(this.afterSend.bind(this));
        },

        beforeSend() {
            $(this.$el).find('.help-block')
                .remove();

            $(this.$el).find("[id^=form_]")
                .closest('.form-group')
                .removeClass('has-error');

            this.isOccupied = true;
            Event.startLoader();

            this.$emit('work');
        },

        afterSend() {
            this.isOccupied = false;
            Event.stopLoader();

            this.$emit('done');
        },

        onSuccess(response) {
            this.$emit('success', response);
        },

        onError(response) {
            if (response.status == 422) {
                this.onFormValidationError(response.data);
                return;
            }

            Event.requestError(response);
        },

        onFormValidationError(response) {
            $.each(response, this.displayValidationError.bind(this));
        },

        displayValidationError(key, value) {
            var element = $(this.$el).find('#' + this.getElementId(key));

            if (!element.length) {
                return;
            }

            element.closest('.form-group')
                .addClass('has-error');

            element.parent()
                .append($('<span>', {
                    class: 'help-block',
                    html: value.join('<br />')
                }));
        },

        getFormData: function () {
            var obj = {};

            $(this.$el).serializeArray()
                .forEach(function (item) {
                    var multiple = item.name.endsWith('[]');
                    var name = multiple ? item.name.slice(0, -2) : item.name;

                    if (typeof obj[name] == 'undefined') {
                        obj[name] = multiple ? [item.value] : item.value;
                        return true;
                    }

                    if (Object.prototype.toString.call(obj[name]) === '[object Array]') {
                        obj[name].push(item.value);
                        return true;
                    }

                    obj[name] = item.value;
                });

            return obj;
        },

        getElementId(key) {
            return 'form_' + key;
        }
    }
};