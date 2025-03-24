<script setup>
import { ref } from 'vue';
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
import { Separator } from "@/components/ui/separator";

import AppLayout from '@/layouts/customisedLayout/AppLayoutAdmin.vue';
import { Head } from '@inertiajs/vue3';

const breadcrumbs = [
    {
        title: 'Edit Floor Data',
        href: '/Edit',
    },
];

const props = defineProps({
  row: Object,
});

const form = useForm({
  name: props.row.name || "",
});

// Add the missing onSubmit function
const onSubmit = () => {
  form.put(route('floors.update', props.row.id), {
    onSuccess: () => {
        toast('Success', {
        description: 'Floor data is updated successfully!',
        type: 'success',
      });
    },
    onError: () => {
        toast('Error', {
        description: 'Failed to update Floor!',
        type: 'error',
      });
    }
  });
};

// Add the missing confirmReset function
const confirmReset = () => {
  form.name = props.row.name || "";
  setTimeout(() => {
    toast.info('Form has been reset');
  }, 100);
};
</script>

<template>
  <Head title="Edit manager data" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="max-w-5xl mx-auto space-y-6 p-6">
      <Card>
        <CardContent class="p-6">
          <h1 class="text-2xl font-bold mb-6">Update Floor Data</h1>

          <Form @submit="onSubmit">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
              <div class="col-span-1 md:col-span-3 space-y-4">
                <FormField name="Floor Name">
                  <FormItem>
                    <FormLabel>Floor Name</FormLabel>
                    <FormControl>
                        <Input class="w-full" v-model="form.name" placeholder="Enter Room Name" />
                    </FormControl>
                    <FormMessage />
                    <p v-if="form.errors.name" class="text-red-500 text-sm">{{ form.errors.name}}</p>
                  </FormItem>
                </FormField>
              </div>
            </div>
            <Separator class="my-6" />
            <div class="flex justify-center space-x-4 mt-8">
              <Button type="submit" class="bg-blue-600 hover:bg-blue-700">Update</Button>
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
