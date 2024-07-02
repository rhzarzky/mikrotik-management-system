<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';
import axios from 'axios';
import { VCard, VTextField, VIcon, VDataTable, VDialog, VBtn, VSelect, VCardTitle, VCardText, VCardActions } from 'vuetify/components';
import { useRouter } from 'vue-router';

const headers = [
  { title: 'Name', key: 'name' },
  { title: 'Shared Users', key: 'shared-users' },
  { title: 'Rate Limit', key: 'rate-limit' },
  { title: 'Actions', key: 'actions', sortable: false }
];

const searchQuery = ref('');
const profileData = ref([]);
const editDialog = ref(false);
const deleteDialog = ref(false);
const currentUser = ref(null);
const router = useRouter();

async function fetchData() {
  try {
    const response = await axios.get('/user-profile-show');
    if (response.data && response.data.hotspotProfiles) {
      profileData.value = response.data.hotspotProfiles.map(profile => ({
        ...profile,
        'rate-limit': profile['rate-limit'] || 'unlimited'
      }));
      console.log('Data assigned to profileData:', profileData.value);
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

const filteredProfiles = computed(() => {
  if (!searchQuery.value) return profileData.value;
  const lowercasedQuery = searchQuery.value.toLowerCase();
  return profileData.value.filter(profile =>
    profile.name.toLowerCase().includes(lowercasedQuery) ||
    (profile['shared-users'] && profile['shared-users'].toLowerCase().includes(lowercasedQuery)) ||
    (profile['rate-limit'] && profile['rate-limit'].toLowerCase().includes(lowercasedQuery))
  );
});

const openEditDialog = (profile) => {
  currentUser.value = { ...profile };
  editDialog.value = true;
};

const openDeleteDialog = (profile) => {
  currentUser.value = profile;
  deleteDialog.value = true;
};

const updateUser = async () => {
  try {
    const rateLimitToSend = currentUser.value['rate-limit'] === 'unlimited' ? null : currentUser.value['rate-limit'];
    await axios.put(`/user-profile-update/${currentUser.value['.id']}`, {
      name: currentUser.value.name,
      'shared-users': currentUser.value['shared-users'],
      'rate-limit': rateLimitToSend
    });
    fetchData();
    editDialog.value = false;
  } catch (error) {
    console.error('Error updating profile:', error);
  }
};

const deleteUser = async () => {
  try {
    await axios.delete(`/user-profile-destroy/${currentUser.value['.id']}`);
    fetchData();
    deleteDialog.value = false;
  } catch (error) {
    console.error('Error deleting profile:', error);
  }
};
</script>

<template>
  <VCard>
    <VTextField
      v-model="searchQuery"
      label="Search Profiles"
      class="custom-input"
    >
      <template #prepend-inner>
        <VIcon icon="ri-search-line" />
      </template>
    </VTextField>
    <VDataTable
      :headers="headers"
      :items="filteredProfiles"
      item-value="id"
      class="text-no-wrap"
    >
      <template #item.name="{ item }">
        <div class="d-flex align-center gap-x-4">
          <div class="d-flex flex-column">
            <h6 class="text-h6 font-weight-medium user-list-name">{{ item.name }}</h6>
          </div>
        </div>
      </template>
      <template #item['shared-users']="{ item }">
        <div class="text-capitalize text-high-emphasis">{{ item['shared-users'] }}</div>
      </template>
      <template #item['rate-limit']="{ item }">
        <div class="text-capitalize text-high-emphasis">{{ item['rate-limit'] }}</div>
      </template>
      <template #item.actions="{ item }">
        <div class="d-flex gap-2">
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
        <VCardTitle>Edit Profile</VCardTitle>
        <VCardText>
          <VTextField v-model="currentUser.name" label="Name" class="mb-4" />
          <VTextField v-model="currentUser['shared-users']" label="Shared Users" class="mb-4" />
          <VSelect v-model="currentUser['rate-limit']" :items="['unlimited', '512k/512k', '512k/1M', '1M/1M', '2M/1M', '2M/2M', '3M/3M']" label="Rate Limit" class="mb-4" />
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
        <VCardText>Are you sure you want to delete this profile?</VCardText>
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
