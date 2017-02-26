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
            project: this.data.projectSelected,
            eventAdd: {},
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
            this.showEventAdd = true;
        },

        onCloseEventAdd(data) {
            this.addEvent(data);

            this.showEventAdd = false;
            this.eventAdd = {};
        },

        addEvent(data) {
            this.$refs.calendar
                .createEvent(this.project, '', data.fieldwork, data.office);
        },
    },

    computed: {
        workLogsUrl() {
            return {
                url: this.data.workLogsSearchUrl,
                data: {
                    project_id: this.project
                }
            };
        }
    }
}