import { AdminPlantForm } from '@/pages/admin/plants/plant-form';
import { store } from '@/routes/admin/plants';

type Tag = { id: number; name: string; slug: string; group?: string | null };
type KindOpt = { value: string; label: string };

export default function AdminPlantsCreate({
    tags,
    plant_kinds,
}: {
    tags: Tag[];
    plant_kinds: KindOpt[];
}) {
    return (
        <AdminPlantForm
            mode="create"
            tags={tags}
            plant_kinds={plant_kinds}
            submitUrl={store.url()}
        />
    );
}
