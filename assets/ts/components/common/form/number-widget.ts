import IMask, { InputMask } from "imask";
import { AbstractComponent } from "../../abstract-component";

export class NumberWidget extends AbstractComponent {
    private elements: NumberWidgetElements;
    private options: NumberWidgetOptions;
    private mask: InputMask;

    static getComponentSelector(): string {
        return '[data-number-widget]';
    }

    constructor(container: HTMLElement) {
        super();
        this.buildElements(container);
        this.buildOptions();
        this.buildWidget();
    }

    private buildElements(container: HTMLElement): void {
        this.elements = {
            container: container,
        };
    }

    private buildOptions(): void {
        this.options = {
            scale: Number(this.elements.container.dataset.scale),
            min: Number(this.elements.container.dataset.min),
            max: Number(this.elements.container.dataset.max),
        };
    }

    private buildWidget(): void {
        this.mask = IMask(this.elements.container, {
            mask: Number,
            radix: '.',
            mapToRadix: [','],
            scale: this.options.scale,
            min: this.options.min,
            max: this.options.max,
        });

        this.elements.container.addEventListener('change', () => {
            this.mask.updateValue();
        });
    }
}

interface NumberWidgetElements {
    container: HTMLElement;
}

interface NumberWidgetOptions {
    scale: number;
    min: number;
    max: number;
}
