import "@styles/components/cooking/recipe-item-collection.scss";
import { AbstractComponent } from "../abstract-component";

export abstract class RecipeItemCollection extends AbstractComponent{
    protected elements: RecipeItemCollectionElement;

    static getComponentSelector(): string {
        return '[data-recipe-item-collection]';
    }

    constructor(container: HTMLElement) {
        super();
        this.buildElements(container);
        this.bindEvents();
    }

    private buildElements(container: HTMLElement): void {
        this.elements = {
            container: container,
            addTrigger: container.querySelector('.item-add-trigger'),
            itemHolder: container.querySelector('.item-holder'),
            itemSource: container.querySelector('.item-source'),
        };
    }

    private bindEvents(): void {
        this.elements.addTrigger.addEventListener('click', () => this.addItem());

        this.elements.itemHolder.addEventListener('click', e => {
            const target = e.target as HTMLElement;
            if (target.classList.contains('item-remove-trigger') || target.closest('.item-remove-trigger')) {
                this.removeItem(target.closest('.form-row'));
            }
        });
    }

    private addItem() {
        let prototypeString = this.elements.itemHolder.dataset.prototype;

        let index = this.elements.itemHolder.dataset.index;
        prototypeString = prototypeString.replace(/__name__/g, index);

        const prototypeParsed = new DOMParser().parseFromString(prototypeString, 'text/html');
        const prototype = prototypeParsed.querySelector('body').firstChild;

        if (this.prepareItem(prototype as HTMLElement)) {
            this.elements.itemHolder.appendChild(prototype);
            this.elements.itemHolder.dataset.index = String(Number(index) + 1);
        }
    }

    private removeItem(item: HTMLElement): void {
        item.remove();
    }

    protected abstract prepareItem(prototype: HTMLElement): boolean;
}

interface RecipeItemCollectionElement {
    container: HTMLElement,
    addTrigger: HTMLElement,
    itemHolder: HTMLElement,
    itemSource: HTMLElement,
}

