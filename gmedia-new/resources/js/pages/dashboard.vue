<script setup>
import UserTable from '@/views/user/UserTable.vue'
import RouterTable from '@/views/router/RouterTable.vue'
import UserCount from '@/views/dashboard/UserCount.vue'
import RouterCount from '@/views/dashboard/RouterCount.vue'
</script>

<template>
  <VRow>

    <VCol cols="12" sm="6" md="4">
      <VCard>
        <UserCount />
      </VCard>
    </VCol>
    <VCol cols="12" sm="6" md="4">
      <VCard>
        <RouterCount />
      </VCard>
    </VCol>
    <VCol cols="12">
      <VCard title="Router List">
        <RouterTable />
      </VCard>
    </VCol>
    <VCol cols="12">
      <VCard title="User List">
        <UserTable />
      </VCard>
    </VCol>
    
  </VRow>
</template>
