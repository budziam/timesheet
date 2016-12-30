require('fullcalendar');

module.exports = {
    template: '<div></div>',

    props: {
        events: Array
    },

    mounted()
    {
        $(this.$el).fullCalendar(this.getArgs());
    },

    methods: {
        getArgs() {
            var component = this;

            return {
                lang: Laravel.lang,
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month'
                },
                height: "auto",
                allDaySlot: false,
                slotEventOverlap: false,
                timeFormat: 'HH:mm',

                events: component.events,

                dayClick(date)
                {
                    component.$emit('dayClicked', date);
                },

                eventClick(event)
                {
                    component.$emit('eventClicked', event);
                }
            };
        }
    }
};