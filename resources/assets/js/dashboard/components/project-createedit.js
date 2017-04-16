import Laravel from '../../common/laravel';
import VForm from '../../common/components/form';
import Moment from 'moment';

export default {
    template: require('html!./project-createedit.html'),

    props: {
        projectId: [Number, String],
    },

    data() {
        return {
            project: {
                color: '#b0b0b0'
            }
        }
    },

    created() {
        if (this.isEditing) {
            this.getProject(this.projectId);
        }
    },

    methods: {
        getProject() {
            let component = this;

            axios.get(Laravel.url('/dashboard/api/projects/' + this.projectId))
                .then(response => {
                    let project = response.data;

                    project.ends_at = Moment(project.ends_at).format('YYYY-MM-DDThh:mm');
                    project.created_at = Moment(project.created_at).format('YYYY-MM-DDThh:mm:ss');
                    project.updated_at = Moment(project.updated_at).format('YYYY-MM-DDThh:mm:ss');

                    component.project = project;
                })
                .catch(error => Event.requestError(error));
        },

        getFormData() {
            let formData = Object.assign({}, this.project);

            formData.ends_at = Moment(formData.ends_at).format('YYYY-MM-DD hh:mm:ss');

            return formData;
        },

        onFormSuccess(response) {
            if (this.isCreating) {
                return this.onCreated(response);
            }

            return this.onEdited();
        },

        onCreated(response) {
            let id = response.data.id;

            window.location = Laravel.url(`/dashboard/projects/${id}/edit`);
        },

        onEdited() {
            window.location = Laravel.url('/dashboard/projects');
        },

        destroy() {
            axios.delete(Laravel.url('/dashboard/api/projects/' + this.projectId))
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
        isCreating() {
            return this.projectId == null;
        },

        isEditing() {
            return !this.isCreating;
        },

        formMethod() {
            if (this.isCreating) {
                return 'POST';
            }

            return 'PATCH';
        },

        formAction() {
            if (this.isCreating) {
                return Laravel.url('/dashboard/api/projects');
            }

            return Laravel.url(`/dashboard/api/projects/${this.projectId}`);
        },

        formClass() {
            if (this.isCreating) {
                return 'project-create';
            }

            return 'project-edit';
        }
    },

    components: {
        VForm
    }
};