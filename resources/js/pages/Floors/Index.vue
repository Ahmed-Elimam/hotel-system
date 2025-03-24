<template>
    <Head title="Floors" />

    <AppLayout :breadcrumbs="breadcrumbs">
      <div class="p-6 space-y-6">
        <h1 class="text-2xl font-semibold">Manage Floors</h1>

        <Button class="bg-green-600 hover:bg-green-700">
          <Link :href="route('floors.create')" method="get">Add Floor</Link>
        </Button>

        <Card>
          <CardContent class="overflow-x-auto">
            <Table>
              <TableHeader>
                <TableRow>
                  <TableHead>ID</TableHead>
                  <TableHead>Room Name</TableHead>
                  <TableHead>Floor Number</TableHead>
                  <TableHead>Created By</TableHead>
                  <TableHead>Actions</TableHead>
                </TableRow>
              </TableHeader>
              <TableBody>
                <TableRow v-for="floor in rows" :key="floor.id">
                  <TableCell>{{ floor.id }}</TableCell>
                  <TableCell>{{ floor.name }}</TableCell>
                  <TableCell>{{ floor.floor_number }}</TableCell>
                  <TableCell>{{ floor.creator.name }}</TableCell>

                  <TableCell class="space-x-2">
                    <!-- Edit Button -->
                    <Button
                      class="bg-yellow-500 text-black hover:bg-yellow-600 m-2 inline-flex items-center justify-center"
                    >
                      <Link :href="route('floors.edit', floor.id)" method="get">
                        Update
                      </Link>
                    </Button>

                    <!-- Delete Button with AlertDialog -->
                    <AlertDialog>
                      <AlertDialogTrigger asChild>
                        <Button
                          type="button"
                          variant="destructive"
                          class="my-2 inline-flex items-center justify-center"
                        >
                          Delete
                        </Button>
                      </AlertDialogTrigger>
                      <AlertDialogContent>
                        <AlertDialogHeader>
                          <AlertDialogTitle>Are you sure?</AlertDialogTitle>
                          <AlertDialogDescription>
                            Are you sure you want to delete this floor?
                          </AlertDialogDescription>
                        </AlertDialogHeader>
                        <AlertDialogFooter>
                          <AlertDialogCancel>Cancel</AlertDialogCancel>
                          <AlertDialogAction @click="handleDelete(floor.id)">
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
      </div>
    </AppLayout>
  </template>

  <script setup>
  import { Link, usePage } from "@inertiajs/vue3";
  import { Head } from "@inertiajs/vue3";
  import { Button } from "@/components/ui/button";
  import { Card, CardContent } from "@/components/ui/card";
  import {
    Table,
    TableHeader,
    TableBody,
    TableRow,
    TableHead,
    TableCell,
  } from "@/components/ui/table";
  import {
    AlertDialog,
    AlertDialogTrigger,
    AlertDialogContent,
    AlertDialogHeader,
    AlertDialogTitle,
    AlertDialogDescription,
    AlertDialogFooter,
    AlertDialogAction,
    AlertDialogCancel,
  } from "@/components/ui/alert-dialog";
  import AppLayout from "@/layouts/customisedLayout/AppLayoutAdmin.vue";
  import axios from "axios";
  import { useToast } from "vue-toastification";

  const page = usePage();
  const toast = useToast();

  const props = defineProps({
    rows: Array,
  });
  const handleDelete = async (id) => {
    console.log("Deleting floor with ID:", id);
    try {



        const response = await axios.delete(route('floors.destroy',id), {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content,
            },
        });

        if (response.status === 204) {
            toast.success('Floor deleted successfully!', { timeout: 3000 });
            window.location.reload();
        }
        if (response.status===409){
            toast.success('There is rooms in this floor can not  delete!', { timeout: 3000 });
            window.location.reload();
        }
    } catch (error) {

        console.error('Delete Error:', error);
        toast.error('Failed to delete floor.');
    }
};

  const breadcrumbs = [
    {
      title: "Floors",
      href: "/floors",
    },
  ];
  </script>
