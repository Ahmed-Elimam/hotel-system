<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { toast } from 'vue-sonner';
import { Input } from "@/components/ui/input";
import { Button } from "@/components/ui/button";
import { Card, CardContent } from "@/components/ui/card";
import { AlertDialog, AlertDialogTrigger, AlertDialogContent, AlertDialogHeader, AlertDialogTitle, AlertDialogDescription, AlertDialogFooter, AlertDialogAction, AlertDialogCancel } from "@/components/ui/alert-dialog";
import { Link, Head } from "@inertiajs/vue3";
import { Form, FormField, FormItem, FormLabel, FormControl, FormMessage } from "@/components/ui/form";
import { Separator } from "@/components/ui/separator";
import AppLayout from '@/layouts/customisedLayout/AppLayoutAdmin.vue';


const form = useForm({
  name: "",
});


const onSubmit = () => {
  form.post(route('floors.store'), {
    preserveScroll: true,
    onSuccess: () => {
      toast.success("Floor created successfully!");
      form.reset();
    },
    onError: (errors) => {
      toast.error("Please fix the errors in the form.");
      console.log("Form errors:", errors);
    },
  });
};

const confirmReset = () => {
  form.reset();
  toast.info("Form has been reset");
};

// Breadcrumbs for navigation
const breadcrumbs = [
  {
    title: 'Floors',
    href: '/floors',
  },
  {
    title: 'Add new Floor',
    href: '/floors/create',
  },
];
</script>

<template>
  <Head title="Add Floor" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="max-w-5xl mx-auto space-y-6 p-6">
      <Card>
        <CardContent class="p-6">
          <h1 class="text-2xl font-bold mb-6">Create New Floor</h1>

          <Form @submit="onSubmit">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
              <div class="col-span-1 md:col-span-3 space-y-4">
                <FormField name="name">
                  <FormItem>
                    <FormLabel>Floor Name</FormLabel>
                    <FormControl>
                      <Input v-model="form.name" placeholder="Enter floor name" />
                    </FormControl>
                    <FormMessage />
                    <p v-if="form.errors.name" class="text-red-500 text-sm">{{ form.errors.name }}</p>
                  </FormItem>
                </FormField>
              </div>
            </div>

            <Separator class="my-6" />

            <div class="flex justify-center space-x-4 mt-8">
              <Button type="submit" class="bg-blue-600 hover:bg-blue-700">Create Floor</Button>

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
                <Link href="/floors" class="px-6">Back to List</Link>
              </Button>
            </div>
          </Form>
        </CardContent>
      </Card>
    </div>
  </AppLayout>
</template>
