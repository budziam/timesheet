import qs from 'qs';
import VDatatable from '../../components/datatable';
import Laravel from '../../../common/laravel';

export default {
    template: require('./project-index.html'),

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
            onlyActive: false,
        }
    },

    computed: {
        options() {
            return {
                ajax: this.tableUrl,
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
                order: [[0, 'desc']],
            };
        },

        tableUrl() {
            let url = '/dashboard/api/datatable/projects';

            const params = {only_active: this.onlyActive ? 1 : 0};
            url += '?' + qs.stringify(params, {arrayFormat: 'brackets'});

            return Laravel.url(url);
        }
    },
};