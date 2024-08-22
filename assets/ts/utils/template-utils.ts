export class TemplateUtils {
    static prepare(template: HTMLTemplateElement, selector: string): HTMLElement {
        const cloned = template.content.cloneNode(true) as DocumentFragment;
        return cloned.querySelector(selector);
    }
}
