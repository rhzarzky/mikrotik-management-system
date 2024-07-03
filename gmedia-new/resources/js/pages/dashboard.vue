<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import UserTable from '@/views/user/UserTable.vue';
import RouterTable from '@/views/router/RouterTable.vue';
import UserCount from '@/views/dashboard/UserCount.vue';
import RouterCount from '@/views/dashboard/RouterCount.vue';
import { useRouter } from 'vue-router'

const isAdmin = ref(false); 
const router = useRouter();

onMounted(() => {
  fetchUserData(); 
});

const fetchUserData = () => {
  axios.get('/login-user')
    .then(response => {
      const data = response.data;
      if (data.error) {
        router.push('/login');
      } else {
        isAdmin.value = data.role === 'admin';
      }
    })
    .catch(error => {
      console.error('Error fetching user info:', error);
      router.push('/login');
    });
};
</script>

<template>
  <VRow>
    <VCol cols="12" sm="6" md="4" v-if="isAdmin">
      <VCard>
        <UserCount />
      </VCard>
    </VCol>
    <VCol cols="12" sm="6" md="4">
      <VCard>
        <RouterCount />
      </VCard>
    </VCol>
    <VCol cols="12">
      <VCard title="Router List">
        <RouterTable />
      </VCard>
    </VCol>
    <VCol cols="12" v-if="isAdmin">
      <VCard title="User List">
        <UserTable />
      </VCard>
    </VCol>
  </VRow>
</template>
