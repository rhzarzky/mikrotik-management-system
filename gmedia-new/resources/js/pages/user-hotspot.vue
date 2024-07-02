<script setup>
import UserHotspotTable from '@/views/user-hotspot/UserHotspotTable.vue'
import UserHotspotForm from '@/views/user-hotspot/UserHotspotForm.vue'
import UserHotspotActiveTable from '@/views/user-hotspot/UserHotspotActiveTable.vue'
</script>

<template>
  <VRow>

    <!-- User Hotspot Form -->
    <VCol cols="12" md="4">
      <VCard title="User Hotspot Form">
        <VCardText>
          <UserHotspotForm />
        </VCardText>
      </VCard>
    </VCol>

    <!-- User Hotspot Active Table -->
    <VCol cols="12" md="8">
      <VCard title="User Active">
        <UserHotspotActiveTable />
      </VCard>
    </VCol>

    <!-- User Hotspot Table -->
    <VCol cols="12">
      <VCard title="User Hotspot">
        <UserHotspotTable />
      </VCard>
    </VCol>
    
  </VRow>
</template>
