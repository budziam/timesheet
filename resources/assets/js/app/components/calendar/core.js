import { Calendar } from '@fullcalendar/core';
import interactionPlugin from '@fullcalendar/interaction';
import dayGridPlugin from '@fullcalendar/daygrid';
import plLocale from '@fullcalendar/core/locales/pl';
import { debounce } from "lodash";
import moment from 'moment';

import ModalTime from './modal-time';
import WorkLogTime from '../../../common/components/work-log-time';

export default {
    template: require('./core.html'),

    components: {
        ModalTime
    },

    props: {
        url: [String, Object]
    },

    data() {
        return {
            calendar: null,
            eventEdit: null,
            renderAllWorkTimeDebounced: debounce(this.renderAllWorkTime, 50),
        }
    },

    mounted() {
        this.calendar = new Calendar(this.$refs.calendar, this.getArgs());
        this.calendar.render();
    },

    methods: {
        displayEventEdit(event) {
            if (!event.durationEditable) {
                return;
            }

            const props = event.extendedProps;

            this.eventEdit = {
                id: event.id,
                comment: props.comment,
                project_lkz: props.project.lkz,
                fieldwork: WorkLogTime.timePretty(props.time_fieldwork),
                office: WorkLogTime.timePretty(props.time_office),
            };
        },

        onSaveEventEdit(data) {
            this.updateEvent(data);
        },

        onDestroyEventEdit() {
            const eventId = this.eventEdit.id;

            axios.delete(`/api/work-logs/${eventId}`)
                .then(() => {
                    const eventNode = this.calendar.getEventById(eventId);
                    if (eventNode) {
                        eventNode.remove();
                    }
                    Event.notifySuccess('Work log was removed');
                })
                .catch(error => Event.notifyDanger('Some problem occured while removing work log'));
        },

        onExitEventEdit() {
            this.eventEdit = null;
        },

        createEvent(date, fieldwork, office, comment, project) {
            const event = {
                title: project.name,
                date: date,
                project: project,
                time_fieldwork: WorkLogTime.prettyToInt(fieldwork),
                time_office: WorkLogTime.prettyToInt(office),
                comment: comment,
                backgroundColor: project.color,
                editable: true,
            };

            if (event.time_fieldwork <= 0 && event.time_office <= 0) {
                return false;
            }

            axios.post(`/api/projects/${event.project.id}/work-logs`, {
                date: event.date,
                time_fieldwork: event.time_fieldwork,
                time_office: event.time_office,
                comment: event.comment
            })
                .then(response => {
                    this.calendar.addEvent({
                        ...event,
                        id: response.data.id,
                    });
                    Event.notifySuccess('Work log was properly added');
                })
                .catch(error => Event.requestError(error));
        },

        updateEvent(data) {
            const before = {
                id: this.eventEdit.id,
                comment: this.eventEdit.comment,
                time_fieldwork: WorkLogTime.prettyToInt(this.eventEdit.fieldwork),
                time_office: WorkLogTime.prettyToInt(this.eventEdit.office),
            };
            const event = {
                id: this.eventEdit.id,
                comment: data.comment,
                time_fieldwork: WorkLogTime.prettyToInt(data.fieldwork),
                time_office: WorkLogTime.prettyToInt(data.office),
            };

            if (event.time_fieldwork <= 0 && event.time_office <= 0) {
                return;
            }

            // There are no changes
            if (JSON.stringify(event) === JSON.stringify(before)) {
                return;
            }

            axios.patch(`/api/work-logs/${event.id}`, {
                time_fieldwork: event.time_fieldwork,
                time_office: event.time_office,
                comment: event.comment
            })
                .then(() => {
                    const eventNode = this.calendar.getEventById(event.id);
                    eventNode.setExtendedProp('comment', event.comment);
                    eventNode.setExtendedProp('time_fieldwork', event.time_fieldwork);
                    eventNode.setExtendedProp('time_office', event.time_office);
                    Event.notifySuccess('Work log was updated');
                })
                .catch(error => {
                    console.error(error);
                    Event.notifyDanger('Some problem occured while updating work log');
                });
        },

        renderAllWorkTime() {
            const calendarEl = $(this.calendar.el);
            const times = this.getDateTimeSum();

            // Clear all work times
            calendarEl
                .find('.fc-day .fc-work-time')
                .html('');

            for (const [key, value] of times.entries()) {
                const time = WorkLogTime.timePretty(value);
                calendarEl
                    .find(`.fc-day[data-date="${key}"] .fc-work-time`)
                    .html(`<span>${time}</span>`);
            }

            this.$emit('all-render', this.calendar);
        },

        /**
         * @returns {Map<string, number>}
         */
        getDateTimeSum() {
            const times = new Map();

            for (const event of this.calendar.getEvents()) {
                const date = moment(event.start).format("YYYY-MM-DD");
                const props = event.extendedProps;
                const time = (times.get(date) || 0) + props.time_fieldwork + props.time_office;
                times.set(date, time)
            }

            return times;
        },

        getArgs() {
            const component = this;

            const args = {
                locale: plLocale,
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month'
                },
                height: "auto",
                allDaySlot: false,
                slotEventOverlap: false,
                firstDay: 1,
                timeFormat: 'HH:mm',
                plugins: [dayGridPlugin, interactionPlugin],

                eventClick({event}) {
                    component.displayEventEdit(event);
                },

                dayRender({date, el}) {
                    $(el).append(`
                        <div class="fc-work-time"></div>
                    `);

                    component.$emit('day-render', date, $(el));
                },

                eventRender({event, el}) {
                    const element = $(el);
                    const props = event.extendedProps;

                    const fieldwork = WorkLogTime.timePretty(props.time_fieldwork);
                    const office = WorkLogTime.timePretty(props.time_office);

                    element.find('.fc-title').text(`${props.project.lkz}, ${props.project.kerg}`);
                    element.find('.fc-title').after(`<div>${props.project.name}</div>`);
                    element.find('.fc-content').append(`
                        <div class="fc-body">
                             Teren: ${fieldwork}<br />
                             Biuro: ${office}
                        </div>
                    `);

                    if (event.durationEditable) {
                        element.addClass('fc-editable');
                    }

                    component.renderAllWorkTimeDebounced();
                },
            };

            if (this.url) {
                if (typeof this.url === 'string') {
                    args.events = {
                        type: 'GET',
                        url: this.url
                    }
                } else {
                    args.events = {
                        type: 'GET',
                        url: this.url.url,
                        data() {
                            return component.url.data;
                        }
                    }
                }
            }

            return args;
        }
    },

    watch: {
        url() {
            this.calendar.refetchEvents();
        }
    }
};
