/*
 * DolMebel - https://www.dolmebel.com
 *
 * @version   1.0.0
 *
 * @link      Releases - https://www.wach.id/releases
 * @link      Terms Of Service - https://www.wach.id/terms
 *
 * Copyright (c) 2024.
 *
 */
function convertUtcToLocal(utcTimeString: string): string | null {
    try {
        const utcDate = new Date(utcTimeString);

        if (isNaN(utcDate.getTime())) {
            console.error("Invalid UTC date string:", utcTimeString);
            return null;
        }

        const localTimeString = utcDate.toLocaleString();

        // Example with more specific formatting (optional):
        // const localTimeString = utcDate.toLocaleString('en-US', {
        //   year: 'numeric',
        //   month: 'long',
        //   day: 'numeric',
        //   hour: 'numeric',
        //   minute: 'numeric',
        //   second: 'numeric',
        //   timeZoneName: 'short',
        //   hour12: false // Use 24-hour format if needed
        // });

        return localTimeString;
    } catch (error) {
        console.error("Error converting UTC to local time:", error);
        return null;
    }
}

// Examples with type annotations:
const utcTime1: string = "2024-10-27T10:30:00Z";
const utcTime2: string = "2024-10-27 10:30:00"; // Less reliable format
const utcTime3: string = "invalid date";
const utcTime4: string = "2024-11-05T15:45:00Z";

const localTime1: string | null = convertUtcToLocal(utcTime1);
const localTime2: string | null = convertUtcToLocal(utcTime2);
const localTime3: string | null = convertUtcToLocal(utcTime3);

console.log(`UTC: ${utcTime1}, Local: ${localTime1}`);
console.log(`UTC: ${utcTime2}, Local: ${localTime2}`);
console.log(`UTC: ${utcTime3}, Local: ${localTime3}`);


// Example with specific formatting and type annotation:
const localTime4: string | null = new Date(utcTime4).toLocaleString('en-GB', {
    year: 'numeric',
    month: '2-digit',
    day: '2-digit',
    hour: '2-digit',
    minute: '2-digit',
    second: '2-digit',
    hour12: false // Use 24-hour format
});
console.log(`UTC: ${utcTime4}, Local (formatted): ${localTime4}`);

//Demonstrate passing null
const nullTime: null = null;
const convertedNullTime: string | null = convertUtcToLocal(nullTime as any); //Type assertion to bypass type checking for demonstration
console.log(`UTC: ${nullTime}, Local: ${convertedNullTime}`);

export { convertUtcToLocal }
