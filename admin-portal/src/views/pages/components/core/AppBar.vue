<template>
  <v-app-bar
    absolute
    color="transparent"
    flat
    height="85"
  >
    <v-container>
      <v-row align="center">
        
        <v-toolbar-title><b ><a href="/" style="color:white!important; text-decoration:none!important;">Appointment System Backend</a></b>
        </v-toolbar-title>

        <v-spacer />

        <v-btn
          v-for="(item, i) in items" 
          :key="i"
          :to="item.to"
          class="hidden-sm-and-down"
          min-height="48"
          text
        >
          <v-icon
            left
            size="20"
            v-text="item.icon"
          />

          <span v-text="item.text" />
        </v-btn>
      </v-row>
    </v-container>
  </v-app-bar>
</template>

<script>
  export default {
    name: 'PagesCoreAppBar',

    data: () => ({
      items: [
        {
          icon: 'mdi-fingerprint',
          text: 'Login',
          to: '/'
        },
        {
          icon: 'mdi-account-multiple-plus',
          text: 'Register',
          to: '/pages/register'
        },
        
        // {
        //   icon: 'mdi-lock-open-outline',
        //   text: 'Lock',
        //   to: '/pages/lock'
        // }
      ],
      // titles: {
      //   '/pages/lock': 'Lock Page',
      //   '/pages/login': 'Login Page',
      //   '/pages/pricing': 'Pricing Page',
      //   '/pages/register': 'Register Page'
      // }
    }),

    computed: {
      
    }
  }
</script>

