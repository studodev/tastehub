import { flashFeed } from "../components/layout/flash-feed/flash-feed";
import { FlashMessageType } from "../components/layout/flash-feed/flash-message-type";

class ApiProvider {
    async fetch(url: string, options: RequestInit = {}): Promise<ApiResponse> {
        this.buildHeaders(options);

        try {
            const response = await fetch(url, options);
            const data = await response.json();

            if (data.status !== true) {
                throw new ApiError(data.message);
            }

            return data;
        } catch (e) {
            let message: string;

            if (e instanceof ApiError && e.message) {
                message = e.message;
            } else {
                message = 'Ne vous inquiétez pas, ce n\'est pas de votre faute. Nous rencontrons une difficulté technique, mais tout devrait revenir à la normale rapidement';
            }

            flashFeed.push(FlashMessageType.Error, message);

            throw e;
        }
    }

    private buildHeaders(options: RequestInit) {
        options.headers = {
            ...options.headers,
            "X-Requested-With": "XMLHttpRequest",
        };
    }
}

export interface ApiResponse {
    status: boolean;
    view?: string;
    message?: string;
    items?: any[];
    details?: {[key: string]: any};
}

export class ApiError extends Error {
    constructor(message?: string) {
        super(message);
        this.name = "ApiError";
        Object.setPrototypeOf(this, new.target.prototype);
    }
}

export const apiProvider = new ApiProvider();
