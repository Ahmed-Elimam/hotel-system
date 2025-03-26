<template>
  <div>
    <button 
      @click="startPayment" 
      class="px-4 py-2 bg-blue-500 text-white rounded">
      Pay Now
    </button>
  </div>
</template>
  
<script setup>
import axios from "axios";
import { useToast } from "vue-toastification";
const toast = useToast();
const props = defineProps({
  price: {
    type: Number,
  },
  accompany_number: {
    type: Number,
  },
  check_in: {
    type: Date,
  },
  check_out: {
    type: Date,
  },
  paid_price: {
    type: Number,
  },
  room_id: {
    type: Number,
  },
  room_creator_id: {
    type: Number,
  },

});
     
const startPayment = async () => {
  try {
    const response = await axios.post("/createCheckoutSession", {
      accompany_number: props.accompany_number,
      check_in: props.check_in,
      check_out: props.check_out,
      paid_price: props.paid_price,
      room_id: props.room_id,
      room_creator_id: props.room_creator_id,
    });
    window.location.href = response.data.checkout_url; 
  } catch (error) {
    console.error("Payment error:", error);
    toast.error("There was an error processing your payment. Please try again.");
  }
};
</script>