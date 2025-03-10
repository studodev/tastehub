import "@styles/components/cooking/form/recipe-timer-widget.scss";
import { TimeUtils } from "../../../utils/time-utils";
import { AbstractComponent } from "../../abstract-component";

export class RecipeTimerWidget extends AbstractComponent {
    private elements: RecipeTimerWidgetElements;

    static getComponentSelector(): string {
        return '.recipe-timer-widget';
    }

    constructor(container: HTMLElement) {
        super();
        this.buildElements(container);
        this.bindEvents();
        this.updateTotal();
    }

    private buildElements(container: HTMLElement): void {
        this.elements = {
            container: container,
            inputTimers: {
                preparation: container.querySelector(".timer-preparation"),
                waiting: container.querySelector(".timer-waiting"),
                cooking: container.querySelector(".timer-cooking"),
            },
            totalTimer: container.querySelector(".total-timer span"),
        }
    }

    private bindEvents(): void {
        for (const inputTimer of Object.values(this.elements.inputTimers)) {
            inputTimer.addEventListener("change", () => this.updateTotal());
        }
    }

    private updateTotal(): void {
        let total = 0;

        for (const inputTimer of Object.values(this.elements.inputTimers)) {
            const value = parseInt(inputTimer.value);
            if (Number.isSafeInteger(value)) {
                total += value;
            }
        }

        this.elements.totalTimer.innerText = TimeUtils.formatRelativeMinutes(total);
    }
}

interface RecipeTimerWidgetElements {
    container: HTMLElement;
    inputTimers: {
        preparation: HTMLInputElement,
        waiting: HTMLInputElement,
        cooking: HTMLInputElement,
    };
    totalTimer: HTMLElement;
}
