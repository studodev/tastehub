import { FlashFeedElements } from "./flash-feed-elements";
import { FlashMessage } from "./flash-message";
import { FlashMessageType } from "./flash-message-type";
import { StringUtils } from "../../../utils/string-utils";
import { TemplateUtils } from "../../../utils/template-utils";
import "@styles/components/layout/flash-feed.scss";

class FlashFeed {
    private readonly containerId = 'flash-feed';
    private elements: FlashFeedElements;

    init(): void {
        this.buildElements();
        this.pushBackendMessages();
    }

    push(type: FlashMessageType, message: string): void {
        if (!this.elements.feed) {
            this.elements.feed = document.createElement('ul');
            this.elements.container.appendChild(this.elements.feed);
        }

        const element = TemplateUtils.prepare(this.elements.template, '.flash-message');
        const flash = new FlashMessage(type, message, element);
        this.elements.feed.appendChild(flash.getElement());
        flash.present();
    }

    private buildElements(): void {
        const container = document.getElementById(this.containerId);

        this.elements = {
            container: container,
            template: container.querySelector('.message-template')
        };
    }

    private pushBackendMessages(): void {
        const messages = JSON.parse(this.elements.container.dataset.messages);
        for (const type in messages) {
            for (const message of messages[type]) {
                this.push(FlashMessageType[StringUtils.ucfirst(type)], message);
            }
        }
    }
}

export const flashFeed = new FlashFeed();
