module.exports = {
    template: require('html!./modal-time.html'),

    props: {
        event: Object,
        title: String
    },

    data() {
        if (!this.event) {
            return {
                office: '',
                fieldwork: '',
                comment: ''
            };
        }

        return {
            office: this.event.office || '',
            fieldwork: this.event.fieldwork || '',
            comment: this.event.comment || '',
        };
    },

    mounted() {
        $(this.$el).modal();
        $(this.$el).on('hidden.bs.modal', () => {
            this.$emit('exit')
        });
    },

    methods: {
        save() {
            this.$emit('save', {
                fieldwork: this.fieldwork,
                office: this.office,
                comment: this.comment,
            });

            $(this.$el).modal('hide');
        },

        destroy() {
            this.$emit('destroy');
            $(this.$el).modal('hide');
        }
    },

    computed: {
        isEditing() {
            return !!this.event;
        }
    }
};