import VCalendar from '../components/calendar/core';
import ModalTime from '../components/calendar/modal-time';
import Moment from 'moment';

export default {
    template: require('./work-log-sync.html'),

    data() {
        return {
            projectId: null,
            project: null,
            eventAddDate: null,
            showEventAdd: false,
        };
    },

    mounted() {
        this.readProjectId();
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
                .then(response => {
                    component.project = response.data;
                    component.$refs.project.select({
                        id: component.project.id,
                        text: component.project.lkz + ', ' + component.project.kerg + ' ' + component.project.name,
                    });
                })
                .catch(error => Event.requestError(error));
        },

        readProjectId() {
            if (!window.location.hash) {
                return;
            }

            const projectId = parseInt(window.location.hash.substring(1));
            if (isNaN(projectId)) {
                return;
            }

            this.projectId = projectId;
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
        projectId(newVal, oldVal) {
            if (parseInt(oldVal) !== parseInt(newVal)) {
                this.fetchProject();
            }
        }
    },

    components: {
        VCalendar,
        ModalTime
    }
};