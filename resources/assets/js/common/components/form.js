module.exports = {
    template: require('./form.html'),

    props: {
        method: String,
        action: String,
        formData: Function,
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
    },

    methods: {
        onSubmit() {
            if (this.isOccupied) {
                Event.notifyInfo('Form is occupied');
                return;
            }

            this.beforeSend();

            axios[this.normalizedMethod](this.action, this.formData())
                .then(this.onSuccess.bind(this))
                .catch(this.onError.bind(this))
                .then(this.afterSend.bind(this));
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

        onError(error) {
            let response = error.response;

            if (response.status === 422) {
                this.onFormValidationError(response.data);
                return;
            }

            Event.requestError(response);
        },

        onFormValidationError(response) {
            $.each(response['errors'], this.displayValidationError.bind(this));
        },

        displayValidationError(key, value) {
            let element = $(this.$el).find('#' + this.getElementId(key));

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

        getElementId(key) {
            return 'form_' + key;
        }
    }
};