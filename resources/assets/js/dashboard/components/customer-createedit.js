import Laravel from '../../common/laravel';
import ModelCreateUpdateMixin from '../mixins/model-createedit';
import Moment from 'moment';

export default {
    template: require('./customer-createedit.html'),

    mixins: [
        ModelCreateUpdateMixin
    ],

    data() {
        return {
            model: {
                color: '#b0b0b0',
            }
        }
    },

    methods: {
        getModel() {
            let component = this;

            axios.get(Laravel.url('/dashboard/api/customers/' + this.modelId))
                .then(response => {
                    let customer = response.data;

                    customer.created_at = Moment(customer.created_at).format('YYYY-MM-DDThh:mm:ss');
                    customer.updated_at = Moment(customer.updated_at).format('YYYY-MM-DDThh:mm:ss');

                    component.model = customer;
                })
                .catch(error => Event.requestError(error));
        },

        getFormData() {
            return Object.assign({}, this.model);
        },

        onCreated(response) {
            let id = response.data.id;
            window.location = Laravel.url(`/dashboard/customers/${id}/edit`);
        },

        onEdited() {
            window.location = Laravel.url('/dashboard/customers');
        },

        destroy() {
            if (!confirm(this.$trans('Do you really want to delete it?'))) {
                return;
            }

            axios.delete(Laravel.url('/dashboard/api/customers/' + this.modelId))
                .then(response => window.location = Laravel.url('/dashboard/customers'))
                .catch(error => {
                    if (error.response.status === 422) {
                        Event.notifyDanger(error.response.data.errors.join('<br/>'));
                    } else {
                        Event.requestError(error);
                    }
                });
        }
    },

    computed: {
        formAction() {
            if (this.isCreating) {
                return Laravel.url('/dashboard/api/customers');
            }

            return Laravel.url(`/dashboard/api/customers/${this.modelId}`);
        },

        formClass() {
            if (this.isCreating) {
                return 'customer-create';
            }

            return 'customer-edit';
        }
    }
};