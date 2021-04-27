<template>
  <v-app style="background-color: #5E35B1!important;">
    <pages-core-app-bar />

    <pages-core-view />

    <pages-core-footer />
  </v-app>
</template>

<script>
  export default {
    name: 'PagesIndex',

    components: {
      PagesCoreAppBar: () => import('./components/core/AppBar'),
      PagesCoreFooter: () => import('./components/core/Footer'),
      PagesCoreView: () => import('./components/core/View')
    },

    created() {
      this.$vuetify.theme.dark = true
    },

    beforeDestroy() {
      this.$vuetify.theme.dark = false
    }
  }
</script>
