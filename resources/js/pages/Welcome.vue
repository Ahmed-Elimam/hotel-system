<template>
  <div class="flex flex-col min-h-screen bg-cover bg-center" >
    <!-- Header -->
   <div :style="{ backgroundImage: 'url(/images/background.jpg)' } ">
    <header class="bg-white/80 backdrop-blur-md shadow-md sticky top-0 z-50">
      <div class="container mx-auto px-6 py-4 flex justify-between items-center">
        <!-- Company Logo -->
        <div class="text-2xl font-bold text-gray-800 flex items-center">
          The Royal Crest
        </div>

        <!-- Navigation Buttons -->
        <nav class="hidden md:flex space-x-4 text-gray-800">
          <Button variant="ghost">Home</Button>
          <Button variant="ghost">Rooms & Suites</Button>
          <Button variant="ghost">Gallery</Button>
          <Button variant="ghost">Contact Us</Button>
        </nav>
        
      </div>
    </header>

    <!-- Hero Section -->
    <section class="relative h-screen flex items-center justify-center">
      <div class="absolute inset-0 bg-black/40"></div>
      <div class="text-center z-10 px-4">
        <h1 class="text-4xl md:text-6xl font-bold text-white mb-6">Experience Unparalleled Luxury</h1>
        <p class="text-xl text-white mb-8 max-w-2xl mx-auto">Discover our world-class amenities, exquisite dining, and breathtaking accommodations</p>
        <div class="space-x-4">
          <Button class="bg-amber-600 hover:bg-amber-700 text-white px-8 py-4 text-lg">
            <a href="/register">Register</a>
          </Button>
          <Button class="bg-amber-600 hover:bg-amber-700 text-white px-8 py-4 text-lg">
            <a href="/login">Log in</a>
          </Button>
        </div>

      </div>
    </section>
    </div>

    <!-- Welcome Section -->
    <section class="py-20 bg-white">
      <div class="container mx-auto px-6">
        <div class="flex flex-col md:flex-row items-center">
          <div class="md:w-1/2 mb-10 md:mb-0">
            <img src="/images/hotel.jpg" alt="Hotel Lobby" class=" rounded-lg shadow-xl">
          </div>
          <div class="md:w-1/2 md:pl-12">
            <h2 class="text-3xl font-bold text-gray-800 mb-6">Welcome to The Royal Crest</h2>
            <p class="text-gray-600 mb-6">Established in 1985, The Royal Crest has been synonymous with luxury hospitality. Our award-winning property combines timeless elegance with modern comforts to create an unforgettable experience.</p>
            <p class="text-gray-600 mb-8">Nestled in the heart of the city, we offer breathtaking views, world-class service, and amenities designed to pamper even the most discerning guests.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Rooms & Suites -->
    <section class="py-20 bg-gray-50">
      <div class="container mx-auto px-6">
        <div class="text-center mb-16">
          <h2 class="text-3xl font-bold text-gray-800 mb-4">Our Accommodations</h2>
          <p class="text-gray-600 max-w-2xl mx-auto">From elegant guest rooms to expansive suites, each space is designed with your comfort in mind</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
          <!-- Room Card 1 -->
          <div class="bg-white rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition">
            <img src="/images/deluxe-room.jpg" alt="Deluxe Room" class="w-full h-64 object-cover">
            <div class="p-6">
              <h3 class="text-xl font-bold text-gray-800 mb-2">Deluxe Room</h3>
              <p class="text-gray-600 mb-4">Spacious rooms with panoramic city views and premium amenities</p>
              <div class="flex justify-between items-center">
                <span class="text-amber-600 font-bold">From $299/night</span>
                <Button variant="outline">View Details</Button>
              </div>
            </div>
          </div>
          
          <!-- Room Card 2 -->
          <div class="bg-white rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition">
            <img src="/images/executive-suite.jpg" alt="Executive Suite" class="w-full h-64 object-cover">
            <div class="p-6">
              <h3 class="text-xl font-bold text-gray-800 mb-2">Executive Suite</h3>
              <p class="text-gray-600 mb-4">Luxurious living space with separate bedroom and lounge area</p>
              <div class="flex justify-between items-center">
                <span class="text-amber-600 font-bold">From $499/night</span>
                <Button variant="outline">View Details</Button>
              </div>
            </div>
          </div>
          
          <!-- Room Card 3 -->
          <div class="bg-white rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition">
            <img src="/images/presidential-suite.jpg" alt="Presidential Suite" class="w-full h-64 object-cover">
            <div class="p-6">
              <h3 class="text-xl font-bold text-gray-800 mb-2">Presidential Suite</h3>
              <p class="text-gray-600 mb-4">The epitome of luxury with butler service and premium amenities</p>
              <div class="flex justify-between items-center">
                <span class="text-amber-600 font-bold">From $999/night</span>
                <Button variant="outline">View Details</Button>
              </div>
            </div>
          </div>
        </div>
        
        <div class="text-center mt-12">
          <Button class="bg-amber-600 hover:bg-amber-700 text-white px-8 py-4">View All Rooms</Button>
        </div>
      </div>
    </section>


    <!-- Amenities Section -->
    <section class="py-20 bg-gray-50">
      <div class="container mx-auto px-6">
        <div class="text-center mb-16">
          <h2 class="text-3xl font-bold text-gray-800 mb-4">Hotel Amenities</h2>
          <p class="text-gray-600 max-w-2xl mx-auto">Designed to enhance your stay with comfort and convenience</p>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
          <div class="text-center p-6 bg-white rounded-lg shadow-sm hover:shadow-md transition">
            <div class="w-16 h-16 mx-auto mb-4 bg-amber-100 rounded-full flex items-center justify-center">
              <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
              </svg>
            </div>
            <h3 class="font-bold text-gray-800 mb-2">Luxury Spa</h3>
            <p class="text-gray-600 text-sm">Rejuvenating treatments in a tranquil setting</p>
          </div>
          
          <div class="text-center p-6 bg-white rounded-lg shadow-sm hover:shadow-md transition">
            <div class="w-16 h-16 mx-auto mb-4 bg-amber-100 rounded-full flex items-center justify-center">
              <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
              </svg>
            </div>
            <h3 class="font-bold text-gray-800 mb-2">24/7 Concierge</h3>
            <p class="text-gray-600 text-sm">Personalized service for all your needs</p>
          </div>
          
          <div class="text-center p-6 bg-white rounded-lg shadow-sm hover:shadow-md transition">
            <div class="w-16 h-16 mx-auto mb-4 bg-amber-100 rounded-full flex items-center justify-center">
              <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
              </svg>
            </div>
            <h3 class="font-bold text-gray-800 mb-2">Fitness Center</h3>
            <p class="text-gray-600 text-sm">State-of-the-art equipment and classes</p>
          </div>
          
          <div class="text-center p-6 bg-white rounded-lg shadow-sm hover:shadow-md transition">
            <div class="w-16 h-16 mx-auto mb-4 bg-amber-100 rounded-full flex items-center justify-center">
              <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
              </svg>
            </div>
            <h3 class="font-bold text-gray-800 mb-2">Event Spaces</h3>
            <p class="text-gray-600 text-sm">Elegant venues for meetings and weddings</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Testimonials -->
    <section class="py-20 bg-white">
      <div class="container mx-auto px-6">
        <div class="text-center mb-16">
          <h2 class="text-3xl font-bold text-gray-800 mb-4">Guest Experiences</h2>
          <p class="text-gray-600 max-w-2xl mx-auto">What our valued guests say about their stay</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
          <div class="bg-gray-50 p-8 rounded-lg">
            <div class="flex items-center mb-4">
              <div class="text-amber-500 mr-2">
                ★★★★★
              </div>
              <span class="text-gray-600">5.0</span>
            </div>
            <p class="text-gray-600 mb-6">"The Royal Crest exceeded all our expectations. The service was impeccable and the room was stunning with breathtaking city views."</p>
            <div class="flex items-center">
              <img src="/images/guest1.jpg" alt="Sarah Johnson" class="w-12 h-12 rounded-full mr-4">
              <div>
                <h4 class="font-bold text-gray-800">Sarah Johnson</h4>
                <p class="text-gray-600 text-sm">New York, USA</p>
              </div>
            </div>
          </div>
          
          <div class="bg-gray-50 p-8 rounded-lg">
            <div class="flex items-center mb-4">
              <div class="text-amber-500 mr-2">
                ★★★★★
              </div>
              <span class="text-gray-600">5.0</span>
            </div>
            <p class="text-gray-600 mb-6">"From the moment we arrived, we felt like royalty. The spa treatments were divine and the dining options were exceptional."</p>
            <div class="flex items-center">
              <img src="/images/guest2.jpg" alt="Michael Chen" class="w-12 h-12 rounded-full mr-4">
              <div>
                <h4 class="font-bold text-gray-800">Michael Chen</h4>
                <p class="text-gray-600 text-sm">London, UK</p>
              </div>
            </div>
          </div>
          
          <div class="bg-gray-50 p-8 rounded-lg">
            <div class="flex items-center mb-4">
              <div class="text-amber-500 mr-2">
                ★★★★★
              </div>
              <span class="text-gray-600">5.0</span>
            </div>
            <p class="text-gray-600 mb-6">"Perfect venue for our wedding anniversary. The staff went above and beyond to make our special occasion unforgettable."</p>
            <div class="flex items-center">
              <img src="/images/guest3.jpg" alt="Amina Al-Mansoori" class="w-12 h-12 rounded-full mr-4">
              <div>
                <h4 class="font-bold text-gray-800">Amina Al-Mansoori</h4>
                <p class="text-gray-600 text-sm">Dubai, UAE</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>


    <!-- Footer -->
    <footer class="bg-gray-900 text-white pt-16 pb-8">
      <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-12">
          <div>
            <h3 class="text-xl font-bold mb-4 flex items-center">
              The Royal Crest
            </h3>
            <p class="text-gray-400 mb-4">Providing luxury accommodations and top-tier hospitality services worldwide.</p>
            <div class="flex space-x-4">
              <a href="#" class="text-gray-400 hover:text-white">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z" />
                </svg>
              </a>
              <a href="#" class="text-gray-400 hover:text-white">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                </svg>
              </a>
              <a href="#" class="text-gray-400 hover:text-white">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" />
                </svg>
              </a>
            </div>
          </div>
          
          <div>
            <h3 class="text-lg font-bold mb-4">Quick Links</h3>
            <ul class="space-y-2">
              <li><a href="#" class="text-gray-400 hover:text-white">Home</a></li>
              <li><a href="#" class="text-gray-400 hover:text-white">Rooms & Suites</a></li>
              <li><a href="#" class="text-gray-400 hover:text-white">Gallery</a></li>
              <li><a href="#" class="text-gray-400 hover:text-white">Contact Us</a></li>
            </ul>
          </div>
          
          <div>
            <h3 class="text-lg font-bold mb-4">Contact Us</h3>
            <ul class="space-y-2 text-gray-400">
              <li class="flex items-start">
                <svg class="w-5 h-5 mr-2 mt-0.5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                123 Luxury Avenue, City Center, 10001
              </li>
              <li class="flex items-center">
                <svg class="w-5 h-5 mr-2 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                </svg>
                +1 (555) 123-4567
              </li>
              <li class="flex items-center">
                <svg class="w-5 h-5 mr-2 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                info@royalcrest.com
              </li>
            </ul>
          </div>
          
          <div>
            <h3 class="text-lg font-bold mb-4">Newsletter</h3>
            <p class="text-gray-400 mb-4">Subscribe to receive updates and special offers</p>
            <div class="flex">
              <input type="email" placeholder="Your email" class="px-4 py-2 w-full rounded-l-lg focus:outline-none text-gray-800">
              <Button class="bg-amber-600 hover:bg-amber-700 px-4 rounded-l-none rounded-r-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
              </Button>
            </div>
          </div>
        </div>
        
        <div class="border-t border-gray-800 pt-8 text-center text-gray-400">
          <p>&copy; 2025 The Royal Crest Hotel. All rights reserved. | <a href="#" class="hover:text-white">Privacy Policy</a> | <a href="#" class="hover:text-white">Terms of Service</a></p>
        </div>
      </div>
    </footer>
  </div>
</template>

<script setup>
import { Button } from '@/components/ui/button';
</script>
