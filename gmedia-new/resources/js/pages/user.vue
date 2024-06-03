<script setup>
import UserTable from '@/views/pages/tables/UserTable.vue'
import UserActiveTable from '@/views/pages/tables/UserActiveTable.vue'
</script>

<template>
  <VRow>
    <VCol cols="12">
      <VCard title="User Active">
        <UserActiveTable />
      </VCard>
    </VCol>
    
    <VCol cols="12">
      <VCard title="User List">
        <UserTable />
      </VCard>
    </VCol>
    
  </VRow>
</template>
