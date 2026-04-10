import "@styles/components/common/form/async-form.scss";
import { apiProvider } from "../../../services/api-provider";
import { AbstractComponent } from "../../abstract-component";

export class AsyncForm extends AbstractComponent {
    protected elements: AsyncFormElements;
    protected options: AsyncFormOptions;

    static getComponentSelector(): string {
        return '[data-async-form]';
    }

    constructor(container: HTMLElement) {
        super();
        this.buildElements(container);
        this.buildOptions();
        this.load();
    }

    protected buildElements(container: HTMLElement): void {
        this.elements = {
            container: container,
        };
    }

    private buildOptions(): void {
        this.options = {
            url: this.elements.container.dataset.url,
        };
    }

    protected load(payload?: FormData): void {
        this.elements.container.classList.add('loading');

        let options = {};
        if (payload) {
             options = {
                method: 'POST',
                body: payload,
            };
        }

        apiProvider.fetch(this.options.url, options).then(data => {
            this.render(data.view);

            if (data.details !== undefined && data.details.success === true) {
                this.onSuccess();
            }
        }).finally(() => {
            this.elements.container.classList.remove('loading');
        });
    }

    private render(view: string): void {
        this.elements.container.innerHTML = view;

        this.elements.form = this.elements.container.querySelector('form');
        if (this.elements.form) {
            this.elements.form.addEventListener('submit', e => {
                e.preventDefault();
                this.handle();
            });
        }
    }

    protected handle() {
        const formData = new FormData(this.elements.form);
        this.load(formData);
    }

    protected onSuccess(): void {}
}

export interface AsyncFormElements {
    container: HTMLElement;
    form?: HTMLFormElement;
}

interface AsyncFormOptions {
    url: string;
}
