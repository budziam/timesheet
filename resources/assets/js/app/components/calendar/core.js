require('fullcalendar');
require('fullcalendar/dist/locale/pl');

import ModalTime from './modal-time';

module.exports = {
    template: require('html!./core.html'),

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
            this.eventEditRaw = $.extend({}, event);
            this.eventEdit = {
                fieldwork: this.timePretty(this.eventEditRaw.time_fieldwork),
                office: this.timePretty(this.eventEditRaw.time_office),
                comment: this.eventEditRaw.comment
            };
            this.showEventEdit = true;
        },

        onCloseEventEdit(data) {
            this.updateEvent(data);

            this.showEventEdit = false;
            this.eventEdit = {};
            this.eventEditRaw = {};
        },

        createEvent(date, fieldwork, office, project, comment = '') {
            let event = {
                title: project.name,
                date: date,
                project_id: project.id,
                time_fieldwork: this.prettyToInt(fieldwork),
                time_office: this.prettyToInt(office),
                comment: comment,
                backgroundColor: project.color,
            };

            if (event.time_fieldwork <= 0 && event.time_office <= 0) {
                return false;
            }

            axios.post('/api/projects/' + event.project_id + '/work-logs', {
                day: event.date,
                time_fieldwork: event.time_fieldwork,
                time_office: event.time_office,
                comment: event.comment
            })
                .then(function (response) {
                    event.id = response.data.id;

                    $(this.$refs.calendar).fullCalendar('renderEvent', event, false);

                    Event.notifySuccess('Work log was added properly');
                }.bind(this))
                .catch(error => Event.requestError(error));
        },

        updateEvent(data) {
            let event = $.extend(this.eventEditRaw, {
                time_fieldwork: this.prettyToInt(data.fieldwork),
                time_office: this.prettyToInt(data.office),
                comment: data.comment
            });

            if (event.time_fieldwork <= 0 && event.time_office <= 0) {
                axios.delete('/api/work-logs/' + event.id)
                    .then(function () {
                        $(this.$refs.calendar).fullCalendar('removeEvents', event.id);

                        Event.notifySuccess('Work log was removed');
                    }.bind(this))
                    .catch(error => Event.notifyDanger('Some problem occured while removing work log'));

                return;
            }

            axios.patch('/api/work-logs/' + event.id, {
                time_fieldwork: event.time_fieldwork,
                time_office: event.time_office,
                comment: event.comment
            })
                .then(function () {
                    $(this.$refs.calendar).fullCalendar('updateEvent', event);

                    Event.notifySuccess('Work log was updated');
                }.bind(this))
                .catch(error => Event.notifyDanger('Some problem occured while updating work log'));
        },

        renderAllWorkTime() {
            let times = this.getDateTimeSum();

            // Clear all work times
            $(this.$refs.calendar)
                .find('.fc-day .fc-work-time')
                .html('');

            $.each(times, function (key, value) {
                let time = this.timePretty(value);

                $(this.$refs.calendar)
                    .find('.fc-day[data-date="' + key + '"] .fc-work-time')
                    .html(`<span>${time}</span>`);
            }.bind(this));
        },

        getDateTimeSum() {
            let times = {};

            $(this.$refs.calendar)
                .fullCalendar('clientEvents')
                .forEach(function (event) {
                    if (!(event.date in times)) {
                        times[event.date] = 0;
                    }

                    times[event.date] += event.time_fieldwork + event.time_office;
                });

            return times;
        },

        timePretty(time) {
            let hours = Math.floor(time / 60 / 60);
            let minutes = Math.floor((time % 3600) / 60);
            minutes = str_pad(minutes, 2, '0', 'STR_PAD_LEFT');

            return `${hours}g ${minutes}m`;
        },

        prettyToInt(time) {
            let pattern = /(?:([0-9]+)\s*g)?\s*(?:([0-9]+)\s*m)?/;
            let result = pattern.exec(time);

            let hours = parseInt(result[1]) || 0;
            let minutes = parseInt(result[2]) || 0;

            return hours * 3600 + minutes * 60;
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

                dayClick(date, allDay, jsEvent, view)
                {
                    component.$emit('dayClicked', date, allDay, jsEvent, view);
                },

                eventClick(calEvent, jsEvent, view)
                {
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
                    let fieldwork = component.timePretty(event.time_fieldwork);
                    let office = component.timePretty(event.time_office);

                    element.find('.fc-content').append(`
                        <div class="fc-body">
                             Teren: ${fieldwork}<br />
                             Biuro: ${office}
                        </div>
                    `)
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