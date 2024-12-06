import { RecipeItemCollection } from "./recipe-item-collection";

export class RecipeIngredientCollection extends RecipeItemCollection {
    protected buildPrototype(prototype: HTMLElement): void {
        const quantityInputField = this.elements.itemSource.querySelector('.item-data-quantity') as HTMLInputElement;
        const quantityOutputField = prototype.querySelector('.item-data-quantity') as HTMLInputElement;
        quantityOutputField.value = quantityInputField.value;

        const unitInputField = this.elements.itemSource.querySelector('.item-data-unit') as HTMLInputElement;
        const unitOutputField = prototype.querySelector('.item-data-unit') as HTMLInputElement;
        unitOutputField.value = unitInputField.value;

        const ingredientInputField = this.elements.itemSource.querySelector('.item-data-ingredient') as HTMLSelectElement;
        const ingredientOutputField = prototype.querySelector('.item-data-ingredient') as HTMLSelectElement;
        const ingredientOutputLabel = prototype.querySelector('.item-data-ingredient-label');
        const ingredientOutputPictogram = prototype.querySelector('.item-data-ingredient-pictogram') as HTMLImageElement;
        const selectedIngredient = ingredientInputField.options[ingredientInputField.selectedIndex];

        ingredientOutputField.value = ingredientInputField.value;
        ingredientOutputLabel.textContent = selectedIngredient.textContent;
        ingredientOutputPictogram.src = selectedIngredient.dataset.pictogram;

    }
}
