require('fullcalendar');
require('fullcalendar/dist/locale/pl');

module.exports = {
    template: '<div></div>',

    props: {
        url: [String, Object],
        events: Array
    },

    mounted() {
        $(this.$el).fullCalendar(this.getArgs());
    },

    methods: {
        timePretty(time) {
            var hours = Math.floor(time / 60 / 60);
            var minutes = Math.floor((time % 3600) / 60);

            return `${hours}g ${minutes}m`;
        },

        getArgs() {
            var component = this;

            var args = {
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
                    component.$emit('dayClicked', date);
                },

                eventClick(calEvent, jsEvent, view)
                {
                    component.$emit('eventClicked', calEvent);
                },

                dayRender(date, cell) {
                    cell.append(`
                        <div class="fc-work-time"></div>
                    `);
                },

                eventRender(event, element) {
                    var fieldwork = component.timePretty(event.time_fieldwork);
                    var office = component.timePretty(event.time_office);

                    element.find('.fc-content').append(`
                        <div class="fc-body">
                             Teren: ${fieldwork}<br />
                             Biuro: ${office}
                        </div>
                    `)
                },

                eventAfterAllRender() {
                    var cal = this;
                    var times = {};

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
            $(this.$el).fullCalendar('refetchEvents');
        }
    }
};