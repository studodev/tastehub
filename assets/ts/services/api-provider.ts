class ApiProvider {
    async fetch(url: string, options: RequestInit = {}): Promise<ApiResponse> {
        this.buildHeaders(options);

        const response = await fetch(url, options);
        const data = await response.json() as ApiResponse;

        if (data.status !== true) {
            throw new ApiError(data.message);
        }

        return data;
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
    }
}

export const apiProvider = new ApiProvider();
