<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const timeItems = [
   '6h' ,
   '12h',
   '1D'
];

const name = ref('');
const password = ref('');
const timeLimit = ref('6h');
const dataprofile = ref([]);
const profile = ref('default');

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
    const response = await axios.post('/user-hotspot-store', {
      name: name.value,
      password: password.value,
      'limit-uptime': timeLimit.value,
      profile: profile.value
    });
    console.log('User successfully saved:', response.data);
    resetForm();
  } catch (error) {
    console.error('Error saving user:', error);
  }
};

const resetForm = () => {
  name.value = '';
  password.value = '';
  timeLimit.value = '6h';
  profile.value = 'default';
};

onMounted(() => {
  fetchData();
  store();
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
