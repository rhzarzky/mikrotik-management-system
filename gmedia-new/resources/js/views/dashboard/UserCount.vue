<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const userCount = ref(0);

const fetchUserCount = async () => {
  try {
    const response = await axios.get('/dashboard-stats');
    userCount.value = response.data.users;
  } catch (error) {
    console.error('Error fetching user count:', error);
  }
};

onMounted(() => {
  fetchUserCount();
});
</script>

<template>
  <VCard>
    <VCardTitle>Total Users</VCardTitle>
    <VCardText>{{ userCount }}</VCardText>
  </VCard>
</template>

<style scoped>
.dashboard-card {
  text-align: center;
  margin-bottom: 20px;
}
</style>
