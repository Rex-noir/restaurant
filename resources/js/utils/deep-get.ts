// utils/deep-get.ts
function deepGet<T>(
    obj: T,
    path: string, // Explicitly enforce string type
    defaultValue: any = undefined,
): any {
    if (typeof path !== 'string') {
        return defaultValue;
    }

    return path.split('.').reduce(
        (acc, key) => {
            return acc && key in acc
                ? acc[key as keyof typeof acc]
                : defaultValue;
        },
        obj as Record<string, any>,
    );
}

export default deepGet;
