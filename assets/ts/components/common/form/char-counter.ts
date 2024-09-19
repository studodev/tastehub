import "@styles/components/common/form/char-counter.scss";

export class CharCounter {
    private elements: CharCounterElements;
    private options: CharCounterOptions;

    private constructor(container: HTMLElement) {
        this.buildElements(container);
        this.buildOptions();
        this.bindEvents();
        this.check();
    }

    private buildElements(container: HTMLElement): void {
        this.elements = {
            container: container,
            widget: container.querySelector('textarea, input'),
            messageValue: container.querySelector('.counter-message-value'),
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

    static init(): void {
        const elements = Array.from(document.querySelectorAll("[data-char-counter]"));

        for (const element of elements) {
            new CharCounter(element as HTMLElement);
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
