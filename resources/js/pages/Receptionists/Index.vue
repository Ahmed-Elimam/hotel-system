<template>
  <Head title="Managers"/>

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="p-6 space-y-6">
      <h1 class="text-2xl font-semibold">Manage Rooms</h1>

      <Button class="bg-green-600 hover:bg-green-700">
        <Link :href="route('receptionists.create')" method="get">Add Receptionis</Link>
      </Button>


      <Card>
        <CardContent class="overflow-x-auto">
          <Table>
            <TableHeader>
              <TableRow>
                <TableHead v-for="column in columns" :key="column.accessorKey">
                {{ column.header }}
              </TableHead>
              <TableHead>Avatar Image</TableHead>
              <TableHead v-if="userRoles.includes('admin')">Manager name</TableHead>
                <TableHead >Actions</TableHead>
              </TableRow>
            </TableHeader>
            <TableBody>
              <TableRow v-for="row in table.getRowModel().rows" :key="row.original.id">
                <TableCell v-for="column in columns" :key="column.accessorKey">
                {{ row.original[column.accessorKey] }}
              </TableCell>
              <TableCell>
                <Avatar>
                  <AvatarImage  :src="`/storage/${row.original.avatar_image}`" alt="Avatar" />
               </Avatar>
              </TableCell>
              <TableCell v-if="userRoles.includes('admin')">
                {{ row.original.creator.name }}
              </TableCell>
              
                <TableCell class="space-x-2" >
                  <Button :disabled="!userRoles.includes('admin') && page.props.user.id !== row.original.creator_id"
                    class="bg-yellow-500 text-black hover:bg-yellow-600 m-2 inline-flex items-center justify-center">
                    <Link :href="route('receptionists.edit', row.original.id)" method="get"
                      class="w-full h-full flex items-center justify-center">
                    Update
                    </Link>
                  </Button>
                  <Button :disabled="!userRoles.includes('admin') && page.props.user.id !== row.original.creator_id" :class="[row.original.banned_at? 'bg-blue-500 text-black hover:bg-blue-600' : 'bg-black text-white']"  class="m-2 inline-flex items-center justify-center w-20">
                    <Link :href="row.original.banned_at? route('receptionists.unban', row.original.id) : route('receptionists.ban', row.original.id)" method="post" class="w-full h-full flex items-center justify-center">
                      {{ row.original.banned_at? "Unban" : "Ban" }}
                    </Link>
                  </Button>
                  <AlertDialog>
                    <AlertDialogTrigger asChild>
                      <Button :disabled="!userRoles.includes('admin') && page.props.user.id !== row.original.creator_id"
                      type="button" variant="destructive" class="my-2 inline-flex items-center justify-center">
                        Delete
                      </Button>
                    </AlertDialogTrigger>
                    <AlertDialogContent>
                      <AlertDialogHeader>
                        <AlertDialogTitle>Are you sure?</AlertDialogTitle>
                        <AlertDialogDescription>
                          Are you sure you want to delete this record
                        </AlertDialogDescription>
                      </AlertDialogHeader>
                      <AlertDialogFooter>
                        <AlertDialogCancel>Cancel</AlertDialogCancel>
                        <AlertDialogAction>
                          <Link @click.prevent="handleDelete(row.original.id)" as="button">
                          Continue
                          </Link>
                        </AlertDialogAction>
                      </AlertDialogFooter>
                    </AlertDialogContent>
                  </AlertDialog>
                </TableCell>
              </TableRow>
            </TableBody>
          </Table>
        </CardContent>
      </Card>
      <div class="flex items-center justify-end py-4 space-x-2">
  <Button
    variant="outline"
    size="sm"
    :disabled="!props.rows?.prev_page_url"
    @click="goToPage(props.rows?.current_page - 1)"
  >
    Previous
  </Button>
  <Button
    variant="outline"
    size="sm"
    :disabled="!props.rows?.next_page_url"
    @click="goToPage(props.rows?.current_page + 1)"
  >
    Next
  </Button>
</div>

    </div>
  </AppLayout>
</template>


<script setup>
import { Link, usePage } from "@inertiajs/vue3";
import { useAuth } from "@/composables/useAuth";


const page = usePage();
import { Button } from '@/components/ui/button';
import { Card, CardContent } from '@/components/ui/card';
import { Avatar, AvatarImage } from '@/components/ui/avatar';
import { Table, TableHeader, TableBody, TableRow, TableHead, TableCell } from '@/components/ui/table';
import { AlertDialog, AlertDialogTrigger, AlertDialogContent, AlertDialogHeader, AlertDialogTitle, AlertDialogDescription, AlertDialogFooter, AlertDialogAction, AlertDialogCancel } from "@/components/ui/alert-dialog";

import axios from "axios";
import { useToast } from "vue-toastification";

const toast = useToast();

const handleDelete = function (id) {

  axios.delete(route('receptionists.destroy', id))
    .then(response => {
      if (response.status === 204) {
        setTimeout(() => {router.get(route('receptionists.index'));});
        toast.success("Record deleted successfully!", { timeout: 3000});
        

      }
    })
    .catch(error => {
      toast.error("it's forbidden to delete record.");
      console.error("Error:", error);
    });

};


const userRoles = usePage().props.user.roles.map(role => role.name);
const AppLayout = defineAsyncComponent(() =>
userRoles.includes("admin")
  ? import("@/layouts/customisedLayout/AppLayoutAdmin.vue")
  : userRoles.includes("manager") ?
  import("@/layouts/customisedLayout/AppLayoutManager.vue")
  : userRoles.includes("receptionist") ?
  import("@/layouts/customisedLayout/AppLayoutReceptionist.vue")
  : import("@/layouts/customisedLayout/AppLayoutClient.vue")
);



import { Head } from '@inertiajs/vue3';

const breadcrumbs = [
  {
    title: 'Receptionists',
    href: '/Receptionists',
  },
];


import { computed, defineProps, defineAsyncComponent } from 'vue';
import {
    getCoreRowModel,
    getPaginationRowModel,
    useVueTable,
} from "@tanstack/vue-table";

const props = defineProps({
    rows: Array,
    columns: Array,
});
// console.log("Floors data:", rows.floor);
const columns = [
    {
        accessorKey: 'id',
        header: 'ID',
    },
    {
        accessorKey: 'name',
        header: 'Name',
    },
    {
        accessorKey: 'email',
        header: 'Email',
    },
    {
        accessorKey: 'national_id',
        header: 'National ID',
    },
    
];
import { router } from '@inertiajs/vue3';
const goToPage = (page) => {
  if (page < 1 || page > props.rows?.last_page) return;
  router.get(route('Receptionists.index', { page }), {}, { preserveState: true });
};

const table = useVueTable({
    data: computed(() => props.rows.data),
    columns: computed(() => props.columns),
    getCoreRowModel: getCoreRowModel(),
    getPaginationRowModel: getPaginationRowModel(),
});
</script>

<style>

</style>