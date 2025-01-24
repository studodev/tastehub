import { Observable, Subject } from "rxjs";

class DomObserver {
    private readonly subject = new Subject<MutationRecord[]>();

    constructor() {
        this.bind();
    }

    private bind(): void {
        const mutationObserver = new MutationObserver(mutations => {
            this.subject.next(mutations);
        });

        mutationObserver.observe(document.body, {
            childList: true,
            subtree: true,
        });
    }

    observe(): Observable<MutationRecord[]> {
        return this.subject.asObservable();
    }
}

export const domObserver = new DomObserver();
