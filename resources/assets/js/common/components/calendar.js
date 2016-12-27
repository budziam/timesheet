require('fullcalendar');

module.exports = {
    template: '<div></div>',

    props: {
        events: Array
    },

    data()
    {
        return {
            cal: null
        }
    },

    mounted()
    {
        var component = this;
        this.cal = $(this.$el);

        var args = {
            lang: Laravel.lang,
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            height: "auto",
            allDaySlot: false,
            slotEventOverlap: false,
            timeFormat: 'HH:mm',

            events: component.events,

            dayClick(date)
            {
                component.$emit('dayClicked', date);
                component.cal.fullCalendar('gotoDate', date.start);
                component.cal.fullCalendar('changeView', 'agendaDay');
            },

            eventClick(event)
            {
                component.$emit('eventClicked', event);
            }
        };

        this.cal.fullCalendar(args);

    }
};