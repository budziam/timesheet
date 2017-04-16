import VForm from '../../common/components/form';

export default {
    props: {
        modelId: [Number, String],
    },

    data() {
        return {
            model: {}
        }
    },

    created() {
        if (this.isEditing) {
            this.getModel();
        }
    },

    methods: {
        onFormSuccess(response) {
            if (this.isCreating) {
                return this.onCreated(response);
            }

            return this.onEdited(response);
        },
    },

    computed: {
        isCreating() {
            return this.modelId == null;
        },

        isEditing() {
            return !this.isCreating;
        },

        formMethod() {
            if (this.isCreating) {
                return 'POST';
            }

            return 'PATCH';
        }
    },

    components: {
        VForm
    }
};