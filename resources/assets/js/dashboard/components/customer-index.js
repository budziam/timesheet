import VDatatable from './datatable';
import Laravel from '../../common/laravel';

export default {
    template: require('./customer-index.html'),

    components: {
        VDatatable
    },

    data() {
        return {
            createUrl: Laravel.url('/dashboard/customers/create'),
            columns: [
                'ID',
                'Name'
            ],
            options: {
                ajax: Laravel.url('/dashboard/api/datatable/customers'),
                columns: [
                    {
                        name: 'id',
                        data: {
                            _: 'id.display'
                        },
                    },
                    {
                        data: 'name'
                    }
                ],
            }
        }
    }
};