<script setup>
import { ref } from 'vue';
import axios from 'axios';

const name = ref('');
const sharedUsers = ref('unlimited');
const rateLimit = ref('unlimited');

const rateLimitOptions = [
  'unlimited',
  '512k/512k',
  '512k/1M',
  '1M/1M',
  '2M/1M',
  '2M/2M',
  '3M/3M'
];

const store = async () => {
  try {
    const response = await axios.post('/user-profile-store', {
      name: name.value,
      'shared-users': sharedUsers.value,
      'rate-limit': rateLimit.value
    });
    console.log('Profile successfully saved:', response.data);
    // Reset the form after successful save
    resetForm();
  } catch (error) {
    console.error('Error saving profile:', error);
    // Handle error scenario, show error message to user if necessary
  }
};

const resetForm = () => {
  name.value = '';
  sharedUsers.value = '';
  rateLimit.value = 'unlimited';
};
</script>

<template>
  <v-form @submit.prevent="store">
    <v-row>
      <!-- Name -->
      <v-col cols="12" md="6">
        <v-text-field v-model="name" label="Name" />
      </v-col>
      <!-- Shared Users -->
      <v-col cols="12" md="6">
        <v-text-field v-model="sharedUsers" label="Shared Users" />
      </v-col>
      <!-- Rate Limit -->
      <v-col cols="12" md="6">
        <v-select
          v-model="rateLimit"
          :items="rateLimitOptions"
          label="Rate Limit"
        />
      </v-col>
      <!-- Submit and Reset buttons -->
      <v-col cols="12">
        <div class="d-flex justify-end">
          <v-btn type="submit" color="primary">Submit</v-btn>
          <v-btn type="reset" color="secondary" outlined class="ml-4" @click="resetForm">Reset</v-btn>
        </div>
      </v-col>
    </v-row>
  </v-form>
</template>

<style scoped>
/* Add any custom styles if necessary */
</style>
