<script setup>
import { ref } from 'vue'
import axios from 'axios'

const isCurrentPasswordVisible = ref(false)
const isNewPasswordVisible = ref(false)
const isConfirmPasswordVisible = ref(false)

const form = ref({
  current_password: '',
  new_password: '',
  new_password_confirmation: '',
})

const passwordRequirements = [
  'Minimum 8 characters long - the more, the better',
  'At least one lowercase character',
  'At least one number, symbol, or whitespace character',
]

const changePassword = () => {
  axios.post('/change-password', form.value)
    .then(response => {
      console.log('Password changed successfully:', response.data)
      alert('Password changed successfully!')
    })
    .catch(error => {
      console.error('Error changing password:', error)
      alert('Error changing password: ' + error.response.data.error)
    })
}
</script>


<template>
  <VRow>
    <VCol cols="12">
      <VCard title="Change Password">
        <VForm @submit.prevent="changePassword">
          <VCardText>
            <!-- Current Password -->
            <VRow class="mb-3">
              <VCol cols="12" md="6">
                <VTextField
                  v-model="form.current_password"
                  :type="isCurrentPasswordVisible ? 'text' : 'password'"
                  :append-inner-icon="isCurrentPasswordVisible ? 'ri-eye-off-line' : 'ri-eye-line'"
                  label="Current Password"
                  placeholder="············"
                  @click:append-inner="isCurrentPasswordVisible = !isCurrentPasswordVisible"
                />
              </VCol>
            </VRow>
            <!-- New Password -->
            <VRow>
              <VCol cols="12" md="6">
                <VTextField
                  v-model="form.new_password"
                  :type="isNewPasswordVisible ? 'text' : 'password'"
                  :append-inner-icon="isNewPasswordVisible ? 'ri-eye-off-line' : 'ri-eye-line'"
                  label="New Password"
                  placeholder="············"
                  @click:append-inner="isNewPasswordVisible = !isNewPasswordVisible"
                />
              </VCol>
              <VCol cols="12" md="6">
                <VTextField
                  v-model="form.new_password_confirmation"
                  :type="isConfirmPasswordVisible ? 'text' : 'password'"
                  :append-inner-icon="isConfirmPasswordVisible ? 'ri-eye-off-line' : 'ri-eye-line'"
                  label="Confirm New Password"
                  placeholder="············"
                  @click:append-inner="isConfirmPasswordVisible = !isConfirmPasswordVisible"
                />
              </VCol>
            </VRow>
          </VCardText>
          <!-- Password Requirements -->
          <VCardText>
            <p class="text-base font-weight-medium mt-2">
              Password Requirements:
            </p>
            <ul class="d-flex flex-column gap-y-3">
              <li
                v-for="item in passwordRequirements"
                :key="item"
                class="d-flex"
              >
                <VIcon
                  size="7"
                  icon="ri-checkbox-blank-circle-fill"
                  class="me-3"
                />
                <span class="font-weight-medium">{{ item }}</span>
              </li>
            </ul>
          </VCardText>
          <!-- Action Buttons -->
          <VCardText class="d-flex flex-wrap gap-4">
            <VBtn type="submit">Save changes</VBtn>
            <VBtn type="reset" color="secondary" variant="outlined">Reset</VBtn>
          </VCardText>
        </VForm>
      </VCard>
    </VCol>
  </VRow>
</template>
