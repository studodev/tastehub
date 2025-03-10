import "@styles/components/common/form/char-counter.scss";
import { AbstractComponent } from "../../abstract-component";

export class CharCounter extends AbstractComponent {
    private elements: CharCounterElements;
    private options: CharCounterOptions;

    static getComponentSelector(): string {
        return '[data-char-counter]';
    }

    constructor(container: HTMLElement) {
        super();
        this.buildElements(container);
        this.buildOptions();
        this.bindEvents();
        this.check();
    }

    private buildElements(container: HTMLElement): void {
        this.elements = {
            container: container,
            widget: container.querySelector('textarea, input'),
            messageValue: container.querySelector('.form-counter-value'),
        };
    }

    private buildOptions(): void {
        this.options = {
            min: Number(this.elements.widget.dataset.minLength) ?? 0,
            max: Number(this.elements.widget.dataset.maxLength),
        }
    }

    private bindEvents(): void {
        this.elements.widget.addEventListener('input', () => {
            this.check();
        });
    }

    private check(): void {
        const length = this.elements.widget.value.length;
        this.elements.messageValue.textContent = `${length}/${this.options.max}`;

        if (this.options.min > length || this.options.max < length) {
            this.elements.messageValue.classList.add('invalid');
        } else {
            this.elements.messageValue.classList.remove('invalid');
        }
    }
}

interface CharCounterElements {
    container: HTMLElement,
    widget: HTMLInputElement|HTMLTextAreaElement,
    messageValue: HTMLElement,
}

interface CharCounterOptions {
    min: number;
    max: number;
}
