<template>
    <AuthBase title="Welcome to Our Hotel " description="Enter your details below to create your account and wait for approval">
        <Head title="Register" />

        <form @submit.prevent="submit" class="flex flex-col gap-6">
            <div class="grid gap-6">
                <!-- Name Input Field -->
                <div class="grid gap-2">
                    <Label for="name">Name</Label>
                    <Input id="name" type="text" required autofocus v-model="form.name" placeholder="Full name" />
                    <InputError :message="form.errors.name" />
                </div>

                <!-- Email Input Field -->
                <div class="grid gap-2">
                    <Label for="email">Email address</Label>
                    <Input id="email" type="email" required v-model="form.email" placeholder="email@example.com" />
                    <InputError :message="form.errors.email" />
                </div>

                <!-- Password Input Field -->
                <div class="grid gap-2">
                    <Label for="password">Password</Label>
                    <Input id="password" type="password" required v-model="form.password" placeholder="Password" />
                    <InputError :message="form.errors.password" />
                </div>

                <!-- Password Confirmation Input Field -->
                <div class="grid gap-2">
                    <Label for="password_confirmation">Confirm password</Label>
                    <Input id="password_confirmation" type="password" required v-model="form.password_confirmation" placeholder="Confirm password" />
                    <InputError :message="form.errors.password_confirmation" />
                </div>

                <!-- National ID Input Field -->
                <div class="grid gap-2">
                    <Label for="national_id">National ID</Label>
                    <Input id="national_id" type="text" required v-model="form.national_id" placeholder="Enter National ID" />
                    <InputError :message="form.errors.national_id" />
                </div>

                <!-- Phone Input Field -->
                <div class="grid gap-2">
                    <Label for="phone">Phone</Label>
                    <Input id="phone" type="text" required v-model="form.phone" placeholder="Enter Phone Number" />
                    <InputError :message="form.errors.phone" />
                </div>

                <!-- Gender Select Field -->
                <div class="grid gap-2">
                    <Label for="gender">Gender</Label>
                    <select id="gender" v-model="form.gender" class="border rounded p-2">
                        <option value="" disabled>Select Gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                    <InputError :message="form.errors.gender" />
                </div>

                <!-- Country Select Field -->
                <div class="grid gap-2">
                    <Label for="country">Country</Label>
                    <select id="country" v-model="form.country_id" required class="border rounded p-2">
                        <option value="" disabled>Select Country</option>
                        <option v-for="country in props.countries" :key="country.id" :value="country.id">
                            {{ country.name }}
                        </option>
                    </select>
                    <InputError :message="form.errors.country_id" />
                </div>

                <!-- Avatar Image Upload Field -->
                <div class="grid gap-2">
                    <Label for="avatar_image">Avatar Image</Label>
                    <Input id="avatar_image" type="file" accept=".jpg,.jpeg" @change="handleFileUpload" />
                    <InputError :message="form.errors.avatar_image" />
                </div>

                <!-- Submit Button -->
                <Button type="submit" class="mt-2 w-full" :disabled="form.processing">
                    <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                    Create account
                </Button>
            </div>

            <!-- Login Link -->
            <div class="text-center text-sm text-muted-foreground">
                Already have an account?
                <TextLink :href="route('login')" class="underline underline-offset-4">Log in</TextLink>
            </div>
        </form>
    </AuthBase>
</template>

<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthBase from '@/layouts/AuthLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';

const props = defineProps({
    countries: {
        type: Array,
        default: () => [] 
    }
});

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    national_id: '',
    phone: '',
    gender: '',
    country_id: '',
    avatar_image: null,
});

// Handle file upload for avatar image
const handleFileUpload = (event: Event) => {
    const target = event.target as HTMLInputElement;
    if (target.files && target.files[0]) {
        const file = target.files[0];
        if (file.type === 'image/jpeg' || file.type === 'image/jpg') {
            form.avatar_image = file;
        } else {
            form.avatar_image = null; // Let backend set default if invalid
        }
    }
};

const submit = () => {
    const formData = new FormData();
    formData.append('name', form.name);
    formData.append('email', form.email);
    formData.append('password', form.password);
    formData.append('password_confirmation', form.password_confirmation);
    formData.append('national_id', form.national_id);
    formData.append('phone', form.phone);
    formData.append('gender', form.gender);
    formData.append('country_id', form.country_id);
    if (form.avatar_image) {
        formData.append('avatar_image', form.avatar_image);
    }

    form.post(route('register'), {
        onFinish: () => form.reset('password_confirmation',),
        preserveScroll: true,
    });
};
</script>

