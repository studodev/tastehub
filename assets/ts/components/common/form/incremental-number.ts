import "@styles/components/common/form/incremental-number.scss";

export class IncrementalNumber {
    private elements: IncrementalNumberElements;

    private constructor(container: HTMLElement) {
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

    static init(): void {
        const elements = Array.from(document.querySelectorAll("[data-incremental-number]"));

        for (const element of elements) {
            new this(element as HTMLElement);
        }
    }
}

interface IncrementalNumberElements {
    container: HTMLElement;
    minusButton: HTMLButtonElement;
    plusButton: HTMLButtonElement;
    input: HTMLInputElement;
}
