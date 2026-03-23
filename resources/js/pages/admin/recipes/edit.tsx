import { AdminRecipeForm } from '@/pages/admin/recipes/recipe-form';
import { update } from '@/routes/admin/recipes';

type PlantOpt = { id: number; name: string; slug: string };

type Recipe = {
    id: number;
    title: string;
    slug: string;
    image_url: string;
    time_label: string | null;
    calories_label: string | null;
    difficulty_label: string | null;
    tag_top: string | null;
    tag_bottom: string | null;
    excerpt: string | null;
    body: string | null;
    ingredients: string[] | null;
    cta_label: string | null;
    cta_url: string | null;
    sort_order: number;
    plants?: PlantOpt[];
};

export default function AdminRecipesEdit({
    recipe,
    plants,
}: {
    recipe: Recipe;
    plants: PlantOpt[];
}) {
    return (
        <AdminRecipeForm
            key={recipe.id}
            mode="edit"
            recipe={recipe}
            plants={plants}
            submitUrl={update.url({ recipe: recipe.id })}
        />
    );
}
