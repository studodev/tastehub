import '@styles/components/cooking/form/review-form.scss';
import { AsyncList } from "../../common/async-list";
import { AsyncForm, AsyncFormElements } from "../../common/form/async-form";

export class ReviewForm extends AsyncForm {
    protected elements: ReviewFormElements;

    static getComponentSelector(): string {
        return '[data-review-form]';
    }

    protected buildElements(container: HTMLElement) {
        super.buildElements(container);

        this.elements.listContainer = document.querySelector('.review-holder-wrapper');
    }

    protected onSuccess(): void {
        const reloadEvent = new CustomEvent(AsyncList.events.reload);
        this.elements.listContainer.dispatchEvent(reloadEvent);
    }
}

interface ReviewFormElements extends AsyncFormElements {
    listContainer: HTMLElement;
}
