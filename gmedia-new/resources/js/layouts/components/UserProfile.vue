<script setup>
import { ref } from 'vue';
import axios from 'axios';
import avatar1 from '@images/avatars/avatar-1.png';
import { useRouter } from 'vue-router';

const logout = async () => {
  try {
    const response = await axios.post('/logout');
    if (response.data.success) {
      router.push('/login');
    } else {
      // Handle error if needed
    }
  } catch (error) {
    console.error('Error logging out:', error);
  }
};

const username = ref('');
const firstname = ref('');
const lastname = ref('');
const role = ref('');
const photo = ref('');
const router = useRouter();

axios.get('/login-user')
  .then(response => {
    const data = response.data;
    if (data.error) {
      router.push('/login');
    } else {
      role.value = data.role;
      // Check if firstname exists, otherwise use username
      firstname.value = data.user_data.firstname ?? data.username;
      lastname.value = data.user_data.lastname ?? '';
      photo.value = data.user_data.photo ? `/photo-user` : avatar1;
    }
  })
  .catch(error => {
    console.error('Error fetching user info:', error);
    router.push('/login');
  });
</script>

<template>
  <VBadge
    dot
    location="bottom right"
    offset-x="3"
    offset-y="3"
    color="success"
    bordered
  >
    <VAvatar
      class="cursor-pointer"
      color="primary"
      variant="tonal"
    >
      <VImg :src="photo" />

      <!-- SECTION Menu -->
      <VMenu
        activator="parent"
        width="230"
        location="bottom end"
        offset="14px"
      >
        <VList>
          <!-- 👉 User Avatar & Name -->
          <VListItem>
            <template #prepend>
              <VListItemAction start>
                <VBadge
                  dot
                  location="bottom right"
                  offset-x="3"
                  offset-y="3"
                  color="success"
                >
                  <VAvatar
                    color="primary"
                    variant="tonal"
                  >
                    <VImg :src="photo" />
                  </VAvatar>
                </VBadge>
              </VListItemAction>
            </template>

            <VListItemTitle class="font-weight-semibold">
              {{ firstname }} {{ lastname }}
            </VListItemTitle>
            <VListItemSubtitle>{{ role }}</VListItemSubtitle>
          </VListItem>
          <VDivider class="my-2" />

          <!-- 👉 Profile -->
          <VListItem to="/account-settings">
            <template #prepend>
              <VIcon
                class="me-2"
                icon="ri-user-settings-line"
                size="22"
              />
            </template>

            <VListItemTitle>Profile Settings</VListItemTitle>
          </VListItem>

          <!-- 👉 FAQ -->
          <VListItem link>
            <template #prepend>
              <VIcon
                class="me-2"
                icon="ri-question-line"
                size="22"
              />
            </template>

            <VListItemTitle>FAQ</VListItemTitle>
          </VListItem>

          <!-- Divider -->
          <VDivider class="my-2" />

          <!-- 👉 Logout -->
          <VListItem @click="logout">
            <template #prepend>
              <VIcon
                class="me-2"
                icon="ri-logout-box-r-line"
                size="22"
              />
            </template>

            <VListItemTitle>Logout</VListItemTitle>
          </VListItem>
        </VList>
      </VMenu>
      <!-- !SECTION -->
    </VAvatar>
  </VBadge>
</template>
