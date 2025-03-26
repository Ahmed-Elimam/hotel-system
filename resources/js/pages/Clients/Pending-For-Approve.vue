<script setup>
import { usePage, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import { Button } from '@/components/ui/button';
import { Table, TableHeader, TableBody, TableRow, TableHead, TableCell } from '@/components/ui/table';
import { AlertDialog, AlertDialogTrigger, AlertDialogContent, AlertDialogHeader, AlertDialogTitle, AlertDialogDescription, AlertDialogFooter, AlertDialogCancel, AlertDialogAction } from "@/components/ui/alert-dialog";
import { useToast } from "vue-toastification";

const toast = useToast();
const props = defineProps({ rows: Array });

const approvingClient = ref(null);

const approveClient = () => {
  if (!approvingClient.value) return;
  router.post(route('clients.approve', approvingClient.value), {}, {
    preserveState: true,
    onSuccess: () => toast.success('Client approved successfully!'),
    onError: () => toast.error('Failed to approve client.'),
    onFinish: () => (approvingClient.value = null),
  });
};
</script>

<template>
  <div class="p-6 space-y-6">
    <h1 class="text-2xl font-bold">Pending Clients</h1>

    <Table>
      <TableHeader>
        <TableRow>
          <TableHead>Name</TableHead>
          <TableHead>Email</TableHead>
          <TableHead>Phone</TableHead>
          <TableHead>Country</TableHead>
          <TableHead>Gender</TableHead>
          <TableHead class="text-center">Action</TableHead>
        </TableRow>
      </TableHeader>
      <TableBody>
        <TableRow v-for="client in rows" :key="client.id">
          <TableCell>{{ client.name }}</TableCell>
          <TableCell>{{ client.email }}</TableCell>
          <TableCell>{{ client.phone }}</TableCell>
          <TableCell>{{ client.country?.name || 'N/A' }}</TableCell>
          <TableCell>{{ client.gender }}</TableCell>
          <TableCell class="text-center">
            <AlertDialog>
              <AlertDialogTrigger asChild>
                <Button @click="approvingClient = client.id" class="bg-green-600 text-white">Approve</Button>
              </AlertDialogTrigger>
              <AlertDialogContent>
                <AlertDialogHeader>
                  <AlertDialogTitle>Confirm Approval</AlertDialogTitle>
                  <AlertDialogDescription>Are you sure you want to approve {{ client.name }}?</AlertDialogDescription>
                </AlertDialogHeader>
                <AlertDialogFooter>
                  <AlertDialogCancel>Cancel</AlertDialogCancel>
                  <AlertDialogAction>
                    <Button @click="approveClient" class="bg-green-600 text-white">Confirm</Button>
                  </AlertDialogAction>
                </AlertDialogFooter>
              </AlertDialogContent>
            </AlertDialog>
          </TableCell>
        </TableRow>
        <TableRow v-if="rows.length === 0">
          <TableCell colspan="6" class="text-center py-4 text-gray-500">No pending clients.</TableCell>
        </TableRow>
      </TableBody>
    </Table>
  </div>
</template>
