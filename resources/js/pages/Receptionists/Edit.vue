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
        title: 'Edit Receptionist Data',
        href: '/Edit',
    },
];
const props = defineProps({
  row: Object, 
});
const form = useForm({
  name: props.row.name || "",
  email: props.row.email || "",
  phone: props.row.phone || "",
  address: props.row.address || "",
  salary: props.row.salary || "",
  national_id: props.row.national_id || "",
  gender: props.row.gender || "",
  avatar_image: null,
});

const imagePreview = ref(props.row.avatar || "");
const showPassword = ref(false);

const handleImageChange = (event) => {
  const file = event.target.files[0];
  if (file) {
    form.avatar_image = file;
    const reader = new FileReader();
    reader.onload = (e) => {
      imagePreview.value = e.target.result;
    };
    reader.readAsDataURL(file);
  }
};

const onSubmit = () => {
  form.put(route('receptionists.update', props.row.id), {
    preserveScroll: true,
    onSuccess: () => {
      toast.success("Receptionist Updated successfully!");
      form.reset();
      imagePreview.value = "";
    },
    onError: (errors) => {
      toast.error("Please fix the errors in the form.");
    },
  });
};

const confirmReset = () => {
  form.reset();
  imagePreview.value = "";
  toast.info("Form has been reset");
};
</script>

<template>
  <Head title="Edit Receptionist Data" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="max-w-5xl mx-auto space-y-6 p-6">
      <Card>
        <CardContent class="p-6">
          <h1 class="text-2xl font-bold mb-6">Update Receptionist</h1>
          
          <Tabs defaultValue="basic" class="w-full">
            <TabsList>
              <TabsTrigger value="basic">Basic Information</TabsTrigger>
              <TabsTrigger value="account">Account Information</TabsTrigger>
            </TabsList>
            
            <Form @submit="onSubmit">
              <TabsContent value="basic">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                  <div class="space-y-4">
                    <FormField name="name">
                      <FormItem>
                        <FormLabel>Full Name</FormLabel>
                        <FormControl>
                          <Input v-model="form.name" placeholder="Enter full name" />
                        </FormControl>
                        <FormMessage />
                        <p v-if="form.errors.name" class="text-red-500 text-sm">{{ form.errors.name }}</p>
                      </FormItem>
                    </FormField>
                    
                    <FormField name="email">
                      <FormItem>
                        <FormLabel>Email</FormLabel>
                        <FormControl>
                          <Input v-model="form.email" type="email" placeholder="Enter email address" />
                        </FormControl>
                        <FormMessage />
                        <p v-if="form.errors.email" class="text-red-500 text-sm">{{ form.errors.email }}</p>
                      </FormItem>
                    </FormField>
                    
                    <FormField name="phone">
                      <FormItem>
                        <FormLabel>Phone</FormLabel>
                        <FormControl>
                          <Input v-model="form.phone" placeholder="Enter phone number" />
                        </FormControl>
                        <FormMessage />
                      </FormItem>
                    </FormField>
                    
                    <FormField name="address">
                      <FormItem>
                        <FormLabel>Address</FormLabel>
                        <FormControl>
                          <Input v-model="form.address" placeholder="Enter address" />
                        </FormControl>
                        <FormMessage />
                      </FormItem>
                    </FormField>
                  </div>
                  
                  <div class="space-y-4">
                    <FormField name="salary">
                      <FormItem>
                        <FormLabel>Salary</FormLabel>
                        <FormControl>
                          <Input id="salary" type="number" v-model="form.salary" placeholder="Enter salary amount" />
                        </FormControl>
                        <FormMessage />
                      </FormItem>
                    </FormField>
                    
                    <FormField name="national_id">
                      <FormItem>
                        <FormLabel>National ID</FormLabel>
                        <FormControl>
                          <Input v-model="form.national_id" placeholder="Enter national ID" />
                        </FormControl>
                        <FormMessage />
                        <p v-if="form.errors.national_id" class="text-red-500 text-sm">{{ form.errors.national_id }}</p>
                      </FormItem>
                    </FormField>
                    
                    <FormField name="gender">
                      <FormItem>
                        <FormLabel>Gender</FormLabel>
                        <Select v-model="form.gender">
                          <FormControl>
                            <SelectTrigger>
                              <SelectValue placeholder="Select Gender" />
                            </SelectTrigger>
                          </FormControl>
                          <SelectContent>
                            <SelectItem value="Male">Male</SelectItem>
                            <SelectItem value="Female">Female</SelectItem>
                          </SelectContent>
                        </Select>
                        <FormMessage />
                      </FormItem>
                    </FormField>
                  </div>
                </div>
                
                <Separator class="my-6" />
                
                <div class="flex flex-col md:flex-row gap-6 items-center">
                  <div class="w-full md:w-1/2">
                    <FormField name="avatar_image">
                      <FormItem>
                        <FormLabel>Avatar Image</FormLabel>
                        <FormControl>
                          <Input 
                            type="file" 
                            accept="image/*"
                            @change="handleImageChange" 
                          />
                        </FormControl>
                        <FormMessage />
                        <p v-if="form.errors.avatar_image" class="text-red-500 text-sm">{{ form.errors.avatar_image }}</p>
                      </FormItem>
                    </FormField>
                  </div>
                  
                  <div class="flex justify-center">
                    <Avatar class="w-32 h-32">
                      <AvatarImage :src="imagePreview" />
                      <AvatarFallback>
                        Choose Avatar
                      </AvatarFallback>
                    </Avatar>
                  </div>
                </div>
              </TabsContent>
              
              <TabsContent value="account">
                <div class="space-y-4 mt-4">
                  <FormField name="username">
                    <FormItem>
                      <FormLabel>Username</FormLabel>
                      <FormControl>
                        <Input v-model="form.username" placeholder="Enter username" />
                      </FormControl>
                      <FormMessage />
                      <p v-if="form.errors.username" class="text-red-500 text-sm">{{ form.errors.username }}</p>
                    </FormItem>
                  </FormField>
                  
                  <FormField name="password">
                    <FormItem>
                      <FormLabel>Password</FormLabel>
                      <div class="flex">
                        <FormControl>
                          <Input 
                            :type="showPassword ? 'text' : 'password'" 
                            v-model="form.password"
                            placeholder="Enter password"
                            class="flex-1"
                          />
                        </FormControl>
                        <Button 
                          type="button" 
                          variant="outline" 
                          class="ml-2"
                          @click="showPassword = !showPassword"
                        >
                          {{ showPassword ? 'Hide' : 'Show' }}
                        </Button>
                      </div>
                      <FormMessage />
                      <p v-if="form.errors.password" class="text-red-500 text-sm">{{ form.errors.password }}</p>
                    </FormItem>
                  </FormField>
                  
                  <FormField name="password_confirmation">
                    <FormItem>
                      <FormLabel>Password Confirmation</FormLabel>
                      <div class="flex">
                        <FormControl>
                          <Input 
                            :type="showPassword ? 'text' : 'password'" 
                            v-model="form.password_confirmation"
                            placeholder="Confirm password"
                            class="flex-1"
                          />
                        </FormControl>
                      </div>
                      <FormMessage />
                      <p v-if="form.errors.password_confirmation" class="text-red-500 text-sm">{{ form.errors.password_confirmation }}</p>
                    </FormItem>
                  </FormField>
                </div>
              </TabsContent>
              
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
                  <Link href="/receptionists" class="px-6">Back to List</Link>
                </Button>
              </div>
            </Form>
          </Tabs>
        </CardContent>
      </Card>
    </div>
  </AppLayout>
</template>