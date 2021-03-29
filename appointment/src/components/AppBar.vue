<template>
    <div>
    <v-app-bar app color="primary" dark>
     <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
      <div class="d-flex align-center">
        <v-img
          alt="Company Logo"
          class="shrink mr-2"
          contain
          src="https://cdn.vuetifyjs.com/images/logos/vuetify-logo-dark.png"
          transition="scale-transition"
          width="40"
        />

        <div class="font-weight-medium">
            <h3>Appointment Booking Page</h3>
        </div>
      </div>

      <v-spacer></v-spacer>
    
    </v-app-bar>
    <v-navigation-drawer
      v-model="drawer"
      absolute
      bottom
      temporary
    >
      <v-list
        nav
        dense
      >
        <v-list-item-group
          v-model="group"
          active-class="blue darken-1--text text--accent-2"
          color="white"
        >
          <v-list-item>
            <v-list-item-title>Book Appointment</v-list-item-title>
          </v-list-item>

          <v-list-item>
            <v-list-item-title>Bar</v-list-item-title>
          </v-list-item>

          <v-list-item>
            <v-list-item-title>Fizz</v-list-item-title>
          </v-list-item>

          <v-list-item>
            <v-list-item-title>Buzz</v-list-item-title>
          </v-list-item>
        </v-list-item-group>
      </v-list>
    </v-navigation-drawer>

    </div>
    
     
</template>

<script>



export default {

  name: "AppBar",

  data: () => ({
      drawer: false,
      group: null,
  }),
   watch: {
      group () {
        this.drawer = false
      },
    },
};
</script>