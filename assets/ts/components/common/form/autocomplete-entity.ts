import TomSelect from "tom-select";
import 'tom-select/dist/css/tom-select.css';
import "@styles/components/common/form/autocomplete-entity.scss";
import { RecursivePartial, TomSettings } from "tom-select/dist/types/types";
import { flashFeed } from "../../layout/flash-feed/flash-feed";
import { FlashMessageType } from "../../layout/flash-feed/flash-message-type";

export class AutocompleteEntity {
    private elements: AutocompleteEntityElements;
    private options: AutocompleteEntityOptions;
    private selectWidget: TomSelect;

    private constructor(container: HTMLElement) {
        this.buildElements(container);
        this.buildOptions();
        this.buildWidget();
    }

    private buildElements(container: HTMLElement): void {
        this.elements = {
            container: container,
            select: container.querySelector("select"),
            counter: {
                container: container.querySelector('.form-counter'),
                value: container.querySelector('.form-counter-value'),
            },
        };
    }

    private buildOptions(): void {
        this.options = {
            url: this.elements.container.dataset.url,
            multiple: this.elements.select.multiple,
            placeholder: this.elements.container.dataset.placeholder,
            maxItems: Number(this.elements.container.dataset.maxItems),
        };
    }

    private buildWidget(): void {
        const options: RecursivePartial<TomSettings> = {
            preload: true,
            highlight: false,
            placeholder: this.options.placeholder,
            hidePlaceholder: true,
            load: this.load.bind(this),
            render: {
                no_results: () => "<div class='empty'>Aucun résulat correspondant</div>",
                loading: () => "<div class='loader small'></div>",
            },
        };

        if (this.options.multiple) {
            options['maxItems'] = this.options.maxItems > 0 ? this.options.maxItems : null;
            options['plugins'] = {
                remove_button: {
                    title: 'Retirer',
                },
                no_active_items: {},
            };
        }

        this.selectWidget = new TomSelect(this.elements.select, options);

        if (this.options.maxItems) {
            this.refreshCounter();
        } else {
            this.elements.counter.container.classList.add("hidden");
        }

        this.selectWidget.on("item_add", () => {
            this.selectWidget.setTextboxValue("");
            this.selectWidget.refreshOptions();
            this.refreshCounter();
        });

        this.selectWidget.on("item_remove", () => {
            this.refreshCounter();
        });

        this.elements.select.addEventListener('change', () => {
            this.selectWidget.sync();
        })
    }

    private load(query: string, callback: Function): void {
        const url = new URL(this.options.url);
        url.searchParams.set("query", query);

        fetch(url)
            .then(response => response.json())
            .then(data => {
                callback(data.items);
            })
            .catch(() => {
                flashFeed.push(
                    FlashMessageType.Error,
                    "Une erreur est survenue lors du chargement des résultats, veuillez réessayer plus tard"
                );
                callback();
            })
        ;
    }

    private refreshCounter(): void {
        const length = this.selectWidget.getValue().length;
        this.elements.counter.value.textContent = `${length}/${this.options.maxItems}`;

        if (this.options.maxItems < length) {
            this.elements.counter.value.classList.add('invalid');
        } else {
            this.elements.counter.value.classList.remove('invalid');
        }
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
    counter: {
        container: HTMLElement,
        value: HTMLElement,
    },
}

interface AutocompleteEntityOptions {
    url: string;
    multiple: boolean;
    placeholder?: string;
    maxItems?: number;
}
