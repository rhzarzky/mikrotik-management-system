<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';
import axios from 'axios';
import { VCard, VTextField, VIcon, VAvatar, VImg, VDataTable, VDialog, VBtn } from 'vuetify/components';
import { useRouter } from 'vue-router'

const headers = [
  { title: 'User', key: 'username' },
  { title: 'Email', key: 'email' },
  { title: 'Role', key: 'role' },
  { title: 'Actions', key: 'actions', sortable: false }
];

const searchQuery = ref('');
const userData = ref([]);
const editDialog = ref(false);
const deleteDialog = ref(false);
const currentUser = ref(null);
const router = useRouter();
const role = ref('');

const fetchUserInfo = () => {
  axios.get('/login-user')
    .then(response => {
      const data = response.data;
      if (data.error) {
        router.push('/login');
      } else {
        role.value = data.role;
        if (role.value !== 'admin') {
          router.push('/dashboard');
        }
      }
    })
    .catch(error => {
      console.error('Error fetching user info:', error);
      router.push('/login');
    });
};

async function fetchData() {
  try {
    const response = await axios.get('/user-show');
    if (response.data && response.data.data) {
      userData.value = response.data.data;
      console.log('Data assigned to userData:', userData.value);
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
  fetchUserInfo();
  const intervalId = setInterval(fetchData, 5000); // Fetch data every 1 seconds

  onUnmounted(() => {
    clearInterval(intervalId);
  });
});

const filteredUsers = computed(() => {
  if (!searchQuery.value) return userData.value;
  const lowercasedQuery = searchQuery.value.toLowerCase();
  return userData.value.filter(user =>
    user.email.toLowerCase().includes(lowercasedQuery) ||
    user.role.toLowerCase().includes(lowercasedQuery) ||
    user.username.toLowerCase().includes(lowercasedQuery)
  );
});

const resolveUserRoleVariant = role => {
  const roleLowerCase = role.toLowerCase();
  if (roleLowerCase === 'user') return { color: 'success', icon: 'ri-user-line' };
  if (roleLowerCase === 'admin') return { color: 'primary', icon: 'ri-vip-crown-line' };
  return { color: 'success', icon: 'ri-user-line' };
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
    await axios.put(`/user-update/${currentUser.value.id}`, {
      email: currentUser.value.email,
      username: currentUser.value.username,
      role: currentUser.value.role
    });
    fetchData();
    editDialog.value = false;
  } catch (error) {
    console.error('Error updating user:', error);
  }
};

const deleteUser = async () => {
  try {
    await axios.delete(`/user-destroy/${currentUser.value.id}`);
    fetchData();
    deleteDialog.value = false;
  } catch (error) {
    console.error('Error deleting user:', error);
  }
};
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
      <template #item.username="{ item }">
        <div class="d-flex align-center gap-x-4">
          <VAvatar
            size="34"
            :variant="!item.userData || !item.userData.photo ? 'tonal' : undefined"
            :color="!item.userData || !item.userData.photo ? resolveUserRoleVariant(item.role).color : undefined"
          >
            <VImg v-if="item.userData && item.userData.photo" :src="item.userData.photo" />
          </VAvatar>
          <div class="d-flex flex-column">
            <h6 class="text-h6 font-weight-medium user-list-name">{{ item.userData ? `${item.userData.firstname} ${item.userData.lastname}` : item.username }}</h6>
            <span class="text-sm text-medium-emphasis">@{{ item.username }}</span>
          </div>
        </div>
      </template>
      <template #item.role="{ item }">
        <div class="d-flex gap-4">
          <VIcon :icon="resolveUserRoleVariant(item.role).icon" :color="resolveUserRoleVariant(item.role).color" size="22" />
          <div class="text-capitalize text-high-emphasis">{{ item.role }}</div>
        </div>
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
        <VCardTitle>Edit User</VCardTitle>
        <VCardText>
          <VTextField v-model="currentUser.email" label="Email" class="mb-4" />
          <VTextField v-model="currentUser.username" label="Username" class="mb-4" />
          <VSelect v-model="currentUser.role" :items="['user', 'admin']" label="Role" class="mb-4" />
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
