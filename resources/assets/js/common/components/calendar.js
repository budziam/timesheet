require('fullcalendar');

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
        getArgs() {
            var component = this;

            var args = {
                lang: Laravel.lang,
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaDay'
                },
                height: "auto",
                allDaySlot: false,
                slotEventOverlap: false,
                timeFormat: 'HH:mm',

                dayClick(date)
                {
                    component.$emit('dayClicked', date);
                },

                eventClick(event)
                {
                    component.$emit('eventClicked', event);
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