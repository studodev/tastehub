import "@styles/components/common/form/file-uploader.scss";

// TODO - Handle non image file
// TODO - Handle backend upload
export class FileUploader {
    private elements: FileUploderElements;

    private constructor(container: HTMLElement) {
        this.buildElements(container);
        this.bindEvents();
    }

    private buildElements(container: HTMLElement): void {
        this.elements = {
            container: container,
            empty: container.querySelector('.empty-container'),
            preview: container.querySelector('.preview-container'),
            previewImage: container.querySelector('.preview-image'),
            previewRemove: container.querySelector('.preview-remove'),
            widget: container.querySelector('input[type="file"]'),
        };
    }

    private bindEvents(): void {
        this.elements.container.addEventListener('dragover', e => {
            e.preventDefault();
            this.elements.container.classList.add('dragover');
        });

        this.elements.container.addEventListener('dragleave', () => {
            this.elements.container.classList.remove('dragover');
        });

        this.elements.container.addEventListener('drop', e => {
            e.preventDefault();
            this.elements.container.classList.remove('dragover');

            if (e.dataTransfer.files.length > 0) {
                this.dropFile(e.dataTransfer.files[0]);
            }
        });

        this.elements.widget.addEventListener('change', () => {
            if (this.elements.widget.files.length > 0) {
                this.handleFile(this.elements.widget.files[0]);
            } else {
                this.clearFile();
            }
        });

        this.elements.previewRemove.addEventListener('click', () => {
            this.clearFile();
        });
    }

    private dropFile(file: File): void {
        const dataTransfer = new DataTransfer();
        dataTransfer.items.add(file);

        this.elements.widget.files = dataTransfer.files;
        this.elements.widget.dispatchEvent(new Event('change'));
    }

    private handleFile(file: File): void {
        const fileReader = new FileReader();
        fileReader.onload = e => {
            this.elements.previewImage.src = e.target.result as string;
            this.elements.empty.classList.add('hidden');
            this.elements.preview.classList.remove('hidden');
        }
        fileReader.readAsDataURL(file);
    }

    private clearFile(): void {
        this.elements.widget.files = null;
        this.elements.previewImage.src = null;

        this.elements.empty.classList.remove('hidden');
        this.elements.preview.classList.add('hidden');
    }

    static init(): void {
        const elements = Array.from(document.querySelectorAll("[data-file-uploader]"));

        for (const element of elements) {
            new this(element as HTMLElement);
        }
    }
}

interface FileUploderElements {
    container: HTMLElement,
    widget: HTMLInputElement,
    empty: HTMLElement,
    preview: HTMLElement,
    previewImage: HTMLImageElement,
    previewRemove: HTMLButtonElement,
}
