module.exports = {
    timePretty(time) {
        const hours = Math.floor(time / 60 / 60);
        const minutes = Math.floor((time % 3600) / 60);
        const minutesFormatted = str_pad(minutes, 2, '0', 'STR_PAD_LEFT');

        return `${hours}g ${minutesFormatted}m`;
    },

    prettyToInt(time) {
        const pattern = /(?:([0-9]+)\s*g)?\s*(?:([0-9]+)\s*m)?/;
        const result = pattern.exec(time);

        const hours = parseInt(result[1]) || 0;
        const minutes = parseInt(result[2]) || 0;

        return hours * 3600 + minutes * 60;
    },

    newTimePretty(time) {
        const hours = Math.floor(time / 60 / 60);
        const minutes = Math.floor((time % 3600) / 60);
        const hoursFormatted = str_pad(hours, 2, '0', 'STR_PAD_LEFT');
        const minutesFormatted = str_pad(minutes, 2, '0', 'STR_PAD_LEFT');

        return `${hoursFormatted}:${minutesFormatted}`;
    },

    getHourValue(value, totalSeconds) {
        if (totalSeconds === 0) {
            return 0;
        }

        return value / totalSeconds * 3600;
    },
};