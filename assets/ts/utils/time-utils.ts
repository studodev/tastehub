export class TimeUtils {
    static formatRelativeMinutes(minutes: number): string {
        if (minutes > 60) {
            const hoursOutput = Math.floor(minutes / 60);
            const minutesOutput = String(minutes % 60).padStart(2, '0');

            return hoursOutput + 'h' + minutesOutput;
        }

        return minutes + ' min';
    }
}
