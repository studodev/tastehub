import { AbstractComponent } from "../abstract-component";

export class Expander extends AbstractComponent {
    private elements: ExpanderElements;

    static getComponentSelector(): string {
        return '[data-expander]';
    }

    constructor(container: HTMLElement) {
        super();
        this.buildElements(container);
        this.bindEvents();
    }

    private buildElements(container: HTMLElement): void {
        this.elements = {
            container: container,
            trigger: container.querySelector('.expander-trigger'),
        };
    }

    private bindEvents(): void {
        this.elements.trigger.addEventListener('click', () => this.toggle());
    }

    private toggle(): void {
        this.elements.container.classList.toggle('expanded');
    }
}

interface ExpanderElements {
    container: HTMLElement;
    trigger: HTMLElement;
}
