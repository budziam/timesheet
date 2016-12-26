export default {
    created() {
        Event.$on('notify', (message) => {
            alert(message);
        })
    }
}