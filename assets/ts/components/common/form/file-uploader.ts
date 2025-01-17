import "@styles/components/common/form/file-uploader.scss";
import { AbstractComponent } from "../../abstract-component";

// TODO - See bug for file with same name
export class FileUploader extends AbstractComponent{
    private static readonly imageTypes = ['image/jpeg', 'image/png', 'image/svg+xml', 'image/webp'];
    private elements: FileUploderElements;

    static getComponentSelector(): string {
        return '[data-file-uploader]';
    }

    constructor(container: HTMLElement) {
        super();
        this.buildElements(container);
        this.bindEvents();
    }

    private buildElements(container: HTMLElement): void {
        this.elements = {
            container: container,
            empty: container.querySelector('.empty-container'),
            previewContainer: container.querySelector('.preview-container'),
            previewImageContainer: container.querySelector('.preview-image-container'),
            previewFileContainer: container.querySelector('.preview-file-container'),
            previewFilename: container.querySelector('.preview-filename'),
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
        if (FileUploader.imageTypes.includes(file.type)) {
            this.previewImage(file);
        } else {
            this.previewFile(file);
        }
    }

    private previewImage(file: File): void {
        const fileReader = new FileReader();
        fileReader.onload = e => {
            this.elements.previewImage.src = e.target.result as string;
            this.displayMode(FileUploaderDisplayMode.ModePreviewImage);
        };
        fileReader.readAsDataURL(file);
    }

    private previewFile(file: File): void {
        this.elements.previewFilename.textContent = file.name;
        this.displayMode(FileUploaderDisplayMode.ModePreviewFile);
    }

    private clearFile(): void {
        this.elements.widget.files = null;
        this.elements.previewImage.src = null;
        this.displayMode(FileUploaderDisplayMode.ModeEmpty);
    }

    private displayMode(mode: FileUploaderDisplayMode): void {
        if (mode === FileUploaderDisplayMode.ModeEmpty) {
            this.elements.empty.classList.remove('hidden');
            this.elements.previewContainer.classList.add('hidden');
        } else {
            this.elements.empty.classList.add('hidden');
            this.elements.previewContainer.classList.remove('hidden');

            if (mode === FileUploaderDisplayMode.ModePreviewFile) {
                this.elements.previewImageContainer.classList.add('hidden');
                this.elements.previewFileContainer.classList.remove('hidden');
            } else {
                this.elements.previewImageContainer.classList.remove('hidden');
                this.elements.previewFileContainer.classList.add('hidden');
            }
        }
    }
}

interface FileUploderElements {
    container: HTMLElement,
    widget: HTMLInputElement,
    empty: HTMLElement,
    previewContainer: HTMLElement,
    previewImageContainer: HTMLElement,
    previewFileContainer: HTMLElement,
    previewFilename: HTMLElement,
    previewImage: HTMLImageElement,
    previewRemove: HTMLButtonElement,
}

enum FileUploaderDisplayMode {
    ModePreviewImage,
    ModePreviewFile,
    ModeEmpty,
}
