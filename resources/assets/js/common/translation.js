module.exports = {
    Vue: {},

    translations: {},

    /*
     Problem, if more than one rootVm
     */
    rootVm: {},

    install(Vue, options = {url: ''}) {
        this.Vue = Vue;

        this.fetchTranslations(options.url);

        Vue.prototype.$trans = this.trans.bind(this);
        Vue.trans = this.trans.bind(this);
    },

    fetchTranslations(url) {
        axios.get(url)
            .then(this.onSuccess.bind(this))
            .catch(response => Event.requestError(response));
    },

    onSuccess(response) {
        this.translations = response.data;

        if (!$.isEmptyObject(window.vueApp)) {
            this.update(window.vueApp);
        }
    },

    /**
     * Translates key to form understandable by humans
     *
     * @param key
     * @param args
     * @returns string
     */
    trans(key, args = {}) {
        let message = this.getValueForKey(key) || key;

        /*
         Make the place-holder replacements on a line.
         */
        $.each(args, function (argKey, argValue) {
            argValue = argValue.toString();

            message = str_replace(
                [':' + argKey.toUpperCase(), ':' + ucfirst(argKey), ':' + argKey],
                [argValue.toUpperCase(), ucfirst(argValue), argValue],
                message
            );
        });

        return message;
    },

    getValueForKey(key) {
        let collection = this.translations;
        let keyExploded = key.split('.');

        $.each(keyExploded, function (i, key) {
            if (!collection.hasOwnProperty(key)) {
                collection = null;
                return false;
            }

            collection = collection[key];
        });

        if (collection === null) {
            return null;
        }

        return collection;
    },

    /**
     * Updates all the watchers in the Vue instance of a component tree.
     *
     * This function is inspired by the "_digest()" function in the
     * "src/instance/scope.js" of the source of Vue.js, excepts that this function
     * updates the children components no matter whether it is inheritable.
     *
     * @param vm
     *    the root of the component tree.
     */
    update(vm) {
        let i = vm._watchers.length;
        while (i--) {
            vm._watchers[i].update(true); // shallow updates
        }

        let children = vm.$children;
        i = children.length;
        while (i--) {
            let child = children[i];
            this.update(child);
        }
    }
};