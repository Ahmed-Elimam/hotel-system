<template>
    <div class="flex flex-col min-h-screen bg-cover bg-center" :style="{ backgroundImage: 'url(/images/background.jpg)' } ">
      <!-- Header -->
      <header class="bg-white/80 backdrop-blur-md shadow-md">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
          <!-- Company Logo -->
          <div class="text-2xl font-bold text-gray-800">
            The Royal Crest
          </div>
  
          <!-- Navigation Buttons -->
          <nav class="space-x-4 text-gray-800">
            <Button variant="ghost">Home</Button>
            <Button variant="ghost">About</Button>
            <Button variant="ghost">Contact Us</Button>
          </nav>
        </div>
      </header>
  
      <!-- Body -->
      <main class="flex-grow container mx-auto px-6 py-12 flex items-center justify-center">
        <div class="text-center bg-white/80 backdrop-blur-md p-8 rounded-lg shadow-lg">
          <h1 class="text-4xl font-bold text-gray-800 mb-4">
            Welcome to Our Hotel
          </h1>
          <p class="text-lg text-gray-600 mb-8">
            Providing luxury accommodations and top-tier hospitality services worldwide.
          </p>
          <nav class="space-x-4 text-gray-800">
            <a href="/register" class="bg-white text-black px-4 py-2 mt-4 rounded-lg shadow-md border border-gray-300 hover:bg-gray-100 transition">
                Register
            </a>
            <a href="/login" class="bg-white text-black px-4 py-2 mt-4 rounded-lg shadow-md border border-gray-300 hover:bg-gray-100 transition">
                Log in
            </a>
          </nav>
          
        </div>
      </main>
      
    </div>

  </template>
  
  <script setup>
  import { Button } from '@/components/ui/button';
  </script>
