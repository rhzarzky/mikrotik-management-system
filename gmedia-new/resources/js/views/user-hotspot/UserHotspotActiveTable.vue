<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';
import axios from 'axios';
import { VCard, VTextField, VIcon, VDataTable, VDialog, VBtn } from 'vuetify/components';
import { useRouter } from 'vue-router';

const headers = [
  { title: 'Server', key: 'server' },
  { title: 'Username', key: 'user' },
  { title: 'Address', key: 'address' },
  { title: 'Session Time', key: 'session-time-left' },
];

const searchQuery = ref('');
const userData = ref([]);
const router = useRouter();

async function fetchData() {
  try {
    const response = await axios.get('/user-active-show');
    if (response.data && response.data.data) {
      userData.value = response.data.data;
      console.log('Data assigned to userData:', userData.value);
    } else {
      console.error('Unexpected response structure:', response.data);
    }
  } catch (error) {
    console.error('Error fetching data:', error);
    router.push('/interface');
  }
}

onMounted(() => {
  fetchData();
  const intervalId = setInterval(fetchData, 5000); // Fetch data every 5 seconds

  onUnmounted(() => {
    clearInterval(intervalId);
  });
});

const filteredUsers = computed(() => {
  if (!searchQuery.value) return userData.value;
  const lowercasedQuery = searchQuery.value.toLowerCase();
  return userData.value.filter(user =>
    user.server.toLowerCase().includes(lowercasedQuery) ||
    user.user.toLowerCase().includes(lowercasedQuery) ||
    user.address.toLowerCase().includes(lowercasedQuery) ||
    (user['session-time-left'] && user['session-time-left'].toLowerCase().includes(lowercasedQuery))
  );
});

</script>

<template>
  <VCard>
    <VTextField
      v-model="searchQuery"
      label="Search Users"
      prepend-inner-icon="mdi-magnify"
      class="custom-input"
    >
      <template #prepend-inner>
        <VIcon icon="ri-search-line" />
      </template>
    </VTextField>
    <VDataTable
      :headers="headers"
      :items="filteredUsers"
      item-value="id"
      class="text-no-wrap"
    >
      <template #item.server="{ item }">
        <div class="text-high-emphasis">{{ item.server }}</div>
      </template>
      <template #item.user="{ item }">
        <div class="text-high-emphasis">{{ item.user }}</div>
      </template>
      <template #item.address="{ item }">
        <div class="text-high-emphasis">{{ item.address }}</div>
      </template>
      <template #item['session-time-left']="{ item }">
        <div class="text-capitalize text-high-emphasis">{{ item['session-time-left'] || 'unlimited' }}</div>
      </template>
    </VDataTable>
  </VCard>
</template>

<style scoped>
.custom-input {
  max-width: 400px;
  font-size: 0.875rem;
  padding: 8px;
}
</style>
