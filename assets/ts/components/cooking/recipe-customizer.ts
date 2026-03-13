import "@styles/components/cooking/recipe-customizer.scss";
import { apiProvider } from "../../services/api-provider";
import { AbstractComponent } from "../abstract-component";

export class RecipeCustomizer extends AbstractComponent {
    private elements: RecipeCustomizerElements;
    private options: RecipeCustomizerOptions;
    private debounceTimer: ReturnType<typeof setTimeout>;

    static getComponentSelector(): string {
        return '[data-recipe-customizer]';
    }

    constructor(container: HTMLElement) {
        super();
        this.buildElements(container);
        this.buildOptions();
        this.bindEvents();
    }

    private buildElements(container: HTMLElement): void {
        this.elements = {
            container: container,
            quantityCounterWidget: container.querySelector('#quantity_counter_value'),
            ingredientList: container.querySelector('.ingredient-list'),
            stepList: container.querySelector('.step-container'),
        };
    }

    private buildOptions(): void {
        this.options = {
            url: this.elements.container.dataset.recipeCustomizer,
        };
    }

    private bindEvents(): void {
        this.elements.quantityCounterWidget.addEventListener('change', () => {
            clearTimeout(this.debounceTimer);

            this.elements.container.classList.add('loading');
            this.debounceTimer = setTimeout(() => {
                const quantity = Number(this.elements.quantityCounterWidget.value);

                if (Number.isSafeInteger(quantity) && quantity > 0) {
                    this.customize(quantity);
                }
            }, 500);
        });
    }

    private customize(quantity: number): void {
        const url = new URL(this.options.url);
        url.searchParams.set('quantity', quantity.toString());

        apiProvider.fetch(url.toString()).then(data => {
            this.render(data.views.ingredient, data.views.step);
        }).finally(() => {
            this.elements.container.classList.remove('loading');
        });
    }

    private render(ingredientView: string, stepView: string): void {
        this.elements.ingredientList.innerHTML = ingredientView;
        this.elements.stepList.innerHTML = stepView;
    }
}

interface RecipeCustomizerElements {
    container: HTMLElement;
    quantityCounterWidget: HTMLInputElement;
    ingredientList: HTMLElement;
    stepList: HTMLElement;
}

interface RecipeCustomizerOptions {
    url: string;
}
