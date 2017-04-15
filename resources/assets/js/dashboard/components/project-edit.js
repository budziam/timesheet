import Laravel from '../../common/laravel';
import VForm from '../../common/components/form';

module.exports = {
    template: require('html!./project-edit.html'),

    props: {
        projectId: [Number, String],
    },

    data() {
        return {
            project: {},
            formAction: Laravel.url('/dashboard/api/projects/' + this.projectId)
        }
    },

    created() {
        this.getProject(this.projectId);
    },

    methods: {
        getProject(id) {
            let component = this;

            axios.get(Laravel.url('/dashboard/api/projects/' + id))
                .then(response => component.project = response.data)
                .catch(error => Event.requestError(error));
        },

        getFormData() {
            let formData = $.extend({}, this.project);

            formData.ends_at = str_replace('T', ' ', formData.ends_at);

            return formData;
        },

        onFormSuccess(response) {
            window.location = Laravel.url('/dashboard/projects');
        }
    },

    components: {
        VForm
    }
};