<script setup lang="ts">
import { Head, usePage } from "@inertiajs/vue3";
import { defineAsyncComponent, ref, computed } from "vue";
import { Chart as ChartJS, ArcElement, Tooltip, Legend, CategoryScale, LinearScale, PointElement, LineElement, Title } from "chart.js";
import { Pie, Line } from "vue-chartjs";

ChartJS.register(
  ArcElement,
  Tooltip,
  Legend,
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
  Title
);


const props = defineProps({
  reservations: {
    type: Array,
    default: () => []
  },
  reservationsByCountries: {
    type: Array,
    default: () => []
  }
});

const page = usePage();
const user = computed(() => page.props?.user ?? { roles: [] });
const userRoles = computed(() => user.value.roles?.map(role => role.name) ?? []);

const genderData = computed(() => {
  const counts = props.reservations.reduce((acc, reservation) => {
    const gender = reservation.client?.gender;
    if (gender === 'male' || gender === 'female') {
      acc[gender] = (acc[gender] || 0) + 1;
    }
    return acc;
  }, {});

  return {
    male: counts.male || 0,
    female: counts.female || 0
  };
});

const countryData = computed(() => {
  const countryCounts = props.reservationsByCountries.reduce((acc, reservation) => {
    const countryName = reservation.client?.country?.name || 'Unknown';
    acc[countryName] = (acc[countryName] || 0) + 1;
    return acc;
  }, {});

  const labels = Object.keys(countryCounts);
  const data = Object.values(countryCounts);

  const backgroundColors = [
    '#000000',
    '#777676',
    '#D3D3D3', '#C0C0C0', '#A9A9A9', '#808080', '#696969', '#303030'
  ].slice(0, labels.length);

  return {
    labels: labels,
    datasets: [{
      data: data,
      backgroundColor: backgroundColors,
      borderWidth: 1
    }]
  };
});

const TopClientReservation = computed(() => {
  const clientCounter = props.reservations.reduce((acc, reservation) => {
    const clientName = reservation.client?.name || 'Unknown';
    acc[clientName] = (acc[clientName] || 0) + 1;
    return acc;
  }, {});

  const sortedClients = Object.entries(clientCounter)
    .sort((a, b) => b[1] - a[1])
    .slice(0, 10);

  const labels = sortedClients.map(([name]) => name);
  const data = sortedClients.map(([_, count]) => count);

  const backgroundColors = [
    '#000000', '#777676', '#D3D3D3', '#C0C0C0',
    '#A9A9A9', '#808080', '#FFFFFF', '#696969',
    '#303030', '#505050'
  ].slice(0, labels.length);

  return {
    labels: labels,
    datasets: [{
      data: data,
      backgroundColor: backgroundColors,
      borderWidth: 1
    }]
  };
});

const totalReservations = computed(() => props.reservations.length);

const AppLayout = defineAsyncComponent(() => {
  if (userRoles.value.includes("admin")) {
    return import("@/layouts/customisedLayout/AppLayoutAdmin.vue");
  }
  if (userRoles.value.includes("manager")) {
    return import("@/layouts/customisedLayout/AppLayoutManager.vue");
  }
  if (userRoles.value.includes("receptionist")) {
    return import("@/layouts/customisedLayout/AppLayoutReceptionist.vue");
  }
  return import("@/layouts/customisedLayout/AppLayoutClient.vue");
});

const breadcrumbs = [
  {
    title: "Home Page",
  },
];

const userData = computed(() => ({
  labels: ['Male', 'Female'],
  datasets: [{
    data: [genderData.value.male, genderData.value.female],
    backgroundColor: [
      '#000000',
      '#777676'
    ],
    borderWidth: 1
  }]
}));

const chartOptions = ref({
  responsive: true,
  plugins: {
    legend: {
      position: "bottom",
    },
  },
});

const totalUsers = computed(() => {
  return genderData.value.male + genderData.value.female;
});

const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

const lineChartData = computed(() => {

  const monthlyData = props.reservations.reduce((acc, reservation) => {
    const date = new Date(reservation.created_at);
    const month = date.getMonth();
    acc[month] = (acc[month] || 0) + 1;
    return acc;
  }, Array(12).fill(0));

  return {
    labels: months,
    datasets: [
      {
        label: 'Reservations',
        data: monthlyData,
        borderColor: '#000000',
        backgroundColor: 'rgba(0, 0, 0, 0.1)',

      }
    ]
  };
});

const lineChartOptions = ref({

  maintainAspectRatio: false,
  plugins: {
    legend: {
      display: false
    },
    tooltip: {
      mode: 'index',
      intersect: false
    }
  },

});
</script>
<template>
    <Head title="Dashboard" />
    <AppLayout :breadcrumbs="breadcrumbs">
      <div class="p-4 w-full">
        <div class="grid grid-cols-2 gap-4 w-full max-w-7xl mx-auto">
          <!-- Reservation (Male vs Female) Card -->
          <div class="bg-white dark:bg-gray-900 p-4 rounded-lg shadow-sm flex flex-col items-center justify-between">
            <h2 class="text-lg font-semibold text-center text-gray-800 dark:text-white mb-3">
              Reservation (Male vs Female)
            </h2>
            <div class="w-full max-w-xs aspect-square flex items-center justify-center">
              <Pie :data="userData" :options="chartOptions" />
            </div>
            <p class="text-center text-gray-700 dark:text-gray-300 mt-3">
              Total: {{ totalUsers }}
            </p>
          </div>


          <div class="bg-white dark:bg-gray-900 p-4 rounded-lg shadow-sm flex flex-col items-center justify-between">
            <h2 class="text-lg font-semibold text-center text-gray-800 dark:text-white mb-3">
              Reservations by Country
            </h2>
            <div class="w-full max-w-xs aspect-square flex items-center justify-center">
              <Pie :data="countryData" :options="chartOptions" />
            </div>
            <p class="text-center text-gray-700 dark:text-gray-300 mt-3">
              Total Countries: {{ countryData.labels?.length }}
            </p>
          </div>

          <div class="bg-white dark:bg-gray-900 p-4 rounded-lg shadow-sm flex flex-col items-center justify-between">
            <h2 class="text-lg font-semibold text-center text-gray-800 dark:text-white mb-3">
              Top Reservations Clients
            </h2>
            <div class="w-full max-w-xs aspect-square flex items-center justify-center">
              <Pie :data="TopClientReservation" :options="chartOptions" />
            </div>
            <p class="text-center text-gray-700 dark:text-gray-300 mt-3">
              Total: {{ totalReservations }}
            </p>
          </div>

          <div class="bg-white dark:bg-gray-900 p-4 rounded-lg shadow-sm flex flex-col">
            <h2 class="text-lg font-semibold text-center text-gray-800 dark:text-white mb-3">
              Monthly Reservations Trend
            </h2>
            <div class="w-full flex-grow">
              <Line
                :data="lineChartData"
                :options="lineChartOptions"
                class="h-full min-h-[250px]"
              />
            </div>
            <div class="flex justify-between items-center mt-4">
              <p class="text-sm text-gray-600 dark:text-gray-400 hidden sm:block">
                Showing monthly reservation trends
              </p>
              <div class="flex items-center text-sm text-green-600 dark:text-green-400">
                <span>Trending up</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd" />
                </svg>
              </div>
            </div>
          </div>
        </div>
      </div>
    </AppLayout>
  </template>
