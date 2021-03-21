<template>
  <div class="home">
    <img alt="Vue logo" src="../assets/logo.png" />
    <Content />
  </div>
</template>

<script>
// @ is an alias to /src
import Content from "@/components/Content.vue";


export default {
  name: "Home",

  components: {
    Content
 
  },
};
</script>
