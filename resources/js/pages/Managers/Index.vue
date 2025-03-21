]<template>
    <div class="p-6 space-y-6">
      <h1 class="text-2xl font-semibold">Manage Managers</h1>
  
      <!-- Add Manager Button -->
      <Button  class="bg-green-600 hover:bg-green-700"><Link :href="route('managers.create')"
         method="get">Add Manager</Link>
        </Button>
  
      <!-- Managers Table -->
      <Card>
        <CardContent class="overflow-x-auto">
          <Table>
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
              <TableRow v-for="manager in rows" :key="manager.id">
                <TableCell>{{ manager.id }}</TableCell>
                <TableCell>{{ manager.name }}</TableCell>
                <TableCell>{{ manager.email }}</TableCell>
                <TableCell>{{ manager.national_id }}</TableCell>
                <TableCell>
                  <Avatar>
                    <AvatarImage v-if="manager.avatar_image" :src="`/storage/${manager.avatar_image}`" alt="Avatar" />
                    
                  </Avatar>
                </TableCell>
                <TableCell class="space-x-2">
                  <!-- <Button variant="outline" @click="viewManager(manager)">View</Button> -->
                  <Button class="bg-yellow-500 text-black hover:bg-yellow-600"><Link :href="route('managers.edit', manager.id)" method="get">Update</Link> </Button>
                  <AlertDialog>
                <AlertDialogTrigger asChild>
                  <Button type="button" variant="destructive">Delete</Button>
                </AlertDialogTrigger>
                <AlertDialogContent>g
                  <AlertDialogHeader>
                    <AlertDialogTitle>Are you sure?</AlertDialogTitle>
                    <AlertDialogDescription>
                        Are you sure you want to delete this record
                    </AlertDialogDescription>
                  </AlertDialogHeader>
                  <AlertDialogFooter>
                    <AlertDialogCancel>Cancel</AlertDialogCancel>
                    <AlertDialogAction>
  <Link :href="route('managers.destroy', manager.id)" method="delete" as="button" preserve-scroll
  @success="handleSuccess" @error="handleError">
    Continue
  </Link>
</AlertDialogAction>

                    <!-- <AlertDialogAction><Link :href="route('managers.destroy', ${manager.id})" method="delete">Continue</Link>  </AlertDialogAction> -->
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
  </template>
  
  <script setup>
  import { Link } from "@inertiajs/vue3";

  import axios from 'axios';
  import { Button } from '@/components/ui/button';
  import { Card, CardContent } from '@/components/ui/card';
  import { Avatar, AvatarImage, AvatarFallback } from '@/components/ui/avatar';
  import { Table, TableHeader, TableBody, TableRow, TableHead, TableCell } from '@/components/ui/table';
  import { AlertDialog, AlertDialogTrigger, AlertDialogContent, AlertDialogHeader, AlertDialogTitle, AlertDialogDescription, AlertDialogFooter, AlertDialogAction, AlertDialogCancel } from "@/components/ui/alert-dialog";
  const props = defineProps({
  rows: Array, 
});

 const handleSuccess = function(){
    toast.success("Manager deleted successfully!");
    Inertia.reload({ only: ["rows"] });
  }
  const handleError = function(){
    toast.fail("failed process!");
  }
  </script>