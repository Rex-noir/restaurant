function deepGet(
    obj: Record<string, any>,
    path: string,
    defaultValue: any = undefined,
) {
    return path.split('.').reduce((acc, key) => {
        return acc && key in acc ? acc[key] : defaultValue;
    }, obj);
}

export default deepGet;
