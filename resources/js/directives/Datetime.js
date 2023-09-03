import { DateTime } from "luxon";
// https://moment.github.io/luxon/#/formatting
export default function(value, displayFormat = 'LLL dd, y t') {
    if (value === null || value.trim() === ''){
        return '';
    }

    return DateTime.fromISO(value).toFormat(displayFormat);
    const date = new Date(value);
    return date.toLocaleDateString('en-us', { timeZone: "America/Detroit" })+" "+date.toLocaleTimeString('en-us', { timeZone: "America/Detroit" });
}
