import VDatatable from './datatable';
import Laravel from '../../common/laravel';

export default {
    template: require('html!./work-log-index.html'),

    components: {
        VDatatable
    },

    data() {
        return {
            workLogCreateUrl: Laravel.url('/dashboard/work-logs/create'),
            columns: [
                'ID',
                'Project',
                'User',
                'Date',
                'Fieldwork',
                'Office'
            ],
            options: {
                ajax: Laravel.url('/dashboard/api/datatable/work-logs'),
                columns: [
                    {
                        name: 'id',
                        data: {
                            _: 'id.display'
                        },
                    },
                    {
                        data: 'project'
                    },
                    {
                        data: 'user',
                    },
                    {
                        data: 'date',
                    },
                    {
                        data: 'time_fieldwork',
                    },
                    {
                        data: 'time_office',
                    }
                ],
            }
        }
    }
};