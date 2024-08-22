export class StringUtils {
    static ucfirst(string: string) {
        return string[0].toUpperCase() + string.slice(1);
    }
}
