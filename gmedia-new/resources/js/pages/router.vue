<script setup>
import DemoSimpleTableBasics from '@/views/pages/tables/DemoSimpleTableBasics.vue'
import DemoSimpleTableDensity from '@/views/pages/tables/DemoSimpleTableDensity.vue'
import DemoSimpleTableFixedHeader from '@/views/pages/tables/DemoSimpleTableFixedHeader.vue'
import DemoSimpleTableHeight from '@/views/pages/tables/DemoSimpleTableHeight.vue'
import DemoSimpleTableTheme from '@/views/pages/tables/DemoSimpleTableTheme.vue'
</script>

<template>
  <VRow>
    <VCol cols="12">
      <VCard title="Basic">
        <VCardText>
          You can fix the header of table by using the <code>fixed-header</code> prop.
        </VCardText>
        <DemoSimpleTableBasics />
      </VCard>
    </VCol>
  </VRow>
</template>
