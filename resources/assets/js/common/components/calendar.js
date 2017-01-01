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

                dayClick(date, allDay, jsEvent, view)
                {
                    component.$emit('dayClicked', date);
                },

                eventClick(calEvent, jsEvent, view)
                {
                    $(jsEvent.currentTarget).addClass('fc-edit');

                    component.$emit('eventClicked', calEvent);
                },

                eventRender(event, element) {
                    element.find('.fc-content').append(`
                    <div class="fc-body">
                        <div class="view">
                            Fieldwork: ${event.time_fieldwork}<br />
                            Office: ${event.time_office}
                        </div>
                        <div class="edit">
                            <label for="time_office">Office</label><br />
                            <input id="time_office" name="time_office"><br />
                            <br/>
                            
                            <label for="time_office">Fieldwork</label><br />
                            <input id="time_office" name="time_fieldwork">
                        </div>
                    </div>
                    `)
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