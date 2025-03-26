<script setup lang="ts">
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import { Link } from '@inertiajs/vue3';
import { Hotel, LayoutGrid, Calendar, Bed, Users, Key, ClipboardList, Facebook, Twitter, Youtube, UserRound } from 'lucide-vue-next';
import AppLogo from '../AppLogo.vue';

const mainNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
        icon: LayoutGrid,
    },
    {
        title: 'Reservations',
        icon: Calendar,
        submenu: [

             {
                title: 'Available Rooms',
                href: '/reservations/available-rooms',
                icon: Bed,
            },
            {
                title: 'My Reservations',
                href: '/reservations/my-reservations',
                icon: UserRound ,
            },


        ]
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
                        <div class="flex items-center gap-2">
                            <Hotel class="h-6 w-6" />
                            <span class="font-semibold">The Royal Crest</span>
                        </div>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <ul class="space-y-1">
                <li v-for="item in mainNavItems" :key="item.title">
                    <!-- Parent item with submenu -->
                    <div v-if="item.submenu" class="mb-1">
                        <div class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100">
                            <component :is="item.icon" class="w-5 h-5 text-gray-500" />
                            <span class="ml-3 text-sm font-medium">{{ item.title }}</span>
                        </div>
                        <!-- Submenu items -->
                        <ul class="pl-8 mt-1 space-y-1">
                            <li v-for="subItem in item.submenu" :key="subItem.title">
                                <Link
                                    :href="subItem.href"
                                    class="flex items-center p-2 text-gray-600 rounded-lg hover:bg-gray-50 text-sm"
                                >
                                    <component :is="subItem.icon" v-if="subItem.icon" class="w-4 h-4 mr-3" />
                                    <span>{{ subItem.title }}</span>
                                </Link>
                            </li>
                        </ul>
                    </div>
                    <!-- Regular item without submenu -->
                    <Link
                        v-else
                        :href="item.href"
                        class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100"
                    >
                        <component :is="item.icon" class="w-5 h-5 text-gray-500" />
                        <span class="ml-3 text-sm font-medium">{{ item.title }}</span>
                    </Link>
                </li>
            </ul>
        </SidebarContent>

        <SidebarFooter>
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
