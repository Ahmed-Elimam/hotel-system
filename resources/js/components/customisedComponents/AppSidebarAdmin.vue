<script setup lang="ts">
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import { Link } from '@inertiajs/vue3';
import { Hotel ,LayoutGrid, Facebook, Twitter, Youtube } from 'lucide-vue-next';
import AppLogo from '../AppLogo.vue';

const mainNavItems: NavItem[] = [
    {
        title: 'Home Page',
        href: '/dashboard',
        icon: LayoutGrid,
    },
    {
        title: 'Manage managers',
        href: '/managers',
        icon: LayoutGrid,
    },
    {
        title: 'Manage Receptionists',
        href: '/Receptionists',
        icon: LayoutGrid,
    },
    {
        title: 'Manage Clients',
        href: '/Clients',
        icon: LayoutGrid,
    },
];

const footerNavItems: NavItem[] = [
    {
        title: 'Facebook',
        href: 'https://www.facebook.com/',
        icon: Facebook,
    },
    {
        title: 'Twitter',
        href: 'https://x.com/?lang=en',
        icon: Twitter,
    },
    {
        title: 'Youtube',
        href: 'https://www.youtube.com/',
        icon: Youtube,
    },
];
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <h1>
                            <!-- <AppLogo /> -->
                             <Hotel/>
                             The Royal Crest
                        </h1>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="mainNavItems" />
        </SidebarContent>

        <SidebarFooter>
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
