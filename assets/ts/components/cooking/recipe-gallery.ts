import "@styles/components/cooking/recipe-gallery.scss";
import { AsyncList, AsyncListElements } from "../common/async-list";

export class RecipeGallery extends AsyncList {
    protected elements: RecipeGalleryElements;
    private searchTimer: ReturnType<typeof setTimeout>;

    protected buildElements(container: HTMLElement): void {
        super.buildElements(container);
        this.elements.endBanner = container.querySelector('.inspiration-banner');
    }

    protected filterChanged(): void {
        clearTimeout(this.searchTimer);
        this.searchTimer = setTimeout(() => {
            this.search();
        }, 500);
    }

    protected updateDisplay(): void {
        super.updateDisplay();

        if (this.options.offset >= this.options.total) {
            this.elements.endBanner.classList.remove('hidden');
        } else {
            this.elements.endBanner.classList.add('hidden');
        }
    }
}

interface RecipeGalleryElements extends AsyncListElements {
    endBanner: HTMLElement;
}
