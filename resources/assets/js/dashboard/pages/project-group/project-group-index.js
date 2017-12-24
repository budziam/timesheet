import VDatatable from '../../components/datatable';
import Laravel from '../../../common/laravel';

export default {
    template: require('./project-group-index.html'),

    components: {
        VDatatable
    },

    data() {
        return {
            createUrl: Laravel.url('/dashboard/project-groups/create'),
            columns: [
                'ID',
                'Name'
            ],
            options: {
                ajax: Laravel.url('/dashboard/api/datatable/project-groups'),
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