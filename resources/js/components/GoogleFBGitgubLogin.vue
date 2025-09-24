<template>
  <div class="">
    <a :href="apiBase + '/auth/google'" class="btn btn-danger me-4">Login with Google</a>
    <a :href="apiBase + '/auth/facebook'" class="btn btn-primary me-4">Login with Facebook</a>
    <a :href="apiBase + '/auth/github'" class="btn btn-dark">Login with GitHub</a>
  </div>
</template>

<script setup>
const apiBase = "http://localhost:8000"; 
</script>
