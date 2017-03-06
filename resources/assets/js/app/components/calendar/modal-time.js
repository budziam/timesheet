module.exports = {
    template: require('html!./modal-time.html'),

    props: {
        event: Object,
        title: String
    },

    data() {
        return {
            office: this.event.office || '',
            fieldwork: this.event.fieldwork || '',
            comment: this.event.comment || '',
        };
    },

    mounted() {
        let component = this;

        $(this.$el).modal();

        $(this.$el).on('hidden.bs.modal', () => {
            component.close();
        });

        $(this.$el).keyup((e) => {
            if (e.which == 13) {
                $(component.$el).modal('hide');
            }
        })
    },

    methods: {
        close() {
            this.$emit('close', {
                fieldwork: this.fieldwork,
                office: this.office,
                comment: this.comment,
            });
        }
    }
};