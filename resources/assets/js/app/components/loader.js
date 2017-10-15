export default {
    template: require('./loader.html'),

    data() {
        return {
            counter: 0
        }
    },

    created() {
        Event.$on('start-loader', function () {
            setTimeout(this.showLoader.bind(this), 500);
        }.bind(this));

        Event.$on('stop-loader', () => {
            this.hideLoader();
        });
    },

    methods: {
        showLoader() {
            this.counter += 1;
        },

        hideLoader() {
            this.counter -= 1;
        }
    },

    computed: {
        display() {
            return this.counter > 0;
        }
    }
}