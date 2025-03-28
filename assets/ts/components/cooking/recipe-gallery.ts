import "@styles/components/cooking/recipe-gallery.scss";
import { apiProvider } from "../../services/api-provider";
import { AbstractComponent } from "../abstract-component";

export class RecipeGallery extends AbstractComponent {
    private elements: RecipeGalleryElements;
    private options: RecipeGalleryOptions;

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
    }

    private load(): void {
        const url = new URL(this.options.url);
        url.searchParams.set('offset', this.options.offset.toString());

        this.elements.loadMore.classList.add('busy');
        apiProvider.fetch(url.toString()).then(data => {
            this.options.offset = data.details.offset + data.details.limit;
            this.options.total = data.details.total;

            this.render(data.view);
            this.updateDisplay();
            this.elements.loadMore.classList.remove('busy');
        });
    }

    private render(view: string): void {
        this.elements.holder.insertAdjacentHTML('beforeend', view);
    }

    private updateDisplay(): void {
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
}

interface RecipeGalleryOptions {
    url: string;
    offset: number;
    total: number;
}
