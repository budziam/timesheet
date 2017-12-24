import VDatatable from '../../components/datatable';
import Laravel from '../../../common/laravel';

export default {
    template: require('./user-index.html'),

    components: {
        VDatatable
    },

    data() {
        return {
            userCreateUrl: Laravel.url('/dashboard/users/create'),
            columns: [
                'ID',
                'Name',
                'Fullname'
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
                    },
                    {
                        data: 'fullname'
                    }
                ],
            }
        }
    }
};