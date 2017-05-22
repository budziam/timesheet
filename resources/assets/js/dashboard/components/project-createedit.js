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
            endsAtEnabled: false,
            model: {
                color: '#b0b0b0',
                groups: []
            }
        }
    },

    methods: {
        getModel() {
            let component = this;

            axios.get(Laravel.url('/dashboard/api/projects/' + this.modelId))
                .then(response => {
                    let project = response.data;

                    project.ends_at = project.ends_at ? Moment(project.ends_at).format('YYYY-MM-DD') : null;
                    project.created_at = Moment(project.created_at).format('YYYY-MM-DDThh:mm:ss');
                    project.updated_at = Moment(project.updated_at).format('YYYY-MM-DDThh:mm:ss');

                    component.$refs.groups.select(
                        project.groups.map(group => {
                            return {
                                id: group.id,
                                text: group.name
                            }
                        })
                    );

                    if (project.ends_at) {
                        this.endsAtEnabled = true;
                    }

                    component.model = project;
                })
                .catch(error => Event.requestError(error));
        },

        getFormData() {
            let formData = Object.assign({}, this.model);

            formData.ends_at = this.endsAtEnabled ? Moment(formData.ends_at).format('YYYY-MM-DD') : null;
            formData.groups = formData.groups.map(group => group.id);

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
                .then(() => {
                    window.location = Laravel.url('/dashboard/projects');
                })
                .catch(error => {
                    if (error.response.status === 422) {
                        Event.notifyDanger(error.response.data.join('<br/>'));
                    } else {
                        Event.requestError(error);
                    }
                });
        },

        updateGroups(groups) {
            this.model.groups = groups.map(group => {
                return {
                    id: group
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