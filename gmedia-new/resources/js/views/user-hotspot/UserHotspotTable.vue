<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';
import { VCard, VTextField, VIcon, VBtn, VDataTable, VDialog, VSelect, VChip } from 'vuetify/components';

const headers = [
  { title: 'Username', value: 'name' },
  { title: 'Password', value: 'password' },
  { title: 'Profile', value: 'profile' },
  { title: 'Uptime', value: 'uptime' },
  { title: 'Time Limit', value: 'limit-uptime' },
  { title: 'Status', value: 'disabled' },
  { title: 'Actions', value: 'actions', sortable: false }
];

const searchQuery = ref('');
const userData = ref([]);
const editDialog = ref(false);
const deleteDialog = ref(false);
const currentUser = ref(null);
const profiles = ref([]);
const router = useRouter();

const fetchData = async () => {
  try {
    const response = await axios.get('/user-hotspot-show');
    if (response.data && response.data.data) {
      userData.value = response.data.data.hotspotuser.map(user => ({
        id: user['.id'],
        name: user.name || user.username || 'unknown',
        password: user.password || user.password || 'unknown', 
        profile: user.profile || 'unknown',
        uptime: user.uptime || '0s',
        'limit-uptime': user['limit-uptime'] || 'Not Set',
        disabled: user.disabled === 'true' ? true : false,
      }));

      profiles.value = response.data.data.profile.map(profile => ({
        id: profile['.id'],
        name: profile.name || 'Unknown',
      }));

      console.log('Data assigned to userData:', userData.value);
      console.log('Profiles assigned:', profiles.value);
    } else {
      console.error('Unexpected response structure:', response.data);
    }
  } catch (error) {
    console.error('Error fetching data:', error);
    router.push('/interface');
  }
};

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
    user.name.toLowerCase().includes(lowercasedQuery) ||
    user.password.toLowerCase().includes(lowercasedQuery) ||
    user.profile.toLowerCase().includes(lowercasedQuery) ||
    user.uptime.toLowerCase().includes(lowercasedQuery) ||
    (user['limit-uptime'] && user['limit-uptime'].toLowerCase().includes(lowercasedQuery)) ||
    (user.disabled ? 'inactive' : 'active').toString().includes(lowercasedQuery)  );
});

const resolveUserStatusVariant = disabled => {
  const disabledLowerCase = disabled.toString().toLowerCase();
  if (disabledLowerCase === 'false')
    return 'success';
  if (disabledLowerCase === 'true')
    return 'error';
  
  return 'primary';
};

const openEditDialog = (user) => {
  currentUser.value = { ...user };
  editDialog.value = true;
};

const openDeleteDialog = (user) => {
  currentUser.value = user;
  deleteDialog.value = true;
};

const updateUser = async () => {
  try {
    await axios.put(`/user-hotspot-update/${currentUser.value.id}`, {
      name: currentUser.value.name,
      password: currentUser.value.password,
      profile: currentUser.value.profile,
      'limit-uptime': currentUser.value['limit-uptime'],
    });
    fetchData();
    editDialog.value = false;
  } catch (error) {
    console.error('Error updating user:', error);
  }
};

const deleteUser = async () => {
  try {
    await axios.delete(`/user-hotspot-destroy/${currentUser.value.id}`);
    fetchData();
    deleteDialog.value = false;
  } catch (error) {
    console.error('Error deleting user:', error);
  }
};

const activation = async (user) => {
  try {
    await axios.put(`/user-activation/${user.id}`, {
      disabled: user.disabled ? 'false' : 'true',
    });
    fetchData();
  } catch (error) {
    console.error('Error activation user status:', error);
  }
};
</script>

<template>
  <VCard>
    <VTextField
      v-model="searchQuery"
      label="Search Users"
      class="custom-input"
    >
      <template #prepend-inner>
        <VIcon icon="ri-search-line" />
      </template>
    </VTextField>
    <VDataTable
      :headers="headers"
      :items="filteredUsers"
      item-key="id"
      class="text-no-wrap"
    >
      <template #item.name="{ item }">
        <div class="text-high-emphasis">{{ item.name }}</div>
      </template>
      <template #item.password="{ item }">
        <div class="text-high-emphasis">{{ item.password }}</div>
      </template>
      <template #item.profile="{ item }">
        <div class="text-high-emphasis">{{ item.profile }}</div>
      </template>
      <template #item.uptime="{ item }">
        <div class="text-high-emphasis">{{ item.uptime }}</div>
      </template>
      <template #item['limit-uptime']="{ item }">
        <div class="text-high-emphasis">{{ item['limit-uptime'] }}</div>
      </template>
      <template #item.disabled="{ item }">
        <VChip :color="resolveUserStatusVariant(item.disabled)">
          {{ item.disabled ? 'inactive' : 'active' }}
        </VChip>
      </template>
      <template #item.actions="{ item }">
        <div class="d-flex gap-2">
          <VBtn color="secondary" icon @click="activation(item)">
            <VIcon :icon="item.disabled ? 'ri-close-line' : 'ri-check-line'" />
          </VBtn>
          <VBtn icon @click="openEditDialog(item)">
            <VIcon icon="ri-edit-box-line" />
          </VBtn>
          <VBtn color="error" icon @click="openDeleteDialog(item)">
            <VIcon icon="ri-delete-bin-line" />
          </VBtn>
        </div>
      </template>
    </VDataTable>

    <!-- Edit Dialog -->
    <VDialog v-model="editDialog" max-width="400">
      <VCard>
        <VCardTitle>Edit User</VCardTitle>
        <VCardText>
          <VTextField v-model="currentUser.name" label="Username" class="mb-4" />
          <VTextField v-model="currentUser.password" label="Password" class="mb-4" />
          <VSelect v-model="currentUser.profile" :items="profiles.map(profile => profile.name)" label="Profile" class="mb-4" />
          <VTextField v-model="currentUser['limit-uptime']" label="Time Limit" class="mb-4" />
        </VCardText>
        <VCardActions>
          <VBtn color="primary" @click="updateUser">Save</VBtn>
          <VBtn @click="editDialog = false">Cancel</VBtn>
        </VCardActions>
      </VCard>
    </VDialog>

    <!-- Delete Dialog -->
    <VDialog v-model="deleteDialog" max-width="500">
      <VCard>
        <VCardTitle>Confirm Delete</VCardTitle>
        <VCardText>Are you sure you want to delete this user?</VCardText>
        <VCardActions>
          <VBtn color="red" @click="deleteUser">Delete</VBtn>
          <VBtn @click="deleteDialog = false">Cancel</VBtn>
        </VCardActions>
      </VCard>
    </VDialog>
  </VCard>
</template>

<style scoped>
.custom-input {
  max-width: 400px;
  font-size: 0.875rem;
  padding: 8px;
}
</style>
