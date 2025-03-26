<script setup>
import { defineProps, ref, computed } from 'vue';
import { useForm, usePage } from '@inertiajs/vue3';
import { toast } from 'vue-sonner';
import { Input } from "@/components/ui/input";
import { Button } from "@/components/ui/button";
import { Card, CardContent } from "@/components/ui/card";
import { AlertDialog, AlertDialogTrigger, AlertDialogContent, AlertDialogHeader, AlertDialogTitle, AlertDialogDescription, AlertDialogFooter, AlertDialogAction, AlertDialogCancel } from "@/components/ui/alert-dialog";
import { Link } from "@inertiajs/vue3";
import AppLayout from '@/layouts/customisedLayout/AppLayoutClient.vue';
import { Form, FormField, FormItem, FormLabel, FormControl, FormMessage } from "@/components/ui/form";
import { Head } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3'
import  PaymentProcess  from "@/components/customisedComponents/PaymentProcess.vue"


// Define props
const props = defineProps({
  room: Object,
  clients: Array
});

// Get authenticated user
const page = usePage();

const user = page.props.auth.user;

// Initialize form
const form = useForm({
  accompany_number: "",
  check_in: "",
  check_out: "",
  paid_price: "",
  room_id: props.room?.id || "",
  user_id: user.id,
  room_creator_id: props.room?.room_creator_id || "",
  total_cost: "",
});

const goBack = () => {
  router.visit('/reservations/available-rooms');
};
const reservationDuration = computed(() => {
  if (form.check_in && form.check_out) {
    const startDate = new Date(form.check_in);
    const endDate = new Date(form.check_out);

    if (endDate <= startDate) {
      toast.error("Check-out date must be later than check-in date.");
      return 0;
    }
    return (endDate - startDate) / (1000 * 60 * 60 * 24);
  }
  return "";
});
const totalCost = computed(() => {
  return reservationDuration.value ? reservationDuration.value * (props.room.price / 100) : 0;
});


// const onSubmit = () => {
//   form.post(route(''), {
//     preserveScroll: true,
//     onSuccess: () => {
//       toast.success("Reservation created successfully!");
//       form.reset();
//     },
//     onError: () => {
//       toast.error("Please fix the errors in the form.");
//     }
//   });
// };

const confirmReset = () => {
  form.reset();
  toast.info("Form has been reset");
};

// Breadcrumbs for navigation
const breadcrumbs = [{ title: 'Reservation' }];
</script>

<template>

  <Head title="Create Reservation" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="max-w-7xl mx-auto space-y-6 p-6">
      <Card>
        <CardContent class="p-6">
          <h1 class="text-2xl font-bold mb-6">Create New Reservation</h1>

          <Form @submit="onSubmit">
            <div class="space-y-4">


              <FormField name="accompany_number">
                <FormItem>
                  <FormLabel>Accompany Number</FormLabel>
                  <FormControl>
                    <Input v-model="form.accompany_number" type="text" placeholder="Enter Accompany Number" />
                  </FormControl>
                </FormItem>
              </FormField>

              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <FormField name="room_capacity">
                  <FormItem>
                    <FormLabel>Number of Guests</FormLabel>
                    <FormControl>
                      <Input :value="props.room.capacity" type="text" disabled :placeholder="props.room.capacity" />
                    </FormControl>
                  </FormItem>
                </FormField>

                <FormField name="paid_price">
                  <FormItem>
                    <FormLabel>Paid Price ($ per night)</FormLabel>
                    <FormControl>
                      <Input :value="props.room.price / 100" type="number" step="0.01" min="0"
                        :placeholder="props.room.price / 100" disabled />
                    </FormControl>
                  </FormItem>
                </FormField>
              </div>

              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <FormField name="check_in">
                  <FormItem>
                    <FormLabel>Check-in Date</FormLabel>
                    <FormControl>
                      <Input v-model="form.check_in" type="datetime-local" />
                    </FormControl>
                    <FormMessage />
                    <p v-if="form.errors.check_in" class="text-red-500 text-sm">{{ form.errors.check_in }}</p>
                  </FormItem>
                </FormField>

                <FormField name="check_out">
                  <FormItem>
                    <FormLabel>Check-out Date</FormLabel>
                    <FormControl>
                      <Input v-model="form.check_out" type="datetime-local" />
                    </FormControl>
                    <FormMessage />
                    <p v-if="form.errors.check_out" class="text-red-500 text-sm">{{ form.errors.check_out }}</p>
                  </FormItem>
                </FormField>
              </div>

              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <FormField name="booking_days">
                  <FormItem>
                    <FormLabel>Booking Days</FormLabel>
                    <FormControl>
                      <Input :value="reservationDuration" type="text" readonly disabled />
                    </FormControl>
                  </FormItem>
                </FormField>

                <FormField name="total_cost">
                  <FormItem>
                    <FormLabel>Total Cost ($)</FormLabel>
                    <FormControl>
                      <Input :value="totalCost" type="number" readonly disabled />                    </FormControl>
                  </FormItem>
                </FormField>
              </div>
            </div>

            <div class="flex justify-center space-x-4 mt-8">
              <PaymentProcess :accompany_number="form.accompany_number" :check_in="new Date(form.check_in)"
                :check_out="new Date(form.check_out)" :paid_price="totalCost" :room_id="form.room_id" :room_creator_id="form.room_creator_id" />

              <AlertDialog>
                <AlertDialogTrigger asChild>
                  <Button type="button" variant="destructive">Reset</Button>
                </AlertDialogTrigger>
                <AlertDialogContent>
                  <AlertDialogHeader>
                    <AlertDialogTitle>Are you sure?</AlertDialogTitle>
                    <AlertDialogDescription>
                      This will clear all form fields.
                      Any entered data will be lost.
                    </AlertDialogDescription>
                  </AlertDialogHeader>
                  <AlertDialogFooter>
                    <AlertDialogCancel>Cancel</AlertDialogCancel>
                    <AlertDialogAction @click="confirmReset">Continue</AlertDialogAction>
                  </AlertDialogFooter>
                </AlertDialogContent>
              </AlertDialog>

              <Button @click="goBack" variant="outline" class="px-6"> Back to List</Button>

            </div>

          </Form>
        </CardContent>
      </Card>
    </div>
  </AppLayout>
</template>
