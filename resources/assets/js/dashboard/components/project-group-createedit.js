import Laravel from '../../common/laravel';
import ModelCreateUpdateMixin from '../mixins/model-createedit';
import Moment from 'moment';

export default {
    template: require('./project-group-createedit.html'),

    mixins: [
        ModelCreateUpdateMixin
    ],

    data() {
        return {
            model: {
                color: '#b0b0b0',
            }
        }
    },

    methods: {
        getModel() {
            let component = this;

            axios.get(Laravel.url('/dashboard/api/project-groups/' + this.modelId))
                .then(response => {
                    let projectGroup = response.data;

                    projectGroup.created_at = Moment(projectGroup.created_at).format('YYYY-MM-DDThh:mm:ss');
                    projectGroup.updated_at = Moment(projectGroup.updated_at).format('YYYY-MM-DDThh:mm:ss');

                    component.model = projectGroup;
                })
                .catch(error => Event.requestError(error));
        },

        getFormData() {
            return Object.assign({}, this.model);
        },

        onCreated(response) {
            let id = response.data.id;
            window.location = Laravel.url(`/dashboard/project-groups/${id}/edit`);
        },

        onEdited() {
            window.location = Laravel.url('/dashboard/project-groups');
        },

        destroy() {
            axios.delete(Laravel.url('/dashboard/api/project-groups/' + this.modelId))
                .then(response => window.location = Laravel.url('/dashboard/project-groups'))
                .catch(error => {
                    if (error.response.status === 422) {
                        Event.notifyDanger(error.response.data.errors.join('<br/>'));
                    } else {
                        Event.requestError(error);
                    }
                });
        }
    },

    computed: {
        formAction() {
            if (this.isCreating) {
                return Laravel.url('/dashboard/api/project-groups');
            }

            return Laravel.url(`/dashboard/api/project-groups/${this.modelId}`);
        },

        formClass() {
            if (this.isCreating) {
                return 'project-group-create';
            }

            return 'project-group-edit';
        }
    }
};