import { flashFeed } from "../../layout/flash-feed/flash-feed";
import { FlashMessageType } from "../../layout/flash-feed/flash-message-type";
import { RecipeItemCollection } from "./recipe-item-collection";

export class RecipeUtensilCollection extends RecipeItemCollection {
    protected prepareItem(prototype: HTMLElement): boolean {
        const utensilInputField = this.elements.itemSource.querySelector('.item-data-utensil') as HTMLSelectElement;
        const utensilOutputField = prototype.querySelector('.item-data-utensil') as HTMLSelectElement;
        const utensilOutputLabel = prototype.querySelector('.item-data-utensil-label');
        const utensilOutputPictogram = prototype.querySelector('.item-data-utensil-pictogram') as HTMLImageElement;
        const selectedUtensil = utensilInputField.options[utensilInputField.selectedIndex];

        if (!selectedUtensil.value) {
            flashFeed.push(FlashMessageType.Error, "Vous devez séléctionner un ustensile");
            return false;
        }

        utensilOutputField.value = utensilInputField.value;
        utensilOutputLabel.textContent = selectedUtensil.textContent;
        utensilOutputPictogram.src = selectedUtensil.dataset.pictogram;

        utensilInputField.selectedIndex = null;
        utensilInputField.dispatchEvent(new Event('change'));

        return true;
    }
}
