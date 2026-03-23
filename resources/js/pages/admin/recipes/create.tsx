import { AdminRecipeForm } from '@/pages/admin/recipes/recipe-form';
import { store } from '@/routes/admin/recipes';

type PlantOpt = { id: number; name: string; slug: string };

export default function AdminRecipesCreate({
    plants,
}: {
    plants: PlantOpt[];
}) {
    return (
        <AdminRecipeForm
            mode="create"
            plants={plants}
            submitUrl={store.url()}
        />
    );
}
