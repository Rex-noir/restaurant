export default function env(name: string, defaultValue?: string) {
    const modifed = 'VITE_' + name;

    return import.meta.env[modifed] || defaultValue;
}
