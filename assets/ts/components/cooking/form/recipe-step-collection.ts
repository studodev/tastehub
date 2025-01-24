import { RecipeItemCollection } from "./recipe-item-collection";

export class RecipeStepCollection extends RecipeItemCollection {
    protected bindEvents(): void {
        super.bindEvents();

        this.elements.itemHolder.addEventListener('order-change', () => {
            this.reorderItems()
        });
    }

    protected prepareItem(prototype: HTMLElement): boolean {
        let index = this.elements.itemHolder.children.length + 1;
        prototype.querySelector('h2 span').textContent = String(index);

        return true;
    }

    protected removeItem(item: HTMLElement): void {
        super.removeItem(item);
        this.reorderItems();
    }

    private reorderItems(): void {
        const items = Array.from(this.elements.itemHolder.children);
        let index = 1;

        for (const item of items) {
            item.querySelector('h2 span').textContent = String(index);
            index++;
        }
    }
}
