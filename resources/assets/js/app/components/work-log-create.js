export default {
    template: require('html!./work-log-create.html'),

    props: {
        data: Object
    },

    data() {
        return {
            project: {}
        }
    },

    mounted() {
        this.initDate();
    },

    methods: {
        initDate() {
            this.$refs.date.value = moment().format('YYYY-MM-DD');
        }
    }
}