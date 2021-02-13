<template>
    <div id="core-view">
      <v-fade-transition mode="out-in">
        <router-view />
      </v-fade-transition>
    </div>
</template>

<script>
  export default {
    name: 'CoreView'
  }
</script>
