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
                        name: 'date',
                        data: {
                            _: 'date.display'
                        },
                    },
                    {
                        name: 'time_fieldwork',
                        data: {
                            _: 'time_fieldwork.display'
                        },
                    },
                    {
                        name: 'time_office',
                        data: {
                            _: 'time_office.display'
                        },
                    }
                ],
            }
        }
    }
};