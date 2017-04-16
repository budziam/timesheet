import VCalendar from '../components/calendar/core';
import ModalTime from '../components/calendar/modal-time';

export default {
    template: require('html!./work-log-sync.html'),

    props: {
        data: Object
    },

    data() {
        return {
            projectId: this.data.projectSelected,
            project: null,
            eventAdd: null,
            eventAddDate: null,
            showEventAdd: false,
        };
    },

    mounted() {
        this.fetchProject();
    },

    methods: {
        onDayRender(date, cell) {
            let title = this.$trans('Dodaj godziny');

            $(`<button class="btn btn-default fc-log-time">${title}</button>`)
                .appendTo(cell)
                .click(function () {
                    this.displayEventAdd(date.format());
                }.bind(this));
        },

        displayEventAdd(date) {
            this.eventAdd = {
                timeFieldwork: '',
                timeOffice: '',
            };
            this.eventAddDate = date;
            this.showEventAdd = true;
        },

        onCloseEventAdd(data) {
            this.addEvent(data);

            this.showEventAdd = false;
            this.eventAdd = null;
            this.eventAddDate = null;
        },

        addEvent(data) {
            this.$refs.calendar
                .createEvent(this.eventAddDate, data.fieldwork, data.office, this.project);
        },

        fetchProject() {
            if (!this.projectId) {
                this.project = null;
                return;
            }

            let component = this;

            axios.get('/api/projects/' + this.projectId)
                .then((response) => {
                    component.project = response.data;
                })
                .catch(error => Event.requestError(error));
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