<template>

  <Head title="Floors" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="p-6 space-y-6">
      <h1 class="text-2xl font-semibold">Manage Floors</h1>

      <Button class="bg-green-600 hover:bg-green-700">
        <Link :href="route('floors.create')">Add Floor</Link>
      </Button>

      <Card>
        <CardContent class="overflow-x-auto">
          <Table>
            <TableHeader>
              <TableRow>
                <TableHead>ID</TableHead>
                <TableHead>Name</TableHead>
                <TableHead>Floor Number</TableHead>
                <TableHead>Created By</TableHead>
                <TableHead>Actions</TableHead>
              </TableRow>
            </TableHeader>
            <TableBody>
              <TableRow v-for="row in table.getRowModel().rows" :key="row.original.id">
                <TableCell>{{ row.original.id }}</TableCell>
                <TableCell>{{ row.original.name }}</TableCell>
                <TableCell>{{ row.original.floor_number }}</TableCell>
                <TableCell>
                  {{ row.original.creator?.name }}
                </TableCell>
                <TableCell class="space-x-2">
                  <!-- Update Button -->
                  <Button :disabled="!userRoles.includes('admin') && page.props.user.id !== row.original.creator_id"
                    class="bg-yellow-500 text-black hover:bg-yellow-600 m-2 inline-flex items-center justify-center">
                    <Link :href="route('floors.edit', row.original.id)"
                      class="w-full h-full flex items-center justify-center">
                    Update
                    </Link>
                  </Button>

                  <!-- Delete Button -->
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
                          This will permanently delete the floor and its associated rooms.
                        </AlertDialogDescription>
                      </AlertDialogHeader>
                      <AlertDialogFooter>
                        <AlertDialogCancel>Cancel</AlertDialogCancel>
                        <AlertDialogAction @click="handleDelete(row.original.id)">
                          Continue
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

      <div class="flex items-center justify-between py-4">
        <div class="text-gray-600">
          Showing {{ rows.from }}-{{ rows.to }} of {{ rows.total }} reservations
        </div>
        <div class="flex items-center justify-end py-4 space-x-2">
          <Button variant="outline" size="sm" :disabled="!props.rows?.prev_page_url"
            @click="goToPage(props.rows?.current_page - 1)">
            Previous
          </Button>
          <Button variant="outline" size="sm" :disabled="!props.rows?.next_page_url"
            @click="goToPage(props.rows?.current_page + 1)">
            Next
          </Button>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { Link, usePage, router } from "@inertiajs/vue3";
import { Button } from "@/components/ui/button";
import { Card, CardContent } from "@/components/ui/card";
import { Table, TableHeader, TableBody, TableRow, TableHead, TableCell } from "@/components/ui/table";
import { AlertDialog, AlertDialogTrigger, AlertDialogContent, AlertDialogHeader, AlertDialogTitle, AlertDialogDescription, AlertDialogFooter, AlertDialogAction, AlertDialogCancel } from "@/components/ui/alert-dialog";
import { Head } from "@inertiajs/vue3";
import { computed, defineProps, defineAsyncComponent } from "vue";
import { getCoreRowModel, useVueTable } from "@tanstack/vue-table";
import axios from "axios";
import { useToast } from "vue-toastification";

const toast = useToast();
const page = usePage();

// Safe user roles access
const userRoles = computed(() => {
  return page.props.user?.roles?.map(role => role.name) || []
})

// Dynamic layout with fallback
const AppLayout = defineAsyncComponent(() => {
  if (userRoles.value.includes("admin")) {
    return import("@/layouts/customisedLayout/AppLayoutAdmin.vue")
  } else if (userRoles.value.includes("manager")) {
    return import("@/layouts/customisedLayout/AppLayoutManager.vue")
  } else if (userRoles.value.includes("receptionist")) {
    return import("@/layouts/customisedLayout/AppLayoutReceptionist.vue")
  }
  return import("@/layouts/customisedLayout/AppLayoutClient.vue")
})
const breadcrumbs = [
  { title: "Floors", href: "/floors" },
];

const props = defineProps({
  rows: Array,
});

const columns = [
  { accessorKey: "id", header: "ID" },
  { accessorKey: "name", header: "Name" },
  { accessorKey: "floor_number", header: "Floor Number" },


];

const table = useVueTable({
  data: computed(() => props.rows.data),
  columns: computed(() => columns),
  getCoreRowModel: getCoreRowModel(),
});
const handleDelete = (id) => {
  axios.delete(route("floors.destroy", id))
    .then(response => {
      if (response.status === 204) {
        toast.success("Floor deleted successfully!", { timeout: 3000 });
        router.visit(route("floors.index"));
      } else if (response.status === 409) {
        toast.error("This floor contains rooms and cannot be deleted.");
      }
    })
    .catch(error => {
      if (error.response && error.response.status === 403) {
        toast.error("You don't have permission to delete this floor.");
      } else {
        toast.error("Failed to delete floor.");
        console.error("Error:", error);
      }
    });
};

const goToPage = (pageNum) => {
  if (pageNum < 1 || pageNum > props.rows?.last_page) return;
  router.get(route("floors.index", { page: pageNum }), {}, { preserveState: true });
};
</script>
