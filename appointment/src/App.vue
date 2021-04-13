<template>
  <v-app>
    <!-- <AppBar /> -->
    <v-main>
        <Content v-if="this.companyIndustry=='F&B'"/> 
        <otherService v-if="this.companyIndustry!='F&B'"/> 
    </v-main>
  </v-app>
</template>

<script>

import { BASEURL } from "@/api/baseurl";
import axios from "axios";
import otherService from "./components/otherService";

// import AppBar from "./components/AppBar";
import Content from "./components/Content";

export default {
  name: "App",

  components: {
    // AppBar,
    Content,
    otherService
  },

  data: () => ({
      domain: BASEURL,
      company_id:'',
      companyIndustry:'',
    
  }),
  computed:{

  },
  created(){
    //check form availble
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);

    if (urlParams.has("id")) {
      const id = urlParams.get("id");
      this.company_id = id;
      this.differentCompanyInsutstry();
    }

  },
  watch:{

  },
  methods:{
    differentCompanyInsutstry() {
      const params = new URLSearchParams();
      params.append("read", "done");
      params.append("company_id", this.company_id);
      axios({
        method: "post",
        url: this.domain + "/company/index.php",
        data: params,
      })
        .then((response) => {
          console.log(response);
          if (response.data.status == "1") {
            this.companyIndustry = response.data.company[0].industry;
            
            
          } else {
            console.log("no company");
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },



  },
};
</script>
