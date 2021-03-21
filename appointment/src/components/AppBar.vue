<template>
    <v-app-bar app color="primary" dark>
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
</template>

<script>
export default {
  name: "AppBar",

  data: () => ({
    //
  }),
};
</script>