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

const form = useForm({
  name: "",
  email: "",
  password: "",
  password_confirmation: "",
  national_id: "",
  avatar_image: null,
});

const imagePreview = ref("");
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
  form.post(route('managers.store'), {
    preserveScroll: true,
    onSuccess: () => {
      toast.success("Manager created successfully!");
      console.log("s")
      form.reset();
      imagePreview.value = "";
    },
    onError: (errors) => {
      toast.error("Please fix the errors in the form.");
      console.log("f",errors)
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
  <div class="max-w-5xl mx-auto space-y-6 p-6">
    <Card>
      <CardContent class="p-6">
        <h1 class="text-2xl font-bold mb-6">Create New Manager</h1>

        <form @submit.prevent="onSubmit">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
            <div class="space-y-4">
              <div>
                <label class="font-medium">Full Name</label>
                <Input v-model="form.name" placeholder="Enter full name" />
                <p v-if="form.errors.name" class="text-red-500 text-sm">{{ form.errors.name }}</p>
              </div>
              
              <div>
                <label class="font-medium">Email</label>
                <Input v-model="form.email" type="email" placeholder="Enter email address" />
                <p v-if="form.errors.email" class="text-red-500 text-sm">{{ form.errors.email }}</p>
              </div>

              <div>
                <label class="font-medium">National ID</label>
                <Input v-model="form.national_id" placeholder="Enter national ID" />
                <p v-if="form.errors.national_id" class="text-red-500 text-sm">{{ form.errors.national_id }}</p>
              </div>
            </div>
          </div>

          <div class="flex flex-col md:flex-row gap-6 items-center mt-6">
            <div class="w-full md:w-1/2">
              <label class="font-medium">Avatar Image</label>
              <Input type="file" accept="image/*" @change="handleImageChange" />
            </div>

            <div class="flex justify-center">
              <Avatar class="w-32 h-32">
                <AvatarImage :src="imagePreview" />
                <AvatarFallback>?</AvatarFallback>
              </Avatar>
              <p v-if="form.errors.avatar_image" class="text-red-500 text-sm">{{ form.errors.avatar_image }}</p>
            </div>
          </div>

          <div class="mt-6">
            <label class="font-medium">Password</label>
            <div class="flex">
              <Input :type="showPassword ? 'text' : 'password'" v-model="form.password" placeholder="Enter password" class="flex-1"/>
              <Button type="button" variant="outline" class="ml-2" @click="showPassword = !showPassword">
                {{ showPassword ? 'Hide' : 'Show' }}
              </Button>
              <p v-if="form.errors.password" class="text-red-500 text-sm">{{ form.errors.password }}</p>
            </div>
          </div>
          <div class="mt-6">
            <label class="font-medium">Password Confirmation</label>
            <div class="flex">
              <Input :type="showPassword ? 'text' : 'password'" v-model="form.password_confirmation" placeholder="Confirm password" class="flex-1"/>
              <Button type="button" variant="outline" class="ml-2" @click="showPassword = !showPassword">
                {{ showPassword ? 'Hide' : 'Show' }}
              </Button>
              <p v-if="form.errors.password_confirmation" class="text-red-500 text-sm">{{ form.errors.password_confirmation }}</p>
            </div>
          </div>
          
          <div class="flex justify-center space-x-4 mt-8">
            <Button type="submit" class="bg-blue-600 hover:bg-blue-700">Create Manager</Button>

            <AlertDialog>
              <AlertDialogTrigger asChild>
                <Button type="button" variant="destructive">Reset</Button>
              </AlertDialogTrigger>
              <AlertDialogContent>
                <AlertDialogHeader>
                  <AlertDialogTitle>Are you sure?</AlertDialogTitle>
                  <AlertDialogDescription>
                    This will clear all form fields. Any entered data will be lost.
                  </AlertDialogDescription>
                </AlertDialogHeader>
                <AlertDialogFooter>
                  <AlertDialogCancel>Cancel</AlertDialogCancel>
                  <AlertDialogAction @click="confirmReset">Continue</AlertDialogAction>
                </AlertDialogFooter>
              </AlertDialogContent>
            </AlertDialog>

            <Link :href="route('managers.index')">
              <Button variant="outline">Back to List</Button>
            </Link>
          </div>
        </form>
      </CardContent>
    </Card>
  </div>
</template>