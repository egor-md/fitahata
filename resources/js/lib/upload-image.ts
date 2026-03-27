/** Max size we allow (5MB). PHP upload_max_filesize must be >= this or upload will fail. */
const MAX_FILE_SIZE_BYTES = 5 * 1024 * 1024;

/**
 * Upload image to /admin/upload-image. Returns the public URL.
 * Uses XMLHttpRequest so the multipart body is sent correctly (fetch can drop the file in some setups).
 */
function getCsrfToken(): string {
    const meta = document.querySelector<HTMLMetaElement>('meta[name="csrf-token"]');
    return meta?.content?.trim() ?? '';
}

export function uploadImage(
    file: File,
    collection: 'plants' | 'recipes' = 'plants',
): Promise<string> {
    if (file.size > MAX_FILE_SIZE_BYTES) {
        return Promise.reject(
            new Error(
                `Файл слишком большой (макс. ${MAX_FILE_SIZE_BYTES / 1024 / 1024} МБ). Сожмите изображение или выберите другой файл.`
            )
        );
    }
    const token = getCsrfToken();
    if (!token) {
        console.warn('CSRF token not found. Ensure meta[name="csrf-token"] is present and Inertia shared props include csrf_token.');
    }

    const formData = new FormData();
    formData.append('_token', token);
    formData.append('image', file, file.name || 'image');
    formData.append('collection', collection);

    const url = '/admin/upload-image';

    return new Promise((resolve, reject) => {
        const xhr = new XMLHttpRequest();

        xhr.onload = () => {
            let data: { url?: string; message?: string; errors?: Record<string, string[]> };
            try {
                data = JSON.parse(xhr.responseText || '{}');
            } catch {
                data = {};
            }

            if (xhr.status >= 200 && xhr.status < 300 && typeof data.url === 'string') {
                resolve(data.url);
                return;
            }

            if (import.meta.env.DEV) {
                console.error('Upload error response:', data);
            }
            const msg =
                data.errors?.image?.join(' ') ||
                data.message ||
                `Upload failed: ${xhr.status}`;
            reject(new Error(msg));
        };

        xhr.onerror = () => reject(new Error('Network error during upload.'));

        xhr.open('POST', url);
        xhr.setRequestHeader('Accept', 'application/json');
        xhr.setRequestHeader('X-XSRF-TOKEN', token);
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.withCredentials = true;
        xhr.send(formData);
    });
}
