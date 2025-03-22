type Diff<T> = Partial<T>;

function deepDiff<T extends Record<string, any>>(
    original: T,
    updated: T,
): Diff<T> {
    const changes: Partial<T> = {};

    function findChanges(obj1: any, obj2: any): any {
        if (obj1 === obj2) return undefined;

        if (
            typeof obj1 !== 'object' ||
            typeof obj2 !== 'object' ||
            obj1 === null ||
            obj2 === null
        ) {
            return obj2; // If primitive or different types, return updated value
        }

        const diff: Record<string, any> = {};
        for (const key in obj2) {
            if (Object.prototype.hasOwnProperty.call(obj2, key)) {
                const valueDiff = findChanges(obj1[key], obj2[key]);
                if (valueDiff !== undefined) {
                    diff[key] = valueDiff;
                }
            }
        }
        return Object.keys(diff).length > 0 ? diff : undefined;
    }

    const diffResult = findChanges(original, updated);
    return diffResult || changes;
}

export default deepDiff;
