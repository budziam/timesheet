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
            const projects = new Map();

            for (const event of calendar.getEvents()) {
                const props = event.extendedProps;
                const project = props.project;

                if (!projects.has(project.id)) {
                    projects.set(project.id, {
                        ...project,
                        time_office: 0,
                        time_fieldwork: 0,
                    });
                }

                const projectNode = projects.get(project.id);
                projects.set(project.id, {
                    ...projectNode,
                    time_office: projectNode.time_office + props.time_office,
                    time_fieldwork: projectNode.time_fieldwork + props.time_fieldwork,
                })
            }

            this.projects = [...projects.values()]
                .map(project => ({
                    ...project,
                    time_office: WorkLogTime.timePretty(project.time_office),
                    time_fieldwork: WorkLogTime.timePretty(project.time_fieldwork),
                }));
        },

        getWorkLogUrl(project) {
            return `/work-logs/sync#${project.id}`;
        },
    }
}
