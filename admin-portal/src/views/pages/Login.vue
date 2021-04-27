<template>
  <v-container
    id="login"
    fill-height
    tag="section"
  >
    <v-row justify="center">
      <v-slide-y-transition appear>
        <base-material-card
          color="success"
          light
          max-width="100%"
          width="400"
          class="px-5 py-3"
        >
    <v-alert
      dense
      outlined
      type="error"
      class="mt-3"
      v-if="alertBox"
    >
      {{errorText}}
    </v-alert>
        
          <template v-slot:heading>
            <div class="text-center">
              <h1 class="display-2 font-weight-bold ">
                Login 
              </h1>

              <!-- <v-btn
                v-for="(social, i) in socials"
                :key="i"
                :href="social.href"
                class="ma-1"
                icon
                rel="noopener"
                target="_blank"
              >
                <v-icon
                  v-text="social.icon"
                />
              </v-btn> -->
            </div>
          </template>

          <v-card-text class="text-center">
            <v-text-field
              color="secondary"
              label="Email..."
              prepend-icon="mdi-email"
              v-model="email"
            />

            <v-text-field
              
              color="secondary"
              label="Password..."
              prepend-icon="mdi-lock-outline"
              type="password"
              v-model="password"
            />
            <div class="text-center grey--text body-2 font-weight-light mb-4">
              No account yet? <a href="/pages/register">Register</a> now 
            </div>
            <pages-btn
              large
              color=""
              depressed
              class="v-btn--text success--text"
              @click="login()"
            >
              Let's Go
            </pages-btn>
          </v-card-text>
        </base-material-card>
      </v-slide-y-transition>
    </v-row>
  </v-container>
</template>

<script>
import { BASEURL } from "@/api/baseurl";
import axios from "axios";

  export default {
    name: 'PagesLogin',

    components: {
      PagesBtn: () => import('./components/Btn')
    },

    data: () => ({
      socials: [
        {
          href: '#',
          icon: 'mdi-facebook-box'
        },
        {
          href: '#',
          icon: 'mdi-twitter'
        },
        {
          href: '#',
          icon: 'mdi-github-box'
        }
      ],

      email:'',
      password:'',
      domain: BASEURL,
      alertBox:false,
      errorText:'',
      companyID:'',

    }),
    computed: {

    },
    created() {


    },
    watch: {


    },

    methods: {

    login() {
      
      
      const params = new URLSearchParams();
      params.append("login", "done");
      params.append("email", this.email);
      params.append("password",this.password);

      axios({
        method: "post",
        url: this.domain + "/user/index.php",
        data: params,
      })
        .then((response) => {
          console.log(response);
          if (response.data.status == "1") {
             
             
             this.companyID = response.data.user.company_id;
              console.log(this.companyID);

              window.location.href = "/dashboard/?id="+this.companyID;

            
            
          } 
          else {
            this.errorText = "Invalid password or email";
            this.alertBox = true;


          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
  }
</script>
