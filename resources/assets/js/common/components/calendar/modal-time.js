module.exports = {
    template: require('html!./modal-time.html'),

    props: {
        event: Object
    },

    data() {
        return {
            office: this.event.timeOffice,
            fieldwork: this.event.timeFieldwork,
        }
    },

    mounted() {
        var component = this;

        $(this.$el).modal();

        $(this.$el).on('hidden.bs.modal', () => {
            component.$emit('update', {
                fieldwork: this.fieldwork,
                office: this.office,
            });
            component.$emit('close');
        });
    }
};