<template>
  <div>
    <h2 class="mb-3">📍 My Google Map</h2>
    <div ref="mapContainer" style="height: 500px; width: 100%;"></div>
  </div>
</template>

<script setup>
import { onMounted, ref } from 'vue'

const mapContainer = ref(null)

onMounted(() => {
  // Replace YOUR_API_KEY with your real key
  const script = document.createElement('script')
script.src = `https://maps.googleapis.com/maps/api/js?key=Your_api_key_here&callback=initMap`
  script.async = true
  window.initMap = () => {
    const map = new google.maps.Map(mapContainer.value, {
      center: { lat: 23.8103, lng: 90.4125 }, // Dhaka
      zoom: 12,
    })

    const marker = new google.maps.Marker({
      position: { lat: 23.8103, lng: 90.4125 },
      map: map,
      title: 'Dhaka',
    })
  }
  document.head.appendChild(script)
})
</script>
