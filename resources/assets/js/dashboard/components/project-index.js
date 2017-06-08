import VDatatable from './datatable';
import Laravel from '../../common/laravel';

export default {
    template: require('html!./project-index.html'),

    components: {
        VDatatable
    },

    data() {
        return {
            projectCreateUrl: Laravel.url('/dashboard/projects/create'),
            columns: [
                'ID',
                'L.K.Z',
                'KERG/ID',
                'Name',
                'End date'
            ],
            options: {
                ajax: Laravel.url('/dashboard/api/datatable/projects'),
                columns: [
                    {
                        name: 'id',
                        data: {
                            _: 'id.display'
                        },
                    },
                    {
                        data: 'lkz',
                    },
                    {
                        data: 'kerg',
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'ends_at'
                    }
                ],
            }
        }
    }
};