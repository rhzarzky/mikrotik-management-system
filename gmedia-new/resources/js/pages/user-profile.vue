<script setup>
import UserTable from '@/views/user/UserTable.vue'
import UserForm from '@/views/user/UserForm.vue'
</script>

<template>
  <VRow>

    <VCol cols="12">
        <VCard title="User Form">
          <VCardText>
            <UserForm />
          </VCardText>
        </VCard>
      </VCol>
    <VCol cols="12">
      <VCard title="User List">
        <UserTable />
      </VCard>
    </VCol>
    
  </VRow>
</template>
