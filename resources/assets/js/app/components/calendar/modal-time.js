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
        $(this.$el).modal();

        $(this.$el).on('hidden.bs.modal', () => {
            this.$emit('close', {
                fieldwork: this.fieldwork,
                office: this.office,
                comment: this.comment,
            });
        });
    },

    methods: {
        close() {
            $(this.$el).modal('hide');
        }
    }
};