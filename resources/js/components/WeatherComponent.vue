<template>
  <div class="container mt-5 mb-5" style="max-width: 500px;">
    <h1 class="h4 fw-bold mb-4 text-center">🌤️ Weather (OpenWeather + Laravel)</h1>

    <div class="input-group mb-3">
      <input v-model="city" type="text" class="form-control" placeholder="City e.g. Dhaka">
      
      <select v-model="units" class="form-select" style="max-width: 80px;">
        <option value="metric">°C</option>
        <option value="imperial">°F</option>
        <option value="standard">K</option>
      </select>

      <button @click="load" class="btn btn-dark">Go</button>
    </div>

    <div v-if="loading" class="text-center">Loading...</div>
    <div v-if="error" class="text-danger">Error: {{ error }}</div>

    <div v-if="weather" class="card p-3 mt-3">
      <div class="h6 fw-semibold">{{ weather.city }}, {{ weather.country }}</div>
      <div class="display-1 fw-bold">{{ weather.temp }}°</div>
      <div class="text-secondary">{{ weather.description }}</div>
      <div class="small mt-2">
        Feels like: {{ weather.feels_like }}°, 
        Humidity: {{ weather.humidity }}%, 
        Wind: {{ weather.wind }}
      </div>
      <img v-if="weather.icon" 
           :alt="weather.description" 
           :src="'https://openweathermap.org/img/wn/' + weather.icon + '@2x.png'" 
           class="mt-2 img-fluid" 
           style="max-width: 100px;">
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'

const city = ref('Dhaka')
const units = ref('metric')
const loading = ref(false)
const error = ref('')
const weather = ref(null)

const load = async () => {
  loading.value = true
  error.value = ''
  weather.value = null
  try {
    const res = await fetch(`/api/weather?city=${encodeURIComponent(city.value)}&units=${units.value}&lang=bn`)
    if (!res.ok) throw new Error(`HTTP ${res.status}`)
    weather.value = await res.json()
  } catch (e) {
    error.value = e.message || 'Failed'
  } finally {
    loading.value = false
  }
}

onMounted(load)
</script>
