import { flashFeed } from "../layout/flash-feed/flash-feed";
import { FlashMessageType } from "../layout/flash-feed/flash-message-type";
import { RecipeItemCollection } from "./recipe-item-collection";

export class RecipeIngredientCollection extends RecipeItemCollection {
    protected prepareItem(prototype: HTMLElement): boolean {
        const ingredientInputField = this.elements.itemSource.querySelector('.item-data-ingredient') as HTMLSelectElement;
        const ingredientOutputField = prototype.querySelector('.item-data-ingredient') as HTMLSelectElement;
        const ingredientOutputLabel = prototype.querySelector('.item-data-ingredient-label');
        const ingredientOutputPictogram = prototype.querySelector('.item-data-ingredient-pictogram') as HTMLImageElement;
        const selectedIngredient = ingredientInputField.options[ingredientInputField.selectedIndex];
        const quantityInputField = this.elements.itemSource.querySelector('.item-data-quantity') as HTMLInputElement;
        const quantityOutputField = prototype.querySelector('.item-data-quantity') as HTMLInputElement;
        const unitInputField = this.elements.itemSource.querySelector('.item-data-unit') as HTMLSelectElement;
        const unitOutputField = prototype.querySelector('.item-data-unit') as HTMLInputElement;

        if (!selectedIngredient.value || !quantityInputField.value || !unitInputField.value) {
            flashFeed.push(FlashMessageType.Error, "Vous devez séléctionner un ingrédient, une quantité et une unité");
            return false;
        }

        ingredientOutputField.value = ingredientInputField.value;
        ingredientOutputLabel.textContent = selectedIngredient.textContent;
        ingredientOutputPictogram.src = selectedIngredient.dataset.pictogram;
        quantityOutputField.value = quantityInputField.value;
        unitOutputField.value = unitInputField.value;

        ingredientInputField.selectedIndex = null;
        ingredientInputField.dispatchEvent(new Event('change'));
        quantityInputField.value = null;
        unitInputField.selectedIndex = null;

        return true;
    }
}
