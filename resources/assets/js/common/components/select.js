module.exports = {
    template: require('html!./select.html'),

    props: {
        value: null,
        placeholder: String,
        multiple: [Boolean, String],
        url: String,
    },

    computed: {
        displayEmptyOption() {
            return !this.isMultiple && !!this.placeholder;
        },

        isMultiple() {
            return !!this.multiple;
        }
    },

    mounted() {
        var component = this;

        $(this.$el)
            .val(this.value)
            .select2(this.getOptions())
            .on('change', function () {
                component.$emit('input', $(this).val());
            });
    },

    destroyed() {
        $(this.$el).off().select2('destroy')
    },

    methods: {
        updateValue(value) {
            var emitValue = value;

            if (typeof value !== 'undefined' && !this.isMultiple) {
                emitValue = value[0];
            }

            this.$emit('input', emitValue);
        },

        getOptions() {
            var options = {
                placeholder: this.placeholder || '', // Without empty string, select2 has mindfuck while trying to clear selected option
                allowClear: !this.isMultiple,
                language: Laravel.lang
            };

            if (this.url) {
                options.ajax = {
                    url: this.url,
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: params.term, // search term
                            page: params.page
                        };
                    },
                    processResults: function (data, params) {
                        params.page = params.page || 1;

                        return {
                            results: data.items,
                            pagination: {
                                more: (params.page * data.per_page) < data.total_count
                            }
                        };
                    }
                };
            }

            return options;
        }
    },

    watch: {
        value(value) {
            $(this.$el).val(value);
        },

        url() {
            $(this.$el).select2(this.getOptions());
        }
    }
};