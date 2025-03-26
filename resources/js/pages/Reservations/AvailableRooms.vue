<template>
    <Head title="Available Rooms" />

    <AppLayout :breadcrumbs="breadcrumbs">
      <div class="w-full px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
        <div v-if="!props.rows || props.rows.length === 0" class="text-center py-12">
          <div class="inline-flex items-center justify-center bg-gray-100 rounded-full p-4 mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 sm:h-12 sm:w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
          </div>
          <h3 class="text-base sm:text-lg font-medium text-gray-700">No rooms available</h3>
          <p class="mt-1 text-sm sm:text-base text-gray-500">Please check back later or contact to hotel</p>
        </div>

        <div v-else class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 lg:gap-8 py-2">
          <Card
            v-for="room in props.rows"
            :key="room.id"
            class="w-full hover:shadow-xl transition-all duration-300 border border-gray-100 overflow-hidden"
          >
            <div class="relative bg-blue-50 p-4 sm:p-6 flex justify-start items-center">
              <div class="flex items-center space-x-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
                <CardTitle class="text-xl sm:text-2xl font-bold text-gray-800">
                  <span class="text-blue-600">Room No : {{ room.room_number }}</span>
                </CardTitle>
              </div>

            </div>

            <CardHeader class="px-4 sm:px-6 pt-4 pb-2">
              <CardDescription class="text-gray-500 mt-1 text-sm">Floor {{ room.floor_id }}</CardDescription>
            </CardHeader>

            <CardContent class="px-4 sm:px-6 py-2 space-y-4">
              <div class="grid grid-cols-2 gap-2 sm:gap-4">
                <div class="flex items-center space-x-1 sm:space-x-2">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                  <div>
                    <p class="text-xs sm:text-sm text-gray-500">Price</p>
                    <p class="text-sm sm:text-base font-semibold">${{ ((room.price)/100).toLocaleString() }}/night</p>
                  </div>
                </div>

                <div class="flex items-center space-x-1 sm:space-x-2">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                  </svg>
                  <div>
                    <p class="text-xs sm:text-sm text-gray-500">Capacity</p>
                    <p class="text-sm sm:text-base font-semibold">{{ room.capacity }} {{ room.capacity > 1 ? 'Guests' : 'Guest' }}</p>
                  </div>
                </div>
              </div>

              <div class="pt-4 border-t border-gray-100">
                <h4 class="text-xs sm:text-sm font-medium text-gray-700 mb-2">Room Features</h4>
                <div class="flex flex-wrap gap-1 sm:gap-2">
                  <Badge variant="outline" class="flex items-center space-x-1 px-2 py-1 sm:px-3 sm:py-1 rounded-full text-xs sm:text-sm text-blue-500 font-bold">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 sm:h-4 sm:w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0" />
                    </svg>
                    <span>WiFi</span>
                  </Badge>
                  <Badge variant="outline" class="flex items-center space-x-1 px-2 py-1 sm:px-3 sm:py-1 rounded-full text-xs sm:text-sm text-blue-500 font-bold ">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 sm:h-4 sm:w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z " />
                    </svg>
                    <span>TV</span>
                  </Badge>
                  <Badge variant="outline" class="flex items-center space-x-1 px-2 py-1 sm:px-3 sm:py-1 rounded-full text-xs sm:text-sm text-blue-500 font-bold">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 sm:h-4 sm:w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z" />
                    </svg>
                    <span>AC</span>
                  </Badge>
                </div>
              </div>
            </CardContent>

            <CardFooter class="px-4 sm:px-6 py-4 bg-gray-50">
              <Button asChild class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 sm:py-3 rounded-lg font-medium transition-colors duration-300 ">

                <Link :href="route('reservations.make_reservation_form', { id: room.id })">Book </Link>

              </Button>
            </CardFooter>
          </Card>
        </div>
      </div>
    </AppLayout>
</template>

  <script setup>
  import { Link, usePage } from "@inertiajs/vue3";
  import { Button } from '@/components/ui/button';
  import { Card, CardHeader, CardTitle, CardDescription, CardContent, CardFooter } from '@/components/ui/card';

  import { Head } from '@inertiajs/vue3';
  import AppLayout from '@/layouts/customisedLayout/AppLayoutClient.vue';

  import { computed, defineProps } from 'vue';
  import {
      getCoreRowModel,
      useVueTable,
  } from "@tanstack/vue-table";


  const props = defineProps({
      rows: {
          type: Array,
          default: () => []
      }
  });

  const breadcrumbs = [
    {
      title: 'Reservation',
      href: '/reservations',
    },
  ];

  const columns = [
      {
          accessorKey: 'room_number',
          header: 'Room Number',
      },
      {
          accessorKey: 'floor_id',
          header: 'Floor Name',
      },
      {
          accessorKey: 'price',
          header: 'Price per night',
      },
      {
          accessorKey: 'capacity',
          header: 'Number Of Guests',
      },
  ];


  const table = useVueTable({
      data: computed(() => props.rows),
      columns: computed(() => columns),
      getCoreRowModel: getCoreRowModel(),
  });
  </script>
