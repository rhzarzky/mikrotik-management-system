<script setup>
import { ref } from 'vue';
import axios from 'axios';

const Username = ref('');
const email = ref('');
const password = ref('');
const role = ref('user'); // Default role

const store = async () => {
  try {
    const response = await axios.post('/user-store', {
      username: Username.value,
      email: email.value,
      password: password.value,
      role: role.value
    });
    console.log('User successfully saved:', response.data);
    // Tambahkan data baru ke dalam userData setelah berhasil disimpan
    resetForm();
  } catch (error) {
    console.error('Error saving user:', error);
    // Handle error scenario, show error message to user if necessary
  }
};

const resetForm = () => {
  Username.value = '';
  email.value = '';
  password.value = '';
  role.value = 'user';
};
</script>

<template>
  <VForm @submit.prevent="store">
    <VRow>
      <!-- User Name -->
      <VCol cols="12" md="6">
        <VTextField v-model="Username" label="Username" />
      </VCol>
      <!-- Email -->
      <VCol cols="12" md="6">
        <VTextField v-model="email" label="Email" />
      </VCol>
      <!-- Password -->
      <VCol cols="12" md="6">
        <VTextField v-model="password" label="Password" type="password" />
      </VCol>
      <!-- Role -->
      <VCol cols="12" md="6">
        <VSelect v-model="role" :items="['user', 'admin']" label="Role" />
      </VCol>
      <!-- Submit and Reset buttons -->
      <VCol cols="12">
        <div class="d-flex justify-end">
          <VBtn type="submit">Submit</VBtn>
          <VBtn type="reset" color="secondary" outlined class="ml-4">Reset</VBtn>
        </div>
      </VCol>
    </VRow>
  </VForm>
</template>
