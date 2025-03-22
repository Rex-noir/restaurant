async function urlToFile(
    imageUrl: string,
    fileName: string,
    mimeType?: string,
): Promise<File> {
    const response = await fetch(imageUrl);
    const bloc = await response.blob();

    return new File([bloc], fileName, { type: mimeType });
}
