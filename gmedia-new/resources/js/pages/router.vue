<script setup>
import RouterTable from '@/views/router/RouterTable.vue'
import RouterForm from '@/views/router/RouterForm.vue'
</script>

<template>
  <VRow>

    <VCol cols="12">
        <VCard title="Router Form">
          <VCardText>
            <RouterForm />
          </VCardText>
        </VCard>
      </VCol>
    <VCol cols="12">
      <VCard title="Router List">
        <RouterTable />
      </VCard>
    </VCol>
    
  </VRow>
</template>
