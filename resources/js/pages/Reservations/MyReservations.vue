<template>
    <Head title="My Reservations" />
    
    <AppLayout :breadcrumbs="breadcrumbs">
      <div class="p-6 space-y-6">
        <h1 class="text-lg text-gray-600">Welcome, {{ clientName }}</h1>

        <h2 class="text-2xl font-semibold">Reservation History</h2>
  
        <Card>
          <CardContent class="overflow-x-auto">
            <Table>
              <TableHeader>
                <TableRow>
                  <TableHead v-for="column in columns" :key="column.accessorKey">
                    {{ column.header }}
                  </TableHead>
                  <TableHead>Room Number</TableHead>
                </TableRow>
              </TableHeader>
              <TableBody>
                <TableRow 
                  v-for="row in rows.data" 
                  :key="row.id">
                  <TableCell v-for="column in columns" :key="column.accessorKey">
                    {{ row[column.accessorKey] }}
                  </TableCell>
                  <TableCell>
                    {{ row.room?.room_number }}
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
          <div class="flex space-x-2">
            <Button
              variant="outline"
              size="sm"
              :disabled="!rows.prev_page_url"
              @click="goToPage(rows.current_page - 1)"
            >
              Previous
            </Button>
            <Button
              variant="outline"
              size="sm"
              :disabled="!rows.next_page_url"
              @click="goToPage(rows.current_page + 1)"
            >
              Next
            </Button>
          </div>
        </div>
      </div>
    </AppLayout>
  </template>
  
  <script setup>
  import { Head, router } from "@inertiajs/vue3";
  import { Button } from '@/components/ui/button';
  import { Card, CardContent } from '@/components/ui/card';
  import { Table, TableHeader, TableBody, TableRow, TableHead, TableCell } from '@/components/ui/table';
  import AppLayout from '@/layouts/customisedLayout/AppLayoutClient.vue';
  
  const props = defineProps({
    rows: {
      type: Object,
      required: true
    },
    clientName: {
      type: String,
      default: ''
    }
  });
  
  const breadcrumbs = [
    {
      title: 'My Reservations',
      href: '/my-reservations',
    },
  ];
  
  const columns = [
    {
      accessorKey: 'id',
      header: 'Reservation ID',
    },
    {
      accessorKey: 'check_in',
      header: 'Check-In Date',
    },
    {
      accessorKey: 'check_out',
      header: 'Check-Out Date',
    },
    {
      accessorKey: 'paid_price',
      header: 'Total Price',
    },
  ];
  
  const goToPage = (page) => {
    if (page < 1 || page > props.rows.last_page) return;
    router.get(route('reservations.my_reservations', { page }), {}, { 
      preserveState: true,
      preserveScroll: true 
    });
  };
  </script>