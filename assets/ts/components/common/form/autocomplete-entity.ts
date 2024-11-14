import TomSelect from "tom-select";
import 'tom-select/dist/css/tom-select.css';
import "@styles/components/common/form/autocomplete-entity.scss";

// TODO - Add tag counter
export class AutocompleteEntity {
    private elements: AutocompleteEntityElements;
    private options: AutocompleteEntityOptions;

    private constructor(container: HTMLElement) {
        this.buildElements(container);
        this.buildOptions();
        this.buildWidget();
    }

    private buildElements(container: HTMLElement): void {
        this.elements = {
            container: container,
            select: container.querySelector("select"),
        };
    }

    private buildOptions(): void {
        this.options = {
            url: this.elements.container.dataset.url,
            placeholder: this.elements.container.dataset.placeholder
        };
    }

    private buildWidget(): void {
        const select = new TomSelect(this.elements.select, {
            preload: true,
            highlight: false,
            placeholder: this.options.placeholder,
            hidePlaceholder: true,
            load: this.load.bind(this),
            render: {
                no_results: () => "<div class='empty'>Aucun résulat correspondant</div>",
                loading: () => "<div class='loader small'></div>",
            },
            plugins: {
                remove_button: {
                    title: 'Retirer',
                },
                no_active_items: {},
            },
        });

        select.on("item_add", () => {
            select.setTextboxValue("");
            select.refreshOptions();
        });
    }

    // TODO - Manage error
    private load(query: string, callback: Function): void {
        const url = new URL(this.options.url);
        url.searchParams.set("query", query);

        fetch(url)
            .then(response => response.json())
            .then(data => {
                callback(data.items);
            })
        ;
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

interface AutocompleteEntityOptions {
    url: string;
    placeholder?: string;
}
