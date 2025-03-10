import "@styles/components/common/form/incremental-number.scss";
import { AbstractComponent } from "../../abstract-component";

export class IncrementalNumber extends AbstractComponent{
    private elements: IncrementalNumberElements;

    static getComponentSelector(): string {
        return '[data-incremental-number]';
    }

    constructor(container: HTMLElement) {
        super();
        this.buildElements(container);
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

    private bindEvents() {
        this.elements.minusButton.addEventListener("click", () => this.updateValue(false));
        this.elements.plusButton.addEventListener("click", () => this.updateValue(true));
    }

    private updateValue(up: boolean): void {
        let value = parseInt(this.elements.input.value);

        if (isNaN(value)) {
            value = 0;
        } else if (up) {
            value++;
        } else {
            value--;
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
