import Laravel from '../../common/laravel';
import ModelCreateUpdateMixin from '../mixins/model-createedit';
import WorkLogTime from '../../common/components/work-log-time';
import Moment from 'moment';

export default {
    template: require('html!./work-log-createedit.html'),

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

                    component.model = workLog;
                })
                .catch(error => Event.requestError(error));
        },

        getFormData() {
            let formData = Object.assign({}, this.model);

            formData.time_fieldwork = WorkLogTime.prettyToInt(formData.time_fieldwork);
            formData.time_office = WorkLogTime.prettyToInt(formData.time_office);

            return formData;
        },

        onCreated(response) {
            let id = response.data.id;

            window.location = Laravel.url(`/dashboard/work-logs/${id}/edit`);
        },

        onEdited() {
            window.location = Laravel.url('/dashboard/work-logs');
        },

        destroy() {
            axios.delete(Laravel.url('/dashboard/api/work-logs/' + this.modelId))
                .then(response => {
                    window.location = Laravel.url('/dashboard/work-logs');
                })
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