import { Config } from 'ziggy-js';

export interface User {
    id: number;
    name: string;
    email: string;
    email_verified_at?: string;
}

export type PageProps<
    T extends Record<string, unknown> = Record<string, unknown>,
> = T & {
    auth: {
        user: User;
    };
    ziggy: Config & { location: string };
    errors: Record<string, string[]>;
};
// Define a generic interface for paginated responses
export interface PaginatedResponse<T> {
    meta: {
        total: number; // Total number of items across all pages
        per_page: number; // Number of items per page
        current_page: number; // Current page number
        last_page: number; // Total number of pages
        first_page_url: string | null; // URL for the first page
        last_page_url: string | null; // URL for the last page
        next_page_url: string | null; // URL for the next page
        prev_page_url: string | null; // URL for the previous page
        path: string; // Base URL for pagination
        from: number; // Index of the first item on the current page
        to: number; // Index of the last item on the current page
    };
    links: {
        url: string | null;
        label: string;
        active: boolean;
    }[];
    data: T[]; // Array of records for the current page (generic type)
}
