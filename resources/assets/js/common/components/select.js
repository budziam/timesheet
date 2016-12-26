module.exports = {
    template: require('html!./select.html'),

    props: {
        name: String,
        class: String,
        placeholder: String,
        disabled: [Boolean, String],
        required: [Boolean, String],
        selected: [Array, String, Number],
        options: [Object, Array],
        multiple: [Boolean, String],
        url: String,
    },

    data() {
        return {
            initialized: false,

            selectNode: {},
            selectedItemDetails: {},
            realValue: []
        }
    },

    computed: {
        id() {
            return 'form_' + this.nameToId(this.name);
        },

        displayEmptyOption() {
            return !this.isMultiple && !!this.placeholder;
        },

        isMultiple() {
            return !!this.multiple;
        },

        normalizedOptions() {
            return $.extend({}, this.options);
        },

        normalizedClass() {
            return this.class;
        }
    },

    mounted() {
        this.updateValue(this.normalizeValue(this.selected));

        this.selectNode = $(this.$refs.select);

        this.initSelect2();
        this.registerEvents();
    },

    beforeDestroy() {
        this.updateValue(undefined);
    },

    methods: {
        updateValue(value) {
            this.realValue = value;
            var emitValue = value;

            if (typeof value !== 'undefined' && !this.isMultiple) {
                emitValue = value[0];
            }

            this.$emit('input', emitValue);
        },

        reInitSelect2() {
            this.selectNode
                .select2('destroy');

            this.initialized = false;

            setTimeout(this.initSelect2.bind(this), 1);
        },

        initSelect2() {
            if (this.initialized) {
                return;
            }

            var options = {
                placeholder: this.placeholder || '', // Without empty string, select2 has mindfuck while trying to clear selected option
                allowClear: !this.isMultiple,
                width: 'off' // It ruins form select width with prefix
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

            this.selectNode
                .select2(options);

            this.selectNode
                .val(this.realValue)
                .trigger("change");

            this.initialized = true;
        },

        registerEvents() {
            var component = this;

            this.selectNode
                .on('select2:select', function (e) {
                    component.selectedItemDetails = e.params.data;
                })
                .on('change', function () {
                    var selected = component.selectNode
                        .find(':selected')
                        .map(function (i, element) {
                            return element.value;
                        })
                        .toArray();

                    component.updateValue(selected);
                });
        },

        normalizeValue(value) {
            if ($.isArray(value)) {
                return value;
            }

            if (typeof value === 'undefined') {
                return [];
            }

            if (value === null) {
                return [];
            }

            return [value];
        },

        nameToId(name) {
            return this.nameToDotted(name).replace(/\.$/, '');
        },

        nameToDotted(name) {
            return str_replace(['.', '[', ']'], ['_', '.', ''], name);
        }
    },

    watch: {
        options() {
            if (!this.initialized) {
                return;
            }

            this.reInitSelect2();
        },

        url() {
            if (!this.initialized) {
                return;
            }

            this.updateValue([]);
            this.reInitSelect2();
        }
    }
};