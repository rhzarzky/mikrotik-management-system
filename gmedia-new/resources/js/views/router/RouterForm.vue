<script setup>
import { ref } from 'vue';
import axios from 'axios';

const address = ref('');
const username = ref('');
const password = ref('');
const routername = ref('');

const store = async () => {
  try {
    const response = await axios.post('/router-store', {
      address: address.value,
      username: username.value,
      password: password.value,
      routername: routername.value,
    });
    console.log('Router successfully saved:', response.data);
    resetForm();
  } catch (error) {
    console.error('Error saving router:', error);
  }
};

const resetForm = () => {
  address.value = '';
  username.value = '';
  password.value = '';
  routername.value = '';
};
</script>

<template>
  <VForm @submit.prevent="store">
    <VRow>
      <VCol cols="12" md="6">
        <VTextField v-model="address" label="IP Address" />
      </VCol>
      <VCol cols="12" md="6">
        <VTextField v-model="username" label="Username" />
      </VCol>
      <VCol cols="12" md="6">
        <VTextField v-model="password" label="Password" type="password" />
      </VCol>
      <VCol cols="12" md="6">
        <VTextField v-model="routername" label="Router Name" />
      </VCol>
      <VCol cols="12">
        <div class="d-flex justify-end">
          <VBtn type="submit">Submit</VBtn>
          <VBtn type="reset" color="secondary" outlined class="ml-4">Reset</VBtn>
        </div>
      </VCol>
    </VRow>
  </VForm>
</template>
