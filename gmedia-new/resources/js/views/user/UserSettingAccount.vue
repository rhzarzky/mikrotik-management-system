<template>
  <VRow>
    <VCol cols="12">
      <VCard title="Account Details">
        <VCardText class="d-flex">
          <VAvatar
            rounded="lg"
            size="100"
            class="me-6"
            :image="accountData.photo"
          />
          <form class="d-flex flex-column justify-center gap-5">
            <div class="d-flex flex-wrap gap-2">
              <VBtn color="primary" @click="refInputEl.click()">
                <VIcon icon="ri-upload-cloud-line" class="d-sm-none" />
                <span class="d-none d-sm-block">Upload new photo</span>
              </VBtn>
              <input
                ref="refInputEl"
                type="file"
                name="file"
                accept=".jpeg,.png,.jpg,GIF"
                hidden
                @change="changeAvatar"
              />
              <VBtn
                type="button"
                color="error"
                variant="outlined"
                @click.prevent="resetAvatar"
              >
                <span class="d-none d-sm-block">Reset</span>
                <VIcon icon="ri-refresh-line" class="d-sm-none" />
              </VBtn>
            </div>
            <p class="text-body-1 mb-0">
              Allowed JPG, GIF or PNG. Max size of 800K
            </p>
          </form>
        </VCardText>
        <VDivider />
        <VCardText>
          <VForm class="mt-6">
            <VRow>
              <VCol md="6" cols="12">
                <VTextField
                  v-model="accountData.firstName"
                  placeholder="John"
                  label="First Name"
                />
              </VCol>
              <VCol md="6" cols="12">
                <VTextField
                  v-model="accountData.lastName"
                  placeholder="Doe"
                  label="Last Name"
                />
              </VCol>
              <VCol cols="12" md="6">
                <VTextField
                  v-model="accountData.email"
                  label="E-mail"
                  placeholder="johndoe@gmail.com"
                  type="email"
                />
              </VCol>
              <VCol cols="12" md="6">
                <VTextField
                  v-model="accountData.org"
                  label="Organization"
                  placeholder="ThemeSelection"
                />
              </VCol>
              <VCol cols="12" md="6">
                <VTextField
                  v-model="accountData.address"
                  label="Address"
                  placeholder="123 Main St, New York, NY 10001"
                />
              </VCol>
              <VCol cols="12" class="d-flex flex-wrap gap-4">
                <VBtn @click="saveChanges">Save changes</VBtn>
                <VBtn
                  color="secondary"
                  variant="outlined"
                  type="reset"
                  @click.prevent="resetForm"
                >
                  Reset
                </VBtn>
              </VCol>
            </VRow>
          </VForm>
        </VCardText>
      </VCard>
    </VCol>
    <VCol cols="12">
      <VCard title="Deactivate Account">
        <VCardText>
          <div>
            <VCheckbox
              v-model="isAccountDeactivated"
              label="I confirm my account deactivation"
            />
          </div>
          <VBtn
            :disabled="!isAccountDeactivated"
            color="error"
            class="mt-3"
            @click="deactivateAccount"
          >
            Deactivate Account
          </VBtn>
        </VCardText>
      </VCard>
    </VCol>
  </VRow>
</template>

<script setup>
import axios from 'axios';
import { ref } from 'vue';
import avatar1 from '@images/avatars/avatar-1.png';

const accountData = ref({
  avatarImg: avatar1,
  firstName: '',
  lastName: '',
  email: '',
  org: '',
  address: '',
});

const refInputEl = ref();
let photoFile = null;

const fetchUserData = () => {
  axios.get('/userdata-show')
    .then(response => {
      const userData = response.data.data.user_data;
      accountData.value = {
        photo: userData.photo ? `/storage/app/${userData.photo}` : avatar1,
        firstName: userData.firstname,
        lastName: userData.lastname,
        email: response.data.data.email,
        org: userData.organization,
        address: userData.address,
      };
    })
    .catch(error => {
      console.error('Error fetching user data:', error);
    });
};

const resetForm = () => {
  fetchUserData();
};

const changeAvatar = (event) => {
  const file = event.target.files[0];
  if (file) {
    photoFile = file;
    const fileReader = new FileReader();
    fileReader.readAsDataURL(file);
    fileReader.onload = () => {
      if (typeof fileReader.result === 'string') {
        accountData.value.avatarImg = fileReader.result;
      }
    };
  }
};

const resetAvatar = () => {
  accountData.value.avatarImg = avatar1;
};

const saveChanges = () => {
  const userData = new FormData();
  userData.append('firstname', accountData.value.firstName);
  userData.append('lastname', accountData.value.lastName);
  userData.append('organization', accountData.value.org);
  userData.append('address', accountData.value.address);
  if (photoFile) {
    userData.append('photo', photoFile);
  }

  axios.post('/userdata-store-update', userData, {
    headers: {
      'Content-Type': 'multipart/form-data',
    },
  })
    .then(response => {
      console.log('User data updated successfully:', response.data);
      fetchUserData(); 
      photoFile = null; 
    })
    .catch(error => {
      console.error('Error updating user data:', error);
    });
};

const deactivateAccount = () => {
  // Implement account deactivation logic here
};

fetchUserData(); // Initial fetch on component mount
</script>
