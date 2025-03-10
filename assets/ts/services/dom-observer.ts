import { Observable, Subject } from "rxjs";

export class DomObserver {
    private readonly subject = new Subject<MutationRecord[]>();

    constructor(private target: HTMLElement, private options: MutationObserverInit) {
        this.bind();
    }

    private bind(): void {
        const mutationObserver = new MutationObserver(mutations => {
            this.subject.next(mutations);
        });

        mutationObserver.observe(this.target, this.options);
    }

    observe(): Observable<MutationRecord[]> {
        return this.subject.asObservable();
    }
}

export const bodyDomObserver = new DomObserver(document.body, {
    childList: true,
    subtree: true,
});
