import Laravel from '../../common/laravel';
import VForm from '../../common/components/form';

export default {
    template: require('./user-change-password.html'),

    props: {
        userId: [Number, String],
    },

    data() {
        return {
            formAction: Laravel.url(`/dashboard/api/users/${this.userId}/change-password`),
            password: null
        }
    },

    methods: {
        getFormData() {
            return {
                password: this.password || ''
            };
        },

        onFormSuccess() {
            window.location = Laravel.url(`/dashboard/users/${this.userId}/edit`);
        }
    },

    components: {
        VForm
    }
};