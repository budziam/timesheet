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
            showTimeEdit: false,
            editEvent: {},
            editEventRaw: {},
        }
    },

    mounted() {
        $(this.$refs.cal).fullCalendar(this.getArgs());
    },

    methods: {
        displayEventEdit(event) {
            this.showTimeEdit = true;
            this.editEventRaw = event;
            this.editEvent = {
                project: event.title,
                timeFieldwork: this.timePretty(event.time_fieldwork),
                timeOffice: this.timePretty(event.time_office),
            };
        },

        hideEventEdit() {
            this.showTimeEdit = false;
            this.editEvent = {};
        },

        updateEvent(data) {
            this.editEventRaw.time_fieldwork = this.prettyToInt(data.fieldwork);
            this.editEventRaw.time_office = this.prettyToInt(data.office);

            $(this.$refs.cal).fullCalendar('updateEvent', this.editEventRaw);
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
                    let cal = this;
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
                        cal.el
                            .find('.fc-day[data-date="' + key + '"] .fc-work-time')
                            .html(component.timePretty(value));
                    });
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
            $(this.$refs.cal).fullCalendar('refetchEvents');
        }
    }
};