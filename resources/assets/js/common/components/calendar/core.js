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
            console.log(event);

            this.eventEditRaw = event;
            this.eventEdit = {
                fieldwork: this.timePretty(event.time_fieldwork),
                office: this.timePretty(event.time_office),
            };
            this.showEventEdit = true;
        },

        onCloseEventEdit(data) {
            this.updateEvent(data);

            this.showEventEdit = false;
            this.eventEdit = {};
            this.eventEditRaw = {};
        },

        createEvent(project, date, fieldwork, office) {
            let event = {
                title: '',
                date: date,
                time_fieldwork: this.prettyToInt(fieldwork),
                time_office: this.prettyToInt(office),
            };

            $(this.$refs.calendar).fullCalendar('renderEvent', event, true);
        },

        updateEvent(data) {
            let event = $.extend(this.eventEditRaw, {
                time_fieldwork: this.prettyToInt(data.fieldwork),
                time_office: this.prettyToInt(data.office),
            });

            $(this.$refs.calendar).fullCalendar('updateEvent', event);
        },

        timePretty(time) {
            let hours = Math.floor(time / 60 / 60);
            let minutes = Math.floor((time % 3600) / 60);

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
                    let calendar = this;
                    let times = {};

                    this.calendar
                        .clientEvents()
                        .forEach(function (event) {
                            if (!(event.date in times)) {
                                times[event.date] = 0;
                            }

                            times[event.date] += event.time_fieldwork + event.time_office;
                        });

                    $.each(times, function (key, value) {
                        let time = component.timePretty(value);

                        calendar.el
                            .find('.fc-day[data-date="' + key + '"] .fc-work-time')
                            .html(`<span>${time}</span>`);
                    });

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