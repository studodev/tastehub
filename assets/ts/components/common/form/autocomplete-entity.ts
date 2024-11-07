import TomSelect from "tom-select";
import 'tom-select/dist/css/tom-select.css';
import "@styles/components/common/form/autocomplete-entity.scss";

// TODO - Make it generic
export class AutocompleteEntity {
    private elements: AutocompleteEntityElements;
    // private options: CharCounterOptions;

    private constructor(container: HTMLElement) {
        this.buildElements(container);
        // this.buildOptions();
        this.build();
    }

    private buildElements(container: HTMLElement): void {
        this.elements = {
            container: container,
            select: container.querySelector("select"),
        };
    }

    private buildOptions(): void {

    }

    private build(): void {
        new TomSelect(this.elements.select, {
            plugins: {
                remove_button: {
                    title: 'Retirer',
                },
                no_active_items: {},
            },
            load: (query, callback) => {
                fetch('/tag/autocomplete?query=' + encodeURIComponent(query))
                    .then(response => response.json())
                    .then(data => {
                        callback(data.items);
                    })
                ;
            },
            render: {
                no_results: () => "<div>Aucun tag correspondant</div>",
            },
            preload: true,
        });
    }

    static init(): void {
        const elements = Array.from(document.querySelectorAll("[data-autocomplete-entity]"));

        for (const element of elements) {
            new this(element as HTMLElement);
        }
    }
}

interface AutocompleteEntityElements {
    container: HTMLElement,
    select: HTMLSelectElement,
}
