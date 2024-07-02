<script setup>
import { useRoute } from 'vue-router'
import UserSettingsAccount from '@/views/user/UserSettingAccount.vue'
import UserSettingsSecurity from '@/views/user/UserSettingSecurity.vue'

const route = useRoute()
const activeTab = ref(route.params.tab || 'account')

// tabs
const tabs = [
  {
    title: 'Account',
    icon: 'ri-group-line',
    tab: 'account',
  },
  {
    title: 'Security',
    icon: 'ri-lock-line',
    tab: 'security',
  },
]
</script>

<template>
  <div>
    <VTabs
      v-model="activeTab"
      show-arrows
    >
      <VTab
        v-for="item in tabs"
        :key="item.icon"
        :value="item.tab"
      >
        <VIcon
          size="20"
          start
          :icon="item.icon"
        />
        {{ item.title }}
      </VTab>
    </VTabs>

    <VWindow
      v-model="activeTab"
      class="mt-5 disable-tab-transition"
      :touch="false"
    >
      <!-- Account -->
      <VWindowItem value="account">
        <UserSettingsAccount />
      </VWindowItem>

      <!-- Security -->
      <VWindowItem value="security">
        <UserSettingsSecurity />
      </VWindowItem>
    </VWindow>
  </div>
</template>
