require('fullcalendar');
require('fullcalendar/dist/locale/pl');

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
            showEventEdit: false,
            eventEdit: {},
            eventEditRaw: {},
        }
    },

    mounted() {
        $(this.$refs.calendar).fullCalendar(this.getArgs());
    },

    methods: {
        displayEventEdit(event) {
            if (!event.editable) {
                return;
            }

            this.eventEditRaw = Object.assign({}, event);
            this.eventEdit = {
                fieldwork: WorkLogTime.timePretty(this.eventEditRaw.time_fieldwork),
                office: WorkLogTime.timePretty(this.eventEditRaw.time_office),
                comment: this.eventEditRaw.comment
            };
            this.showEventEdit = true;
        },

        onSaveEventEdit(data) {
            this.updateEvent(data);
        },

        onDestroyEventEdit() {
            const eventId = this.eventEditRaw.id;

            axios.delete('/api/work-logs/' + eventId)
                .then(() => {
                    $(this.$refs.calendar).fullCalendar('removeEvents', eventId);
                    Event.notifySuccess('Work log was removed');
                })
                .catch(error => Event.notifyDanger('Some problem occured while removing work log'));
        },

        onExitEventEdit() {
            this.showEventEdit = false;
            this.eventEdit = {};
            this.eventEditRaw = {};
        },

        createEvent(date, fieldwork, office, comment, project) {
            let event = {
                title: project.name,
                date: date,
                project: project,
                time_fieldwork: WorkLogTime.prettyToInt(fieldwork),
                time_office: WorkLogTime.prettyToInt(office),
                comment: comment,
                backgroundColor: project.color,
            };

            if (event.time_fieldwork <= 0 && event.time_office <= 0) {
                return false;
            }

            axios.post('/api/projects/' + event.project.id + '/work-logs', {
                date: event.date,
                time_fieldwork: event.time_fieldwork,
                time_office: event.time_office,
                comment: event.comment
            })
                .then(response => {
                    event.id = response.data.id;
                    event.editable = true;
                    event.color = project.color;

                    $(this.$refs.calendar).fullCalendar('renderEvent', event, false);
                    Event.notifySuccess('Work log was properly added');
                })
                .catch(error => Event.requestError(error));
        },

        updateEvent(data) {
            const before = this.formatEvent(this.eventEditRaw);
            const event = Object.assign({}, before, {
                comment: data.comment,
                time_fieldwork: WorkLogTime.prettyToInt(data.fieldwork),
                time_office: WorkLogTime.prettyToInt(data.office)
            });

            // There are no changes
            if (JSON.stringify(event) === JSON.stringify(before)) {
                return;
            }

            if (event.time_fieldwork <= 0 && event.time_office <= 0) {
                return;
            }

            axios.patch('/api/work-logs/' + event.id, {
                time_fieldwork: event.time_fieldwork,
                time_office: event.time_office,
                comment: event.comment
            })
                .then(() => {
                    $(this.$refs.calendar).fullCalendar('updateEvent', Object.assign({}, this.eventEditRaw, event));
                    Event.notifySuccess('Work log was updated');
                })
                .catch(error => Event.notifyDanger('Some problem occured while updating work log'));
        },

        formatEvent(event) {
            return {
                id: event.id,
                comment: event.comment,
                time_fieldwork: event.time_fieldwork,
                time_office: event.time_office,
            }
        },

        renderAllWorkTime() {
            let times = this.getDateTimeSum();

            // Clear all work times
            $(this.$refs.calendar)
                .find('.fc-day .fc-work-time')
                .html('');

            $.each(times, (key, value) => {
                const time = WorkLogTime.timePretty(value);
                $(this.$refs.calendar)
                    .find('.fc-day[data-date="' + key + '"] .fc-work-time')
                    .html(`<span>${time}</span>`);
            });
        },

        getDateTimeSum() {
            let times = {};

            $(this.$refs.calendar)
                .fullCalendar('clientEvents')
                .forEach(event => {
                    if (!(event.date in times)) {
                        times[event.date] = 0;
                    }

                    times[event.date] += event.time_fieldwork + event.time_office;
                });

            return times;
        },

        getArgs() {
            let component = this;

            let args = {
                locale: Laravel.lang,
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

                dayClick(date, allDay, jsEvent, view) {
                    component.$emit('dayClicked', date, allDay, jsEvent, view);
                },

                eventClick(calEvent, jsEvent, view) {
                    component.displayEventEdit(calEvent);

                    component.$emit('eventClicked', calEvent, jsEvent, view);
                },

                dayRender(date, cell) {
                    cell.append(`
                        <div class="fc-work-time"></div>
                    `);

                    component.$emit('dayRender', date, cell);
                },

                eventRender(event, element) {
                    const fieldwork = WorkLogTime.timePretty(event.time_fieldwork);
                    const office = WorkLogTime.timePretty(event.time_office);

                    element.find('.fc-title').text(`${event.project.lkz}, ${event.project.kerg}`);
                    element.find('.fc-title').after(`<div>${event.project.name}</div>`);

                    element.find('.fc-content').append(`
                        <div class="fc-body">
                             Teren: ${fieldwork}<br />
                             Biuro: ${office}
                        </div>
                    `);

                    if (event.editable) {
                        element.addClass('fc-editable');
                    }
                },

                eventAfterAllRender() {
                    component.renderAllWorkTime.bind(component)();

                    component.$emit('eventAfterAllRender', this);
                }
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
            $(this.$refs.calendar).fullCalendar('refetchEvents');
        }
    }
};