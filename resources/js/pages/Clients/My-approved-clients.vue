<script setup>
import { usePage } from '@inertiajs/vue3';
import { Table, TableHeader, TableBody, TableRow, TableHead, TableCell } from '@/components/ui/table';

const props = defineProps({ rows: Array });
</script>

<template>
  <div class="p-6 space-y-6">
    <h1 class="text-2xl font-bold">My Approved Clients</h1>

    <Table>
      <TableHeader>
        <TableRow>
          <TableHead>Name</TableHead>
          <TableHead>Email</TableHead>
          <TableHead>Phone</TableHead>
          <TableHead>Country</TableHead>
          <TableHead>Gender</TableHead>
        </TableRow>
      </TableHeader>
      <TableBody>
        <TableRow v-for="client in rows" :key="client.id">
          <TableCell>{{ client.name }}</TableCell>
          <TableCell>{{ client.email }}</TableCell>
          <TableCell>{{ client.phone }}</TableCell>
          <TableCell>{{ client.country?.name || 'N/A' }}</TableCell>
          <TableCell>{{ client.gender }}</TableCell>
        </TableRow>
        <TableRow v-if="rows.length === 0">
          <TableCell colspan="5" class="text-center py-4 text-gray-500">No approved clients found.</TableCell>
        </TableRow>
      </TableBody>
    </Table>
  </div>
</template>
