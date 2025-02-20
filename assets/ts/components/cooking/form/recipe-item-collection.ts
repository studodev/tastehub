import "@styles/components/cooking/form/recipe-item-collection.scss";
import { AbstractComponent } from "../../abstract-component";

export abstract class RecipeItemCollection extends AbstractComponent {
    protected elements: RecipeItemCollectionElement;
    protected prototypeName = '__name__';

    static getComponentSelector(): string {
        return '[data-recipe-item-collection]';
    }

    constructor(container: HTMLElement) {
        super();
        this.buildElements(container);
        this.bindEvents();
    }

    private buildElements(container: HTMLElement): void {
        const scopeEndElements = Array.from(container.querySelectorAll('[data-collection-scope-end]'));

        this.elements = {
            container: container,
            scopeEnds: scopeEndElements,
            addTrigger: this.findScopedElement(container, scopeEndElements, '.item-add-trigger'),
            itemHolder: this.findScopedElement(container, scopeEndElements, '.item-holder'),
            itemSource: this.findScopedElement(container, scopeEndElements, '.item-source'),
        };
    }

    protected bindEvents(): void {
        this.elements.addTrigger?.addEventListener('click', () => this.addItem());

        this.elements.itemHolder.addEventListener('click', e => {
            const target = e.target as HTMLElement;

            const isOutOfScope = this.isOutOfScope(this.elements.scopeEnds, target);
            const isElement = target.classList.contains('item-remove-trigger');
            const isChild = target.closest('.item-remove-trigger');

            if (!isOutOfScope && (isElement || isChild)) {
                this.removeItem(target.closest('.form-row'));
            }
        });
    }

    protected addItem() {
        let prototypeString = this.elements.itemHolder.dataset.prototype;

        let index = this.elements.itemHolder.dataset.index;
        const regex = new RegExp(this.prototypeName, "g");
        prototypeString = prototypeString.replace(regex, index);

        const prototypeParsed = new DOMParser().parseFromString(prototypeString, 'text/html');
        const prototype = prototypeParsed.querySelector('body').firstChild;

        if (this.prepareItem(prototype as HTMLElement)) {
            this.elements.itemHolder.appendChild(prototype);
            this.elements.itemHolder.dataset.index = String(Number(index) + 1);
        }
    }

    protected removeItem(item: HTMLElement): void {
        item.remove();
    }

    private findScopedElement(container: HTMLElement, scopeEnds: Array<Element>, selector: string): HTMLElement {
        const allElements = container.querySelectorAll(selector);

        const filteredElements = Array.from(allElements).filter(element => {
            return !this.isOutOfScope(scopeEnds, element);
        });

        return filteredElements.shift() as HTMLElement;
    }

    private isOutOfScope(scopeEnds: Array<Element>, element: Element): boolean {
        for (const scopeEnd of scopeEnds) {
            if (scopeEnd.contains(element)) {
                return true;
            }
        }

        return false;
    }

    protected abstract prepareItem(prototype: HTMLElement): boolean;
}

interface RecipeItemCollectionElement {
    container: HTMLElement,
    scopeEnds: Array<Element>,
    addTrigger: HTMLElement|null,
    itemHolder: HTMLElement,
    itemSource: HTMLElement,
}

