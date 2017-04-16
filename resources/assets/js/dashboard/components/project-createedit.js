import Laravel from '../../common/laravel';
import ModelCreateUpdateMixin from '../mixins/model-createedit';
import Moment from 'moment';

export default {
    template: require('html!./project-createedit.html'),

    mixins: [
        ModelCreateUpdateMixin
    ],

    data() {
        return {
            model: {
                color: '#b0b0b0'
            }
        }
    },

    methods: {
        getModel() {
            let component = this;

            axios.get(Laravel.url('/dashboard/api/projects/' + this.modelId))
                .then(response => {
                    let project = response.data;

                    project.ends_at = Moment(project.ends_at).format('YYYY-MM-DDThh:mm');
                    project.created_at = Moment(project.created_at).format('YYYY-MM-DDThh:mm:ss');
                    project.updated_at = Moment(project.updated_at).format('YYYY-MM-DDThh:mm:ss');

                    component.model = project;
                })
                .catch(error => Event.requestError(error));
        },

        getFormData() {
            let formData = Object.assign({}, this.model);

            formData.ends_at = Moment(formData.ends_at).format('YYYY-MM-DD hh:mm:ss');

            return formData;
        },

        onCreated(response) {
            let id = response.data.id;

            window.location = Laravel.url(`/dashboard/projects/${id}/edit`);
        },

        onEdited() {
            window.location = Laravel.url('/dashboard/projects');
        },

        destroy() {
            axios.delete(Laravel.url('/dashboard/api/projects/' + this.modelId))
                .then(response => {
                    window.location = Laravel.url('/dashboard/projects');
                })
                .catch(error => {
                    if (error.response.status === 422) {
                        Event.notifyDanger(error.response.data.join('<br/>'));
                    } else {
                        Event.requestError(error);
                    }
                });
        }
    },

    computed: {
        formAction() {
            if (this.isCreating) {
                return Laravel.url('/dashboard/api/projects');
            }

            return Laravel.url(`/dashboard/api/projects/${this.modelId}`);
        },

        formClass() {
            if (this.isCreating) {
                return 'project-create';
            }

            return 'project-edit';
        }
    }
};