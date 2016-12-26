window.Event = new Vue({
    methods: {
        notify(message) {
            this.$emit('notify', message);
        },

        startLoader() {
            this.$emit('start-loader');
        },

        stopLoader() {
            this.$emit('stop-loader');
        }
    }
});