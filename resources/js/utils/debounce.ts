function debounce<T extends (...args: any[]) => void>(
    func: T,
    delay: number,
): (...arg: Parameters<T>) => void {
    let timer: ReturnType<typeof setTimeout>;

    return (...args: Parameters<T>) => {
        clearTimeout(timer);
        timer = setTimeout(() => func(...args), delay);
    };
}

export default debounce;
