import Laravel from '../../common/laravel';
import ModelCreateUpdateMixin from '../mixins/model-createedit';
import Moment from 'moment';

export default {
    template: require('html!./user-createedit.html'),

    mixins: [
        ModelCreateUpdateMixin
    ],

    data() {
        return {
            changePasswordUrl: Laravel.url(`/dashboard/users/${this.modelId}/change-password`),
            model: {
                color: '#b0b0b0'
            }
        }
    },

    methods: {
        getModel() {
            let component = this;

            axios.get(Laravel.url(`/dashboard/api/users/${this.modelId}`))
                .then(response => {
                    let user = response.data;

                    user.created_at = Moment(user.created_at).format('YYYY-MM-DDThh:mm:ss');
                    user.updated_at = Moment(user.updated_at).format('YYYY-MM-DDThh:mm:ss');

                    component.model = user;
                })
                .catch(error => Event.requestError(error));
        },

        getFormData() {
            return Object.assign({}, this.model);
        },

        onCreated(response) {
            window.location = Laravel.url(`/dashboard/users/${response.data.id}/edit`);
        },

        onEdited() {
            window.location = Laravel.url('/dashboard/users');
        },

        destroy() {
            axios.delete(Laravel.url(`/dashboard/api/users/${this.modelId}`))
                .then(response => {
                    window.location = Laravel.url('/dashboard/users');
                })
                .catch(error => {
                    if (error.response.status === 422) {
                        Event.notifyDanger(error.response.data.join('<br/>'));
                    } else {
                        Event.requestError(error);
                    }
                });
        }
    },

    computed: {
        formAction() {
            if (this.isCreating) {
                return Laravel.url('/dashboard/api/users');
            }

            return Laravel.url(`/dashboard/api/users/${this.modelId}`);
        },

        formClass() {
            if (this.isCreating) {
                return 'user-create';
            }

            return 'user-edit';
        }
    }
};