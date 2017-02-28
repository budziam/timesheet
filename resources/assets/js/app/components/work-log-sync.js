import ModalTime from '../../common/components/calendar/modal-time';

module.exports = {
    template: require('html!./work-log-sync.html'),

    components: {
        ModalTime
    },

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

    methods: {
        onDayRender(date, cell) {
            let component = this;

            let title = this.$trans('Dodaj godziny');

            let addButton = cell.append(`
                <button class="btn btn-default fc-log-time">${title}</button>
            `);

            addButton.click(function () {
                component.displayEventAdd(date);
            });
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
                .createEvent(this.project.name, this.eventAddDate, data.fieldwork, data.office);
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
                .catch(response => Event.requestError(response));
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
    }
};