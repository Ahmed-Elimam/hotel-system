<script setup>
import { usePage } from '@inertiajs/vue3';
import { Table, TableHeader, TableBody, TableRow, TableHead, TableCell } from '@/components/ui/table';

const props = defineProps({ rows: Array });
</script>

<template>
  <div class="p-6 space-y-6">
    <h1 class="text-2xl font-bold">Clients Reservations</h1>

    <Table>
      <TableHeader>
        <TableRow>
          <TableHead>Client Name</TableHead>
          <TableHead>Accompany Number</TableHead>
          <TableHead>Room Number</TableHead>
          <TableHead>Paid Price</TableHead>
        </TableRow>
      </TableHeader>
      <TableBody>
        <TableRow v-for="reservation in rows" :key="reservation.id">
          <TableCell>{{ reservation.client?.name || 'Unknown' }}</TableCell>
          <TableCell>{{ reservation.accompany_number }}</TableCell>
          <TableCell>{{ reservation.room?.room_number || 'N/A' }}</TableCell>
          <TableCell>${{ reservation.paid_price }}</TableCell>
        </TableRow>
        <TableRow v-if="rows.length === 0">
          <TableCell colspan="4" class="text-center py-4 text-gray-500">No reservations found.</TableCell>
        </TableRow>
      </TableBody>
    </Table>
  </div>
</template>
