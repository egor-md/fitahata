import { AdminPlantForm } from '@/pages/admin/plants/plant-form';
import { update } from '@/routes/admin/plants';

type Tag = { id: number; name: string; slug: string; group?: string | null };
type KindOpt = { value: string; label: string };

type Plant = {
    id: number;
    name: string;
    subtitle: string | null;
    slug: string;
    kind: string;
    is_visible: boolean;
    description: string | null;
    dishes_text: string | null;
    price: string | number;
    price_unit_label: string | null;
    compare_at_price: string | number | null;
    discount_label: string | null;
    growing_period_label: string | null;
    category_label: string | null;
    sku: string | null;
    is_bestseller: boolean;
    rating: string | number | null;
    reviews_count: number | null;
    facts: Array<{ icon: string; title: string; sub: string }> | null;
    nutrition_section_title: string | null;
    nutrition_section_lead: string | null;
    nutrition_tip_text: string | null;
    recipes_section_pill: string | null;
    recipes_section_title: string | null;
    recipes_section_lead: string | null;
    meta_title: string | null;
    meta_description: string | null;
    images?: Array<{
        id?: number;
        url: string;
        sort_order: number;
        is_primary: boolean;
    }>;
    tags?: Tag[];
    nutrition_items?: Array<{
        section: string;
        label: string;
        meta: string | null;
        value: string;
        bar_percent: number;
        bar_variant: string | null;
        sort_order: number;
    }>;
};

export default function AdminPlantsEdit({
    plant,
    tags,
    plant_kinds,
}: {
    plant: Plant;
    tags: Tag[];
    plant_kinds: KindOpt[];
}) {
    return (
        <AdminPlantForm
            key={plant.id}
            mode="edit"
            plant={plant}
            tags={tags}
            plant_kinds={plant_kinds}
            submitUrl={update.url({ plant: plant.id })}
        />
    );
}
