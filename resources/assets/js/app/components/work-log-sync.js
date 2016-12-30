import FormMixin from '../mixins/form';

export default {
    template: require('html!./work-log-sync.html'),

    mixins: [FormMixin],

    props: {
        data: Object
    },

    data() {
        return {
            project: this.data.projectSelected
        }
    },

    methods: {
        onSuccess() {
            window.location.replace(this.data.projectsUrl);
        }
    }
}