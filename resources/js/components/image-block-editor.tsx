import { useState } from 'react';
import { GripVertical, Trash2, Upload } from 'lucide-react';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { ImageCropDialog } from '@/components/image-crop-dialog';
import { uploadImage } from '@/lib/upload-image';

type Props = {
    content: Record<string, unknown>;
    onChange: (content: Record<string, unknown>) => void;
    onRemove: () => void;
};

export function ImageBlockEditor({ content, onChange, onRemove }: Props) {
    const [uploading, setUploading] = useState(false);
    const [cropOpen, setCropOpen] = useState(false);
    const [cropFile, setCropFile] = useState<File | null>(null);
    const url = String(content.url ?? '');
    const alt = String(content.alt ?? '');
    const caption = String(content.caption ?? '');

    function handleFileChange(e: React.ChangeEvent<HTMLInputElement>) {
        const file = e.target.files?.[0];
        if (!file) return;
        e.target.value = '';
        setCropFile(file);
        setCropOpen(true);
    }

    async function handleCropConfirm(croppedFile: File) {
        setCropFile(null);
        setUploading(true);
        try {
            const newUrl = await uploadImage(croppedFile);
            onChange({ ...content, url: newUrl, alt, caption });
        } finally {
            setUploading(false);
        }
    }

    return (
        <div className="flex gap-2 rounded border p-3">
            <GripVertical className="mt-2 size-4 shrink-0 text-muted-foreground" />
            <div className="min-w-0 flex-1 space-y-2">
                <span className="text-xs font-medium text-muted-foreground">
                    Картинка
                </span>
                <div className="flex flex-wrap items-center gap-2">
                    <label className="cursor-pointer">
                        <input
                            type="file"
                            accept="image/*"
                            className="hidden"
                            disabled={uploading}
                            onChange={handleFileChange}
                        />
                        <Button type="button" variant="outline" size="sm" asChild>
                            <span>
                                <Upload className="mr-1 size-3.5" />
                                {uploading ? 'Загрузка…' : 'Загрузить фото'}
                            </span>
                        </Button>
                    </label>
                    <span className="text-xs text-muted-foreground">или URL:</span>
                </div>
                <ImageCropDialog
                    open={cropOpen}
                    onOpenChange={setCropOpen}
                    imageFile={cropFile}
                    onConfirm={handleCropConfirm}
                    onCancel={() => setCropFile(null)}
                />
                <Input
                    value={url}
                    onChange={(e) =>
                        onChange({ ...content, url: e.target.value, alt, caption })
                    }
                    placeholder="https://..."
                />
                {url && (
                    <img
                        src={url}
                        alt=""
                        className="mt-1 h-24 w-auto max-w-full rounded border object-cover"
                    />
                )}
                <Input
                    value={alt}
                    onChange={(e) =>
                        onChange({ ...content, url, alt: e.target.value, caption })
                    }
                    placeholder="Alt"
                />
                <Input
                    value={caption}
                    onChange={(e) =>
                        onChange({ ...content, url, alt, caption: e.target.value })
                    }
                    placeholder="Подпись"
                />
            </div>
            <Button type="button" variant="ghost" size="icon" onClick={onRemove}>
                <Trash2 className="size-4" />
            </Button>
        </div>
    );
}
