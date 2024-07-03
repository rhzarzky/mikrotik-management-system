<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const timeItems = ['6h', '12h', '1D'];
const name = ref('');
const password = ref('');
const timeLimit = ref('6h');
const dataprofile = ref([]);
const profile = ref('default');
const showModal = ref(false);
const repeatCount = ref(1); // Ref untuk menyimpan jumlah pengulangan
const voucherFormData = ref({
  timelimit: '6h',
  disabled: false,
});

const fetchData = async () => {
  try {
    const response = await axios.get('/user-hotspot-show');
    if (response.data && response.data.data && response.data.data.profile) {
      dataprofile.value = response.data.data.profile.map(profile => ({
        id: profile['.id'],
        name: profile.name || 'Unknown',
      }));
      console.log('Profiles assigned:', dataprofile.value);
    } else {
      console.error('Unexpected response structure:', response.data);
    }
  } catch (error) {
    console.error('Error fetching data:', error);
  }
};

const store = async () => {
  try {
    if (repeatCount.value === 1) {
      // Jika repeatCount === 1, gunakan nilai input username dan password
      const response = await axios.post('/user-hotspot-store', {
        name: name.value,
        password: password.value,
        'limit-uptime': timeLimit.value,
        profile: profile.value,
      });
      console.log(`User ${name.value} successfully saved:`, response.data);
    } else {
      // Jika repeatCount > 1, buat pengguna dengan username dan password random
      for (let i = 0; i < repeatCount.value; i++) {
        const randomUsername = generateRandomString(8); // Fungsi untuk generate string random
        const randomPassword = generateRandomString(8); // Fungsi untuk generate string random
        
        const response = await axios.post('/user-hotspot-store', {
          name: randomUsername,
          password: randomPassword,
          'limit-uptime': timeLimit.value,
          profile: profile.value,
        });
        console.log(`User ${randomUsername} successfully saved:`, response.data);
      }
    }

    resetForm();
  } catch (error) {
    console.error('Error saving user:', error);
  }
};

const generateRandomString = (length) => {
  const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
  let result = '';
  for (let i = 0; i < length; i++) {
    result += characters.charAt(Math.floor(Math.random() * characters.length));
  }
  return result;
};

const resetForm = () => {
  name.value = '';
  password.value = '';
  timeLimit.value = '6h';
  profile.value = 'default';
  repeatCount.value = 1; // Reset jumlah pengulangan ke default
  voucherFormData.value.timelimit = '6h'; 
  voucherFormData.value.disabled = false; 
};

onMounted(() => {
  fetchData();
});
</script>

<template>
  <VForm @submit.prevent="store">
    <VRow>
      <!-- Username -->
      <VCol cols="12">
        <VTextField v-model="name" label="Username" />
      </VCol>
      <!-- Password -->
      <VCol cols="12">
        <VTextField v-model="password" label="Password" type="password" />
      </VCol>
      <!-- Time Limit -->
      <VCol cols="12">
        <VSelect v-model="timeLimit" :items="timeItems" label="Time Limit" />
      </VCol>
      <!-- Profile -->
      <VCol cols="12">
        <VSelect v-model="profile" :items="dataprofile.map(profile => profile.name)" label="Profile" class="mb-4" />
      </VCol>
      <!-- Jumlah Pengulangan -->
      <VCol cols="12">
        <VTextField v-model.number="repeatCount" label="Generate How Many Times?" type="number" />
      </VCol>
      <!-- Submit and Reset buttons -->
      <VCol cols="12">
        <div class="d-flex justify-end">
          <VBtn type="submit">Submit</VBtn>
          <VBtn type="reset" color="secondary" outlined class="ml-4" @click="resetForm">Reset</VBtn>
        </div>
      </VCol>
    </VRow>
  </VForm>
</template>

<style scoped>
.custom-input {
  max-width: 400px;
  font-size: 0.875rem;
  padding: 8px;
}
</style>
