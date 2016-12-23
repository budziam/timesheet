export default {
    template: require('html!./work-log-create.html'),

    props: {
        data: Object
    },

    data() {
        return {
            project: {}
        }
    }
}