import FormMixin from '../mixins/form';

export default {
    template: require('html!./work-log-create.html'),

    mixins: [FormMixin],

    props: {
        data: Object
    },

    data() {
        return {
            project: ''
        }
    },

    methods: {
        onSuccess() {
            window.location.replace(this.data.projectsUrl);
        }
    }
}