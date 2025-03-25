<script setup>
import { defineAsyncComponent, defineProps } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { toast } from 'vue-sonner';
import { Input } from "@/components/ui/input";
import { Button } from "@/components/ui/button";
import { Card, CardContent } from "@/components/ui/card";
import { Avatar, AvatarImage, AvatarFallback } from "@/components/ui/avatar";
import { AlertDialog, AlertDialogTrigger, AlertDialogContent, AlertDialogHeader, AlertDialogTitle, AlertDialogDescription, AlertDialogFooter, AlertDialogAction, AlertDialogCancel } from "@/components/ui/alert-dialog";
import { Link } from "@inertiajs/vue3";
import { Form, FormField, FormItem, FormLabel, FormControl, FormMessage } from "@/components/ui/form";
import { Tabs, TabsList, TabsTrigger, TabsContent } from "@/components/ui/tabs";
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select";

const form = useForm({
  room_number: "",
  capacity: "",
  price: "",
  floor_id: "",
  // is_reserved: "",
});
const onSubmit = () => {
  console.log("Before submit - floor_id:", form.floor_id, "type:", typeof form.floor_id);
  form.post(route('rooms.store'), {
    preserveScroll: true,
    onSuccess: () => {
      toast.success("Room added successfully!");
      console.log("s")
      form.reset();

    },
    onError: (errors) => {
      toast.error("Please fix the errors in the form.");
      console.log("f", errors)
    },
  });
};

const confirmReset = () => {
  form.reset();
  imagePreview.value = "";
  toast.info("Form has been reset");
};
import { usePage } from "@inertiajs/vue3";

const userRoles = usePage().props.user.roles.map(role => role.name);
const AppLayout = defineAsyncComponent(() =>
  userRoles.includes("admin")
    ? import("@/layouts/customisedLayout/AppLayoutAdmin.vue")
    : userRoles.includes("manager") ?
      import("@/layouts/customisedLayout/AppLayoutManager.vue")
      : userRoles.includes("receptionist") ?
        import("@/layouts/customisedLayout/AppLayoutReceptionist.vue")
        : import("@/layouts/customisedLayout/AppLayoutClient.vue")
);

const props = defineProps({
  floors: Array
});

import { Head } from '@inertiajs/vue3';

const breadcrumbs = [
  {
    title: 'Add new room',
    href: '/add',
  },
];
</script>

<template>

  <Head title="Rooms" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="max-w-7xl mx-auto space-y-6 p-6">
      <Card>
        <CardContent class="p-6">
          <h1 class="text-2xl font-bold mb-6">Add new room</h1>

          <Form @submit="onSubmit">

            <div class="  mt-4">
              <div class="space-y-4">
                <FormField name="room_number">
                  <FormItem>
                    <FormLabel>Room Number</FormLabel>
                    <FormControl>
                      <Input v-model="form.room_number" type="number" placeholder="Room Number consisted of 4 digits" />
                    </FormControl>
                    <FormMessage />
                    <p v-if="form.errors.room_number" class="text-red-500 text-sm">{{ form.errors.room_number }}</p>

                  </FormItem>
                </FormField>

                <FormField name="capacity">
                  <FormItem>
                    <FormLabel>Capacity</FormLabel>
                    <FormControl>
                      <Input v-model="form.capacity" type="number" placeholder="Enter room capacity" />
                    </FormControl>
                    <FormMessage />
                    <p v-if="form.errors.capacity" class="text-red-500 text-sm">{{ form.errors.capacity }}</p>

                  </FormItem>
                </FormField>

                <FormField name="floor_id">
                  <FormItem>
                    <FormLabel>Floor Name</FormLabel>
                    <Select v-model="form.floor_id">
                      <FormControl>
                        <SelectTrigger class="w-full">
                          <SelectValue placeholder="Choose floor name" />
                        </SelectTrigger>
                      </FormControl>
                      <SelectContent>
                        <SelectItem v-for="floor in floors" :key="floor.id" :value="floor.id">
                          {{ floor.name }}
                        </SelectItem>
                      </SelectContent>
                      <p v-if="form.errors.floor_id" class="text-red-500 text-sm">{{ form.errors.floor_id }}</p>

                    </Select>
                  </FormItem>
                </FormField>

                <FormField name="price">
                  <FormItem>
                    <FormLabel>Price</FormLabel>
                    <FormControl>
                      <Input v-model="form.price" placeholder="Enter room price per day" type="number" />
                    </FormControl>
                    <FormMessage />
                    <p v-if="form.errors.price" class="text-red-500 text-sm">{{ form.errors.price }}</p>
                  </FormItem>
                </FormField>

                <!-- <FormField name="is_reserved">
                  <FormItem>
                    <FormLabel>Room Status</FormLabel>
                    <Select v-model="form.is_reserved">
                      <FormControl>
                        <SelectTrigger>
                          <SelectValue placeholder="Room is reserved" />
                        </SelectTrigger>
                      </FormControl>
                      <SelectContent>
                        <SelectItem value="false">Available</SelectItem>
                        <SelectItem value="true">Reserved</SelectItem>
                      </SelectContent>
                    </Select>
                    <FormMessage />
                  </FormItem>
                </FormField> -->
              </div>
            </div>



            <div class="flex justify-center space-x-4 mt-8">
              <Button type="submit" class="bg-blue-600 hover:bg-blue-700">Add Room</Button>

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
              <Button variant="outline" asChild>
                <Link href="/room" class="px-6">Back to List</Link>
              </Button>
            </div>
          </Form>
          <!-- </Tabs> -->
        </CardContent>
      </Card>
    </div>
  </AppLayout>

</template>
