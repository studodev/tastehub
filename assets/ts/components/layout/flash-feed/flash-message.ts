import { FlashMessageType } from "./flash-message-type";

export class FlashMessage {
    constructor(private type: FlashMessageType, private message: string, private element: HTMLElement) {
        this.build();
    }

    getElement(): HTMLElement {
        return this.element;
    }

    present() {
        this.bindEvents();

        this.element.animate({
            opacity: 1,
        }, {
            duration: 300,
            fill: "forwards",
        });
    }

    private build(): void {
        this.element.querySelector('span').textContent = this.message;
        this.element.classList.add(this.type);
    }

    private bindEvents(): void {
        setTimeout(() => {
            this.close();
        }, 5000);

        this.element.querySelector('button').addEventListener('click', () => {
            this.close();
        });
    }

    private close(): void {
        const animation = this.element.animate({
            opacity: 0,
        }, {
            duration: 300,
        });

        animation.finished.then(() => this.element.remove());
    }
}
