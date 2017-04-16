module.exports = {
    timePretty(time) {
        let hours = Math.floor(time / 60 / 60);
        let minutes = Math.floor((time % 3600) / 60);
        minutes = str_pad(minutes, 2, '0', 'STR_PAD_LEFT');

        return `${hours}g ${minutes}m`;
    },

    prettyToInt(time) {
        let pattern = /(?:([0-9]+)\s*g)?\s*(?:([0-9]+)\s*m)?/;
        let result = pattern.exec(time);

        let hours = parseInt(result[1]) || 0;
        let minutes = parseInt(result[2]) || 0;

        return hours * 3600 + minutes * 60;
    }
};