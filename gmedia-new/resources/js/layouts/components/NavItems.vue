<script setup>
import VerticalNavSectionTitle from '@/@layouts/components/VerticalNavSectionTitle.vue';
import VerticalNavGroup from '@layouts/components/VerticalNavGroup.vue';
import VerticalNavLink from '@layouts/components/VerticalNavLink.vue';
import axios from 'axios';
import { ref, onMounted, onUnmounted } from 'vue';
import { useRouter } from 'vue-router';

const role = ref('');
const address = ref('');
const router = useRouter();
let intervalId;

const fetchUserInfo = () => {
  axios.get('/login-user')
    .then(response => {
      const data = response.data;
      if (data.error) {
        router.push('/login');
      } else {
        role.value = data.role;
      }
    })
    .catch(error => {
      console.error('Error fetching user info:', error);
      router.push('/login');
    });
};

const fetchRouterInfo = () => {
  axios.get('/login-router')
    .then(response => {
      const data = response.data;
      if (!data.error) {
        address.value = data.address;
      }
    })
    .catch(error => {
      console.error('Error fetching router info:', error);
    });
};

const logoutRouter = () => {
  axios.post('/logout-router')
    .then(response => {
      if (response.data.success) {
        router.push('/dashboard');
      } else {
        console.error('Failed to logout router');
      }
    })
    .catch(error => {
      console.error('Error logging out router:', error);
    });
};

onMounted(() => {
  fetchUserInfo();
  intervalId = setInterval(fetchRouterInfo, 10000);
});

onUnmounted(() => {
  clearInterval(intervalId);
});
</script>

<template>
  <!-- 👉 Dashboards -->
  <VerticalNavLink
    v-if="!address"
    :item="{
      title: 'Dashboards',
      icon: 'ri-home-smile-line',
      to: '/dashboard',
    }"
  />

  <!-- 👉 Apps & Pages -->
  <VerticalNavSectionTitle
    :item="{
      heading: 'Apps & Pages',
    }"
  />

  <!-- 👉 Users -->
  <VerticalNavLink
    v-if="role === 'admin' && !address"
    :item="{
      title: 'Users',
      icon: 'ri-user-line',
      to: '/user',
    }"
  />

  <!-- 👉 Router -->
  <VerticalNavLink
    v-if="!address"
    :item="{
      title: 'Router',
      icon: 'ri-router-line',
      to: '/router',
    }"
  />

  <!-- 👉 Interface -->
  <VerticalNavLink
    v-if="address"
    :item="{
      title: 'Interface',
      icon: 'ri-stack-line',
      to: '/interface',
    }"
  />

  <!-- 👉 Hotspot -->
  <VerticalNavGroup
    v-if="address"
    :item="{
      title: 'Hotspot',
      icon: 'ri-hotspot-line',
    }"
  >
    <!-- 👉 User Hotspot -->
    <VerticalNavLink
      :item="{
        title: 'User Hotspot',
        to: '/user-hotspot',
      }"
    />

    <!-- 👉 User Profile -->
    <VerticalNavLink
      :item="{
        title: 'User Profile',
        to: '/user-profile',
      }"
    />
  </VerticalNavGroup>

  <!-- 👉 Custom Login -->
  <VerticalNavLink
    v-if="address"
    :item="{
      title: 'Custom Login',
      icon: 'ri-file-edit-line',
      to: '/custom-login',
    }"
  />

  <VerticalNavLink
    v-if="address"
    :item="{
      title: 'Go Back',
      icon: 'ri-reply-line',
    }"
    @click.native="logoutRouter"
  />
</template>
