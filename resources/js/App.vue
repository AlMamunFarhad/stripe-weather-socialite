<template>
  <div class="p-4 space-y-6">
    <div class="d-flex justify-content-between align-items-center bg-light p-3 rounded">
      <h1 class="text-2xl font-bold">🌍 Dashboard</h1>
      <GoogleFBGitgubLogin />
    </div>



    <!-- Map Component -->
    <WeatherComponent />
 

    <!-- Weather Component -->
    <GoogleMapComponent />

  </div>
</template>

<script setup>
import GoogleMapComponent from './components/GoogleMapComponent.vue';
import WeatherComponent from './components/WeatherComponent.vue'
import GoogleFBGitgubLogin from './components/GoogleFBGitgubLogin.vue';
</script>

<style scoped></style>