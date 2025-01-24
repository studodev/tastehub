import "@styles/components/common/list-orderer.scss";
import { AbstractComponent } from "../abstract-component";

export class ListOrderer extends AbstractComponent {
    private elements: ListOrdererElements;

    static getComponentSelector(): string {
        return "[data-list-orderer]";
    }

    constructor(container: HTMLElement) {
        super();
        this.buildElements(container);
        this.bindEvents();
        this.disableEdgeTrigger();
    }

    private buildElements(container: HTMLElement): void {
        this.elements = {
            container: container,
        };
    }

    private bindEvents(): void {
        this.elements.container.addEventListener("click", e => {
            const target = e.target as HTMLElement;
            const item = target.closest('.orderer-item') as HTMLElement;

            if (!item) {
                return;
            }

            if (target.classList.contains("orderer-trigger-up") || target.closest(".orderer-trigger-up")) {
                this.move(item);
            } else if (target.classList.contains("orderer-trigger-down") || target.closest(".orderer-trigger-down")) {
                this.move(item, false);
            }
        });
    }

    private move(item :HTMLElement, up = true): void {
        const items = Array.from(this.elements.container.children);
        const index = items.indexOf(item);

        if (up) {
            this.elements.container.insertBefore(item, items[index - 1]);
        } else {
            this.elements.container.insertBefore(item, items[index + 2]);
        }

        this.disableEdgeTrigger();
    }

    private disableEdgeTrigger(): void {
        const items = Array.from(this.elements.container.children);

        for (const i in items) {
            if (Number(i) === 0) {
                items[i].querySelector('.orderer-trigger-up').classList.add('disabled');
            } else {
                items[i].querySelector('.orderer-trigger-up').classList.remove('disabled');
            }

            if (Number(i) === items.length - 1) {
                items[i].querySelector('.orderer-trigger-down').classList.add('disabled');
            } else {
                items[i].querySelector('.orderer-trigger-down').classList.remove('disabled');
            }
        }
    }
}

interface ListOrdererElements {
    container: HTMLElement;
}
