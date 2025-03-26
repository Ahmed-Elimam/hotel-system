<template>
  <Head title="Receptionists" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="p-6 space-y-6">
      <h1 class="text-2xl font-semibold">Manage Receptionists</h1>

      <Button class="bg-green-600 hover:bg-green-700">
        <Link :href="route('receptionists.create')" method="get">Add Receptionist</Link>
      </Button>

      <Card>
        <CardContent class="overflow-x-auto">
          <Table v-if="receptionists.length">
            <TableHeader>
              <TableRow>
                <TableHead>ID</TableHead>
                <TableHead>Name</TableHead>
                <TableHead>Email</TableHead>
                <TableHead>National ID</TableHead>
                <TableHead>Avatar</TableHead>
                <TableHead>Actions</TableHead>
              </TableRow>
            </TableHeader>
            <TableBody>
              <TableRow v-for="receptionist in receptionists" :key="receptionist.id">
                <TableCell>{{ receptionist.id }}</TableCell>
                <TableCell>{{ receptionist.name }}</TableCell>
                <TableCell>{{ receptionist.email }}</TableCell>
                <TableCell>{{ receptionist.national_id }}</TableCell>
                <TableCell>
                  <Avatar v-if="receptionist.avatar_image">
                    <AvatarImage :src="'/storage/${receptionist.avatar_image}'" alt="Avatar" />
                  </Avatar>
                </TableCell>
                <TableCell class="space-x-2">
                  <Button class="bg-yellow-500 text-black hover:bg-yellow-600 m-2 inline-flex items-center justify-center">
                    <Link :href="route('receptionists.edit', receptionist.id)" method="get" class="w-full h-full flex items-center justify-center">
                      Update
                    </Link>
                  </Button>

                  <AlertDialog>
                    <AlertDialogTrigger asChild>
                      <Button type="button" variant="destructive" class="my-2 inline-flex items-center justify-center">
                        Delete
                      </Button>
                    </AlertDialogTrigger>
                    <AlertDialogContent>
                      <AlertDialogHeader>
                        <AlertDialogTitle>Are you sure?</AlertDialogTitle>
                        <AlertDialogDescription>
                          Are you sure you want to delete this record?
                        </AlertDialogDescription>
                      </AlertDialogHeader>
                      <AlertDialogFooter>
                        <AlertDialogCancel>Cancel</AlertDialogCancel>
                        <AlertDialogAction>
                          <Button @click.prevent="handleDelete(receptionist.id)">Continue</Button>
                        </AlertDialogAction>
                      </AlertDialogFooter>
                    </AlertDialogContent>
                  </AlertDialog>
                </TableCell>
              </TableRow>
            </TableBody>
          </Table>
          <p v-else class="text-center text-gray-500">No receptionists found.</p>
        </CardContent>
      </Card>

      <!-- Pagination Controls -->
      <div class="flex items-center justify-end py-4 space-x-2">
        <Button variant="outline" size="sm" :disabled="!props.rows?.prev_page_url" @click="goToPage(props.rows?.current_page - 1)">
          Previous
        </Button>
        <Button variant="outline" size="sm" :disabled="!props.rows?.next_page_url" @click="goToPage(props.rows?.current_page + 1)">
          Next
        </Button>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { computed, defineProps, defineAsyncComponent } from 'vue';
import { Link, Head, router } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Card, CardContent } from '@/components/ui/card';
import { Avatar, AvatarImage } from '@/components/ui/avatar';
import { Table, TableHeader, TableBody, TableRow, TableHead, TableCell } from '@/components/ui/table';
import { AlertDialog, AlertDialogTrigger, AlertDialogContent, AlertDialogHeader, AlertDialogTitle, AlertDialogDescription, AlertDialogFooter, AlertDialogAction, AlertDialogCancel } from "@/components/ui/alert-dialog";
import axios from "axios";
import { useToast } from "vue-toastification";
import { usePage } from '@inertiajs/vue3';

const toast = useToast();

const userRoles = usePage().props.user.roles.map(role => role.name);
const AppLayout = defineAsyncComponent(() =>
  userRoles.includes("admin")
    ? import("@/layouts/customisedLayout/AppLayoutAdmin.vue")
    :     import("@/layouts/customisedLayout/AppLayoutManager.vue")
      
);

const props = defineProps({
  rows: Object, // Expected to be an object containing paginated data
});

// Ensure we extract data correctly, regardless of its structure
const receptionists = computed(() => {
  return props.rows?.data || props.rows || []; // Handles both cases: rows.data or rows directly
});

const breadcrumbs = [
  {
    title: 'Receptionists',
    href: '/receptionists',
  },
];

const handleDelete = async (id) => {
  try {
    const response = await axios.delete(route('receptionists.destroy', id));
    if (response.status === 204) {
      toast.success("Record deleted successfully!", { timeout: 3000 });
      setTimeout(() => location.reload(), 3000);
    }
  } catch (error) {
    toast.error("An error occurred while deleting the record.");
    console.error("Error:", error);
  }
};

const goToPage = (page) => {
  if (page < 1 || page > props.rows?.last_page) return;
  router.get(route('receptionists.index', { page }), {}, { preserveState: true });
};
</script>