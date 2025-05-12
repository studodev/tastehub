import "@styles/components/cooking/recipe-gallery.scss";
import { apiProvider } from "../../services/api-provider";
import { AbstractComponent } from "../abstract-component";

export class RecipeGallery extends AbstractComponent {
    private elements: RecipeGalleryElements;
    private options: RecipeGalleryOptions;
    private searchTimer: ReturnType<typeof setTimeout>;

    static getComponentSelector(): string {
        return '.recipe-gallery';
    }

    constructor(container: HTMLElement) {
        super();
        this.buildElements(container);
        this.buildOptions();
        this.bindEvents();
        this.updateDisplay();
    }

    private buildElements(container: HTMLElement): void {
        this.elements = {
            container: container,
            holder: container.querySelector('.recipe-holder'),
            filter: container.querySelector('.recipe-filter'),
            loadMore: container.querySelector('.recipe-load-more'),
            endBanner: container.querySelector('.inspiration-banner'),
            empty: container.querySelector('.recipe-holder-empty')
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
            clearTimeout(this.searchTimer);
            this.searchTimer = setTimeout(() => {
                this.search();
            }, 500);
        });
    }

    private search(): void {
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

    private updateDisplay(): void {
        if (this.options.total === 0) {
            this.elements.empty.classList.remove('hidden');
        } else {
            this.elements.empty.classList.add('hidden');
        }

        if (this.options.offset >= this.options.total) {
            this.elements.loadMore.classList.add('hidden');
            this.elements.endBanner.classList.remove('hidden');
        } else {
            this.elements.loadMore.classList.remove('hidden');
            this.elements.endBanner.classList.add('hidden');
        }
    }
}

interface RecipeGalleryElements {
    container: HTMLElement;
    holder: HTMLElement;
    filter: HTMLFormElement;
    loadMore: HTMLButtonElement;
    endBanner: HTMLElement;
    empty: HTMLElement;
}

interface RecipeGalleryOptions {
    url: string;
    offset: number;
    total: number;
}
