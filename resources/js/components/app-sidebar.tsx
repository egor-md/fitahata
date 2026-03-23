import { useMemo } from 'react';
import { Link, usePage } from '@inertiajs/react';
import { BookOpen, ChefHat, FolderGit2, LayoutGrid, Sprout } from 'lucide-react';
import AppLogo from '@/components/app-logo';
import { NavFooter } from '@/components/nav-footer';
import { NavMain } from '@/components/nav-main';
import { NavUser } from '@/components/nav-user';
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';
import { edit as adminPlantEdit, index as adminPlantsIndex } from '@/routes/admin/plants';
import { index as adminRecipesIndex } from '@/routes/admin/recipes';
import { dashboard } from '@/routes';
import type { NavItem } from '@/types';

type AdminPlantNav = { id: number; name: string; slug: string };

const footerNavItems: NavItem[] = [
    {
        title: 'Repository',
        href: 'https://github.com/laravel/react-starter-kit',
        icon: FolderGit2,
    },
    {
        title: 'Documentation',
        href: 'https://laravel.com/docs/starter-kits#react',
        icon: BookOpen,
    },
];

export function AppSidebar() {
    const { adminPlantsNav = [] } = usePage().props as {
        adminPlantsNav?: AdminPlantNav[];
    };

    const mainNavItems = useMemo((): NavItem[] => {
        const plantChildren = [
            { title: 'Все растения', href: adminPlantsIndex.url() },
            ...adminPlantsNav.map((p) => ({
                title: p.name,
                href: adminPlantEdit.url({ plant: p.id }),
            })),
        ];

        return [
            {
                title: 'Dashboard',
                href: dashboard.url(),
                icon: LayoutGrid,
            },
            {
                title: 'Растения',
                href: adminPlantsIndex.url(),
                icon: Sprout,
                children: plantChildren,
            },
            {
                title: 'Готовим',
                href: adminRecipesIndex.url(),
                icon: ChefHat,
            },
        ];
    }, [adminPlantsNav]);

    return (
        <Sidebar collapsible="icon" variant="inset">
            <SidebarHeader>
                <SidebarMenu>
                    <SidebarMenuItem>
                        <SidebarMenuButton size="lg" asChild>
                            <Link href={dashboard.url()} prefetch>
                                <AppLogo />
                            </Link>
                        </SidebarMenuButton>
                    </SidebarMenuItem>
                </SidebarMenu>
            </SidebarHeader>

            <SidebarContent>
                <NavMain items={mainNavItems} />
            </SidebarContent>

            <SidebarFooter>
                <NavFooter items={footerNavItems} className="mt-auto" />
                <NavUser />
            </SidebarFooter>
        </Sidebar>
    );
}
