import "@styles/components/common/tab-navigation.scss";
import { AbstractComponent } from "../abstract-component";

export class TabNavigation extends AbstractComponent {
    private elements: TabNavigationElements;

    static getComponentSelector(): string {
        return '[data-tab-navigation]';
    }

    constructor(container: HTMLElement) {
        super();
        this.elements = this.buildElements(container);
        this.bindEvents();
    }

    private buildElements(container: HTMLElement): TabNavigationElements {
        return {
            container: container,
            triggers: Array.from(container.querySelectorAll('[data-tab-trigger]')),
            contents: Array.from(container.querySelectorAll('[data-tab-content]')),
        };
    }

    private bindEvents(): void {
        this.elements.container.addEventListener('click', e => {
            let target = e.target as HTMLElement;

            if (target.hasAttribute('data-tab-trigger')) {
                this.navigate(target);
            }
        });

        this.elements.container.addEventListener('tab-navigation:navigate', ((e: CustomEvent) => {
            this.navigateTo(e.detail.to);
        }) as EventListener);
    }

    private navigate(trigger: HTMLElement): void {
        const tabName = trigger.dataset.tabTrigger;

        if (tabName) {
            this.navigateTo(tabName);
        }
    }

    private navigateTo(tabName: string): void {
        for (const content of this.elements.contents) {
            if (content.dataset.tabContent === tabName) {
                content.classList.add('active');
            } else {
                content.classList.remove('active');
            }
        }

        for (const trigger of this.elements.triggers) {
            if (trigger.dataset.tabTrigger === tabName) {
                trigger.classList.add('active');
            } else {
                trigger.classList.remove('active');
            }
        }
    }
}

interface TabNavigationElements {
    container: HTMLElement;
    triggers: HTMLElement[];
    contents: HTMLElement[];
}
