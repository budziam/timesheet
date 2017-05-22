import VCalendar from '../components/calendar/core';
import ModalTime from '../components/calendar/modal-time';
import Moment from 'moment';

export default {
    template: require('html!./work-log-sync.html'),

    props: {
        data: Object
    },

    data() {
        return {
            projectId: this.data.projectSelected,
            project: null,
            eventAddDate: null,
            showEventAdd: false,
        };
    },

    mounted() {
        this.fetchProject();
    },

    methods: {
        onDayRender(date, cell) {
            if (!this.isDateValid(date)) {
                return;
            }

            let title = this.$trans('Dodaj godziny');

            $(`<button class="btn btn-default fc-log-time">${title}</button>`)
                .appendTo(cell)
                .click(() => this.displayEventAdd(date.format()));
        },

        displayEventAdd(date) {
            if (!this.isDateValid(date)) {
                return;
            }

            this.eventAddDate = date;
            this.showEventAdd = true;
        },

        onSaveEventAdd(data) {
            this.addEvent(data);
        },

        onExitEventAdd() {
            this.showEventAdd = false;
            this.eventAddDate = null;
        },

        addEvent(data) {
            this.$refs.calendar
                .createEvent(this.eventAddDate, data.fieldwork, data.office, data.comment, this.project);
        },

        fetchProject() {
            this.project = null;

            if (!this.projectId) {
                return;
            }

            let component = this;

            axios.get('/api/projects/' + this.projectId)
                .then(response => component.project = response.data)
                .catch(error => Event.requestError(error));
        },

        isDateValid(date) {
            if (Moment().endOf('day').isBefore(date)) {
                return false;
            }

            if (Moment(this.project.ends_at).endOf('day').isBefore(Moment())) {
                return false;
            }

            return true;
        }
    },

    computed: {
        workLogsUrl() {
            return '/api/search/work-logs/fullcalendar-sync?project_id=' + this.projectId;
        }
    },

    watch: {
        projectId() {
            this.fetchProject();
        }
    },

    components: {
        VCalendar,
        ModalTime
    }
};