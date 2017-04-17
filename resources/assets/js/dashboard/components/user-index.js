import VDatatable from './datatable';
import Laravel from '../../common/laravel';

export default {
    template: require('html!./user-index.html'),

    components: {
        VDatatable
    },

    data() {
        return {
            userCreateUrl: Laravel.url('/dashboard/users/create'),
            columns: [
                'ID',
                'Name'
            ],
            options: {
                ajax: Laravel.url('/dashboard/api/datatable/users'),
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