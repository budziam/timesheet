window.Event = new Vue({
    methods: {
        notifySuccess(message, params) {
            this.$emit('notify', 'success', message, params);
        },

        notifyInfo(message, params) {
            this.$emit('notify', 'info', message, params);
        },

        notifyWarning(message, params) {
            this.$emit('notify', 'warning', message, params);
        },

        notifyDanger(message, params) {
            this.$emit('notify', 'danger', message, params);
        },

        startLoader() {
            this.$emit('start-loader');
        },

        stopLoader() {
            this.$emit('stop-loader');
        },

        requestError(error) {
            if (error.response) {
                this.notifyDanger(error.response.status + ': ' + error.response.statusText);
            }
        }
    }
});