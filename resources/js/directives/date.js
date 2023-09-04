import { DateTime } from "luxon";
// https://moment.github.io/luxon/#/formatting
export default function(value, displayFormat = 'LLL dd, y') {
    if (value === null || value.trim() === ''){
        return '';
    }

    return DateTime.fromISO(value).toFormat(displayFormat);
}
