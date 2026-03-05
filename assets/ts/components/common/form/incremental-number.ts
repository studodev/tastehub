import "@styles/components/common/form/incremental-number.scss";
import { AbstractComponent } from "../../abstract-component";

export class IncrementalNumber extends AbstractComponent{
    private elements: IncrementalNumberElements;
    private options: IncrementalNumberOptions;

    static getComponentSelector(): string {
        return '[data-incremental-number]';
    }

    constructor(container: HTMLElement) {
        super();
        this.buildElements(container);
        this.buildOptions();
        this.bindEvents();
    }

    private buildElements(container: HTMLElement): void {
        this.elements = {
            container: container,
            minusButton: container.querySelector(".minus"),
            plusButton: container.querySelector(".plus"),
            input: container.querySelector(".input-value"),
        };
    }

    private buildOptions(): void {
        this.options = {
            min: Number(this.elements.input.dataset.min),
            max: Number(this.elements.input.dataset.max),
        };
    }

    private bindEvents(): void {
        this.elements.minusButton.addEventListener("click", () => this.updateValue(false));
        this.elements.plusButton.addEventListener("click", () => this.updateValue(true));
    }

    private updateValue(up: boolean): void {
        let value = parseInt(this.elements.input.value);

        if (isNaN(value)) {
            value = this.options.min;
        } else if (up) {
            value++;
        } else {
            value--;
        }

        if (value < this.options.min) {
            value = this.options.min;
        } else if (value > this.options.max) {
            value = this.options.max;
        }

        this.elements.input.value = String(value);
    }
}

interface IncrementalNumberElements {
    container: HTMLElement;
    minusButton: HTMLButtonElement;
    plusButton: HTMLButtonElement;
    input: HTMLInputElement;
}

interface IncrementalNumberOptions {
    min: number;
    max: number;
}
