<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';
import axios from 'axios';
import {  VCard,  VTextField,  VIcon,  VDataTable,  VBtn,  VDialog,  VCardTitle,  VCardText,  VCardActions,} from 'vuetify/components';
import { useRouter } from 'vue-router'

const headers = [
  { title: 'Address', key: 'address' },
  { title: 'Username', key: 'username' },
  { title: 'Router Name', key: 'routername' },
  { title: 'Actions', key: 'actions', sortable: false },
];

const searchQuery = ref('');
const routerData = ref([]);
const editDialog = ref(false);
const deleteDialog = ref(false);
const currentRouter = ref(null);
const router = useRouter();

async function fetchData() {
  try {
    const response = await axios.get('/router-show');
    if (response.data && response.data.data) {
      routerData.value = response.data.data;
      console.log('Data assigned to routerData:', routerData.value);
    } else {
      console.error('Unexpected response structure:', response.data);
    }
  } catch (error) {
    console.error('Error fetching data:', error);
    router.push('/login');
  }
}

onMounted(() => {
  fetchData();
  const intervalId = setInterval(fetchData, 5000);  // Fetch data every 1 seconds

  onUnmounted(() => {
    clearInterval(intervalId);
  });
});

const filteredRouters = computed(() => {
  if (!searchQuery.value) return routerData.value;
  const lowercasedQuery = searchQuery.value.toLowerCase();
  return routerData.value.filter(router =>
    router.address.toLowerCase().includes(lowercasedQuery) ||
    router.username.toLowerCase().includes(lowercasedQuery) ||
    router.routername.toLowerCase().includes(lowercasedQuery)
  );
});

const openEditDialog = (router) => {
  currentRouter.value = { ...router };
  editDialog.value = true;
};

const openDeleteDialog = (router) => {
  currentRouter.value = router;
  deleteDialog.value = true;
};

const updateRouter = async () => {
  try {
    await axios.put(`/router-update/${currentRouter.value.id}`, {
      address: currentRouter.value.address,
      username: currentRouter.value.username,
      routername: currentRouter.value.routername
    });
    fetchData();
    editDialog.value = false;
  } catch (error) {
    console.error('Error updating router:', error);
  }
};

const deleteRouter = async () => {
  try {
    await axios.delete(`/router-destroy/${currentRouter.value.id}`);
    fetchData();
    deleteDialog.value = false;
  } catch (error) {
    console.error('Error deleting router:', error);
  }
};

const loginRouter = async (router) => {
  try {
    const response = await axios.post('/login-router', {
      address: router.address,
      username: router.username,
      password: router.password,
    });
    if (response.data.success) {
      console.log('Login successful');
      window.location.href = '/interface'
    } else {
    //   console.error('Login failed:', response.data.error);
    }
  } catch (error) {
    console.error('Error logging in router:', error);
    router.push('/login');
  }
};
</script>

<template>
    <VCard>
      <VTextField
        v-model="searchQuery"
        label="Search Routers"
        prepend-inner-icon="mdi-magnify"
        class="custom-input"
      >
        <template #prepend-inner>
          <VIcon icon="ri-search-line" />
        </template>
      </VTextField>
      <VDataTable
        :headers="headers"
        :items="filteredRouters"
        item-key="id"
        class="text-no-wrap"
      >
        <template #item.address="{ item }">
          {{ item.address }}
        </template>
        <template #item.username="{ item }">
          {{ item.username }}
        </template>
        <template #item.routername="{ item }">
          {{ item.routername }}
        </template>
        <template #item.actions="{ item }">
          <div class="d-flex gap-2">
            <VBtn color="success" icon @click="loginRouter(item)">
              <VIcon icon="ri-login-box-line" />
            </VBtn>
            <VBtn  icon @click="openEditDialog(item)">
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
          <VCardTitle>Edit Router</VCardTitle>
          <VCardText>
            <VTextField v-model="currentRouter.address" label="Address" class="mb-4" />
            <VTextField v-model="currentRouter.username" label="Username" class="mb-4" />
            <VTextField v-model="currentRouter.routername" label="Router Name" class="mb-4" />
          </VCardText>
          <VCardActions>
            <VBtn color="primary" @click="updateRouter">Save</VBtn>
            <VBtn @click="editDialog = false">Cancel</VBtn>
          </VCardActions>
        </VCard>
      </VDialog>
  
      <!-- Delete Dialog -->
      <VDialog v-model="deleteDialog" max-width="500">
        <VCard>
          <VCardTitle>Confirm Delete</VCardTitle>
          <VCardText>Are you sure you want to delete this router?</VCardText>
          <VCardActions>
            <VBtn color="red" @click="deleteRouter">Delete</VBtn>
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
  