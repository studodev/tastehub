import { RecipeItemCollection } from "./recipe-item-collection";

export class StepRecipeIngredientCollection extends RecipeItemCollection {
    static getComponentSelector(): string {
        return '[data-step-item-collection]';
    }

    protected prepareItem(prototype: HTMLElement): boolean {
        const ingredientInputField = this.elements.itemSource.querySelector('.item-data-ingredient') as HTMLSelectElement;
        const selectedIngredient = ingredientInputField.options[ingredientInputField.selectedIndex];
        const ingredientOutputField = prototype.querySelector('.item-data-ingredient') as HTMLSelectElement;
        const ingredientOutputLabel = prototype.querySelector('.item-data-ingredient-label');
        const ingredientOutputPictogram = prototype.querySelector('.item-data-ingredient-pictogram') as HTMLImageElement;
        const ingredientOutputQuantity = prototype.querySelector('.item-data-quantity') as HTMLInputElement;
        const ingredientOutputQuantityUnit = prototype.querySelector('.item-data-quantity-unit');

        ingredientOutputField.value = ingredientInputField.value;
        ingredientOutputLabel.textContent = selectedIngredient.textContent;
        ingredientOutputPictogram.src = selectedIngredient.dataset.pictogram;
        ingredientOutputQuantity.value = selectedIngredient.dataset.quantity;
        ingredientOutputQuantityUnit.textContent = selectedIngredient.dataset.quantityUnit;

        return true;
    }
}
