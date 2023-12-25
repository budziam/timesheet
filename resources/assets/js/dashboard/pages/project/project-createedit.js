import Laravel from '../../../common/laravel';
import ModelCreateUpdateMixin from '../../mixins/model-createedit';
import Moment from 'moment';

export default {
    template: require('./project-createedit.html'),

    mixins: [
        ModelCreateUpdateMixin
    ],

    data() {
        return {
            endsAtEnabled: false,
            colorEnabled: false,
            model: {
                color: '#b0b0b0',
                cost: '0.00',
                customer: {},
                groups: []
            }
        }
    },

    methods: {
        getModel() {
            const component = this;

            axios.get(Laravel.url('/dashboard/api/projects/' + this.modelId))
                .then(response => {
                    const project = response.data;

                    project.ends_at = project.ends_at ? Moment(project.ends_at).format('YYYY-MM-DD') : null;
                    project.created_at = Moment(project.created_at).format('YYYY-MM-DDThh:mm:ss');
                    project.updated_at = Moment(project.updated_at).format('YYYY-MM-DDThh:mm:ss');
                    project.value = project.value.toFixed(2);
                    project.cost = project.cost.toFixed(2);

                    component.$refs.groups.select(
                        project.groups.map(group => ({
                            id: group.id,
                            text: group.name
                        }))
                    );

                    project.customer_id = null;
                    if (project.customer) {
                        project.customer_id = project.customer.id;
                        component.$refs.customer.select({id: project.customer.id, text: project.customer.name});
                    }

                    if (project.ends_at) {
                        this.endsAtEnabled = true;
                    }

                    if (project.color) {
                        this.colorEnabled = true;
                    }

                    component.model = project;
                })
                .catch(error => Event.requestError(error));
        },

        getFormData() {
            let formData = Object.assign({}, this.model);

            formData.ends_at = this.endsAtEnabled ? Moment(formData.ends_at).format('YYYY-MM-DD') : null;
            formData.color = this.colorEnabled ? this.model.color : null;
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
            if (!confirm(this.$trans('Do you really want to delete it?'))) {
                return;
            }

            axios.delete(Laravel.url(`/dashboard/api/projects/${this.modelId}`))
                .then(() => window.location = Laravel.url('/dashboard/projects'))
                .catch(error => {
                    if (error.response.status === 422) {
                        Event.notifyDanger(error.response.data.errors.join('<br/>'));
                    } else {
                        Event.requestError(error);
                    }
                });
        },

        complete() {
            axios.post(Laravel.url(`/dashboard/api/projects/${this.modelId}/complete`))
                .then(() => window.location = Laravel.url('/dashboard/projects'))
                .catch(error => Event.requestError(error));
        },

        updateGroups(groups) {
            this.model.groups = groups.map(group => ({
                id: group
            }));
        },
    },

    computed: {
        statisticsUrl() {
            return Laravel.url(`/dashboard/statistics/projects/${this.modelId}`);
        },

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
        },

        ended() {
            return this.model.ends_at !== null;
        },

        valueNet() {
            const valueNet = Number(this.model.value) - Number(this.model.cost);
            return valueNet.toFixed(2);
        },
    }
};
