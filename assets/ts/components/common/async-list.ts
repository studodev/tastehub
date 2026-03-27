import { apiProvider } from "../../services/api-provider";
import { AbstractComponent } from "../abstract-component";

export class AsyncList extends AbstractComponent {
    protected elements: AsyncListElements;
    protected options: AsyncListOptions;

    static getComponentSelector(): string {
        return '[data-async-list]';
    }

    constructor(container: HTMLElement) {
        super();
        this.buildElements(container);
        this.buildOptions();
        this.bindEvents();
        this.updateDisplay();
    }

    protected buildElements(container: HTMLElement): void {
        this.elements = {
            container: container,
            holder: container.querySelector('.async-list-holder'),
            filter: container.querySelector('.async-list-filter'),
            loadMore: container.querySelector('.async-list-load-more'),
            empty: container.querySelector('.async-list-holder-empty')
        };
    }

    private buildOptions(): void {
        this.options = {
            url: this.elements.container.dataset.url,
            offset: Number(this.elements.container.dataset.offset),
            total: Number(this.elements.container.dataset.total),
        };
    }

    private bindEvents(): void {
        this.elements.loadMore.addEventListener('click', () => {
            this.load();
        });

        this.elements.filter.addEventListener('input', () => {
            this.filterChanged();
        });
    }

    protected filterChanged(): void {
        this.search();
    }

    protected search(): void {
        this.options.offset = 0;
        this.load(true);
    }

    private load(reset: boolean = false): void {
        if (reset) {
            this.elements.container.classList.add('loading');
        } else {
            this.elements.loadMore.classList.add('busy');
        }

        const url = new URL(this.options.url);
        url.searchParams.set('offset', this.options.offset.toString());

        const formData = new FormData(this.elements.filter);
        formData.forEach((value, key) => {
            url.searchParams.append(key, value.toString());
        });

        apiProvider.fetch(url.toString()).then(data => {
            this.options.offset = data.details.offset;
            this.options.total = data.details.total;

            this.render(data.view, reset);
            this.updateDisplay();
        }).finally(() => {
            if (reset) {
                this.elements.container.classList.remove('loading');
            } else {
                this.elements.loadMore.classList.remove('busy');
            }
        });
    }

    private render(view: string, reset: boolean): void {
        if (reset) {
            this.elements.holder.innerHTML = view
        } else {
            this.elements.holder.insertAdjacentHTML('beforeend', view);
        }
    }

    protected updateDisplay(): void {
        if (this.options.total === 0) {
            this.elements.empty.classList.remove('hidden');
        } else {
            this.elements.empty.classList.add('hidden');
        }

        if (this.options.offset >= this.options.total) {
            this.elements.loadMore.classList.add('hidden');
        } else {
            this.elements.loadMore.classList.remove('hidden');
        }
    }
}

export interface AsyncListElements {
    container: HTMLElement;
    holder: HTMLElement;
    filter: HTMLFormElement;
    loadMore: HTMLButtonElement;
    empty: HTMLElement;
}

interface AsyncListOptions {
    url: string;
    offset: number;
    total: number;
}
