import VCalendar from '../components/calendar/core';
import WorkLogTime from '../../common/components/work-log-time';

export default {
    template: require('./work-log-index.html'),

    components: {
        VCalendar
    },

    data() {
        return {
            projects: [],
        }
    },

    methods: {
        onAllRender(calendar) {
            let projects = new Map();

            calendar.calendar.clientEvents().forEach(event => {
                let project = event.project;

                if (!projects.has(project.id)) {
                    projects.set(project.id, Object.assign(project, {
                        office: 0,
                        fieldwork: 0,
                    }));
                }

                projects.get(project.id).office += event.time_office;
                projects.get(project.id).fieldwork += event.time_fieldwork;
            });

            this.projects = Array.from(projects.values())
                .map(project => {
                    project.office = WorkLogTime.timePretty(project.office);
                    project.fieldwork = WorkLogTime.timePretty(project.fieldwork);

                    return project;
                });
        },

        getWorkLogUrl(project) {
            return '/work-logs/sync#' + project.id;
        },
    }
}
