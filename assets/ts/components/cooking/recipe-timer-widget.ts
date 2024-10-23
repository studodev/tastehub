import "@styles/components/cooking/recipe-timer-widget.scss";
import { TimeUtils } from "../../utils/time-utils";

export class RecipeTimerWidget {
    private elements: RecipeTimerWidgetElements;

    private constructor(container: HTMLElement) {
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

    static init(): void {
        const elements = Array.from(document.querySelectorAll(".recipe-timer-widget"));

        for (const element of elements) {
            new this(element as HTMLElement);
        }
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
