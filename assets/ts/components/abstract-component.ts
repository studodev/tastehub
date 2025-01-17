export abstract class AbstractComponent {
    static init<T extends AbstractComponent>(this: Component<T>): void {
        const elements = Array.from(document.querySelectorAll(this.getComponentSelector()));

        for (const element of elements) {
            new this(element as HTMLElement);
        }
    }

    static getComponentSelector(): string {
        throw new Error('Component selector must be defined');
    }
}

type Component<T> = {
    new(...args: any[]): T;
    getComponentSelector(): string;
};
