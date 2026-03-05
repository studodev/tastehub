import { flashFeed } from "../../layout/flash-feed/flash-feed";
import { FlashMessageType } from "../../layout/flash-feed/flash-message-type";
import { RecipeItemCollection } from "./recipe-item-collection";

export class RecipeIngredientCollection extends RecipeItemCollection {
    protected prepareItem(prototype: HTMLElement): boolean {
        const ingredientInputField = this.elements.itemSource.querySelector('.item-data-ingredient') as HTMLSelectElement;
        const quantityInputField = this.elements.itemSource.querySelector('.item-data-quantity') as HTMLInputElement;
        const unitInputField = this.elements.itemSource.querySelector('.item-data-unit') as HTMLSelectElement;

        const ingredientOutputField = prototype.querySelector('.item-data-ingredient') as HTMLSelectElement;
        const quantityOutputField = prototype.querySelector('.item-data-quantity') as HTMLInputElement;
        const unitOutputField = prototype.querySelector('.item-data-unit') as HTMLSelectElement;

        const ingredientOutputPictogram = prototype.querySelector('.item-data-ingredient-pictogram') as HTMLImageElement;
        const ingredientOutputLabel = prototype.querySelector('.item-data-ingredient-label');
        const ingredientOutputQuantityUnit = prototype.querySelector('.item-data-ingredient-quantity-unit');

        const selectedIngredient = ingredientInputField.options[ingredientInputField.selectedIndex];
        const selectedUnit = unitInputField.options[unitInputField.selectedIndex];

        if (!selectedIngredient.value || (!quantityInputField.value && !selectedUnit.hasAttribute('data-empirical')) || !unitInputField.value) {
            flashFeed.push(FlashMessageType.Error, "Vous devez séléctionner un ingrédient, une quantité et une unité");
            return false;
        }

        ingredientOutputField.value = ingredientInputField.value;
        unitOutputField.value = unitInputField.value;

        ingredientOutputLabel.textContent = selectedIngredient.textContent;
        ingredientOutputPictogram.src = selectedIngredient.dataset.pictogram;

        if (selectedUnit.hasAttribute('data-empirical')) {
            ingredientOutputQuantityUnit.textContent = unitOutputField.options[unitOutputField.selectedIndex].textContent;
        } else {
            quantityOutputField.value = quantityInputField.value;
            const targetedUnit = unitOutputField.options[unitOutputField.selectedIndex];

            if (Number(quantityInputField.value) > 1) {
                ingredientOutputQuantityUnit.textContent = quantityInputField.value + ' ' + targetedUnit.dataset.plural;
            } else {
                ingredientOutputQuantityUnit.textContent = quantityInputField.value + ' ' + targetedUnit.textContent;
            }
        }

        ingredientInputField.selectedIndex = null;
        ingredientInputField.dispatchEvent(new Event('change'));
        quantityInputField.value = null;
        unitInputField.selectedIndex = null;

        return true;
    }
}
