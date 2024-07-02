<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const routerCount = ref(0);

const fetchRouterCount = async () => {
  try {
    const response = await axios.get('/dashboard-stats');
    routerCount.value = response.data.routers;
  } catch (error) {
    console.error('Error fetching router count:', error);
  }
};

onMounted(() => {
  fetchRouterCount();
});
</script>

<template>
  <VCard>
    <VCardTitle>Total Routers</VCardTitle>
    <VCardText>{{ routerCount }}</VCardText>
  </VCard>
</template>

<style scoped>
.dashboard-card {
  text-align: center;
  margin-bottom: 20px;
}
</style>
