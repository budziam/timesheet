import Laravel from '../../../common/laravel';
import ModelCreateUpdateMixin from '../../mixins/model-createedit';
import WorkLogTime from '../../../common/components/work-log-time';
import Moment from 'moment';

export default {
    template: require('./work-log-createedit.html'),

    mixins: [
        ModelCreateUpdateMixin
    ],

    data() {
        return {
            model: {
                project: {},
                user: {}
            }
        }
    },

    methods: {
        getModel() {
            let component = this;

            axios.get(Laravel.url('/dashboard/api/work-logs/' + this.modelId))
                .then(response => {
                    let workLog = response.data;

                    workLog.created_at = Moment(workLog.created_at).format('YYYY-MM-DDThh:mm:ss');
                    workLog.updated_at = Moment(workLog.updated_at).format('YYYY-MM-DDThh:mm:ss');
                    workLog.date = Moment(workLog.date).format('YYYY-MM-DD');
                    workLog.time_fieldwork = WorkLogTime.timePretty(workLog.time_fieldwork);
                    workLog.time_office = WorkLogTime.timePretty(workLog.time_office);

                    component.$refs.project.select({id: workLog.project.id, text: workLog.project.name});
                    component.$refs.user.select({id: workLog.user.id, text: workLog.user.fullname});

                    component.model = workLog;
                })
                .catch(error => Event.requestError(error));
        },

        getFormData() {
            let formData = Object.assign({}, this.model);

            formData.time_fieldwork = WorkLogTime.prettyToInt(formData.time_fieldwork);
            formData.time_office = WorkLogTime.prettyToInt(formData.time_office);
            formData.project_id = formData.project.id;
            formData.user_id = formData.user.id;

            return formData;
        },

        onCreated(response) {
            const id = response.data.id;
            window.location = Laravel.url(`/dashboard/work-logs/${id}/edit`);
        },

        onEdited() {
            window.location = Laravel.url('/dashboard/work-logs');
        },

        destroy() {
            if (!confirm(this.$trans('Do you really want to delete it?'))) {
                return;
            }

            axios.delete(Laravel.url('/dashboard/api/work-logs/' + this.modelId))
                .then(() => window.location = Laravel.url('/dashboard/work-logs'))
                .catch(error => Event.requestError(error));
        }
    },

    computed: {
        formAction() {
            if (this.isCreating) {
                return Laravel.url('/dashboard/api/work-logs');
            }

            return Laravel.url(`/dashboard/api/work-logs/${this.modelId}`);
        },

        formClass() {
            if (this.isCreating) {
                return 'work-log-create';
            }

            return 'work-log-edit';
        }
    }
};