import VDatatable from './datatable';
import Laravel from '../../common/laravel';

module.exports = {
    template: require('html!./project-index.html'),

    components: {
        VDatatable
    },

    data() {
        return {
            columns: [
                'ID',
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
                        data: 'name'
                    },
                    {
                        name: 'ends_at',
                        data: {
                            '_': 'ends_at.display'
                        },
                    }
                ],
            }
        }
    }
};