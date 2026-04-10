import "@styles/components/cooking/review-holder.scss";
import { AsyncList, AsyncListElements } from "../common/async-list";

export class ReviewHolder extends AsyncList {
    protected elements: ReviewHolderElements;

    static getComponentSelector(): string {
        return '[data-review-holder]';
    }

    protected buildElements(container: HTMLElement): void {
        super.buildElements(container);
        this.elements.sortRow = container.querySelector('.sort-row');
    }

    protected updateDisplay(): void {
        super.updateDisplay();
        this.elements.sortRow.classList.toggle('hidden', this.options.total <= 1);
    }
}

interface ReviewHolderElements extends AsyncListElements {
    sortRow: HTMLElement;
}
