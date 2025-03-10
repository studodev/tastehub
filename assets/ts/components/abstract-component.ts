import { bodyDomObserver } from "../services/dom-observer";

export abstract class AbstractComponent {
    static elements: HTMLElement[] = [];

    static init<T extends AbstractComponent>(this: Component<T>): void {
        this.mount();

        bodyDomObserver.observe().subscribe(() => {
            this.mount();
        });
    }

    static mount<T extends AbstractComponent>(this: Component<T>): void {
        let elements: HTMLElement[] = Array.from(document.querySelectorAll(this.getComponentSelector()));

        for (const element of elements) {
            if (!this.elements.includes(element)) {
                new this(element);
            }
        }

        this.elements = elements;
    }

    static getComponentSelector(): string {
        throw new Error('Component selector must be defined');
    }
}

type Component<T> = {
    elements: HTMLElement[];
    new(...args: any[]): T;
    mount(this: Component<T>): void;
    getComponentSelector(): string;
};
