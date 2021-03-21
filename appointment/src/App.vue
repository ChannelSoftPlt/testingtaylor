<template>
  <v-app>
    <AppBar />
    <v-main>
        <Content/>
    </v-main>
  </v-app>
</template>

<script>

import AppBar from "./components/AppBar";
import Content from "./components/Content";

export default {
  name: "App",

  components: {
    AppBar,
    Content
  },

  data: () => ({
    //
  }),
};
</script>
