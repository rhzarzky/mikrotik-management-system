<script setup>
import UserProfileTable from '@/views/user-profile/UserProfileTable.vue'
import UserProfileForm from '@/views/user-profile/UserProfileForm.vue'
</script>

<template>
  <VRow>

    <VCol cols="12">
        <VCard title="User Form">
          <VCardText>
            <UserProfileForm />
          </VCardText>
        </VCard>
      </VCol>
    <VCol cols="12">
      <VCard title="User List">
        <UserProfileTable />
      </VCard>
    </VCol>
    
  </VRow>
</template>
