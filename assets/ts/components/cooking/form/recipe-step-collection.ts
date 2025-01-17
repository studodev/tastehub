import { RecipeItemCollection } from "./recipe-item-collection";

export class RecipeStepCollection extends RecipeItemCollection {
    protected prepareItem(prototype: HTMLElement): boolean {
        let index = this.elements.itemHolder.dataset.index;
        prototype.querySelector('h2').textContent += Number(index) + 1;

        return true;
    }
}
