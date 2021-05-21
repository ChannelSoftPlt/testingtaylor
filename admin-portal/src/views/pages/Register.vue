<template>
  <v-container id="register" fill-height tag="section">
    <v-row justify="center">
      <v-col cols="12" md="4">
        <v-slide-y-transition appear>
          <v-card class="pa-3 pa-md-5 mx-auto" light>
            <pages-heading class="text-center text-h4 text-md-h4 mb-4">
              Register
            </pages-heading>

            <v-row>
              <!-- <v-col
                cols="12"
                md="6"
              >
                <v-row no-gutters>
                  <v-col
                    v-for="(section, i) in sections"
                    :key="i"
                    cols="12"
                  >
                    <v-list-item three-line>
                      <v-list-item-icon class="mr-4 mt-5 mt-md-4">
                        <v-icon
                          :large="$vuetify.breakpoint.mdAndUp"
                          :color="section.iconColor"
                          v-text="section.icon"
                        />
                      </v-list-item-icon>

                      <v-list-item-content>
                        <v-list-item-title
                          class="font-weight-light mb-4 mt-3"
                          v-text="section.title"
                        />

                        <v-list-item-subtitle v-text="section.text" />
                      </v-list-item-content>
                    </v-list-item>
                  </v-col>
                </v-row>
              </v-col> -->

              <v-col cols="12" md="12">
                <div class="text-center">
                  <v-btn
                    v-for="(social, i) in socials"
                    :key="i"
                    :color="social.iconColor"
                    class="my-2 mr-1"
                    dark
                    depressed
                    fab
                    small
                  >
                    <v-icon v-text="social.icon" />
                  </v-btn>

                  <div class="my-2" />

                  <div class="text-center grey--text body-1 font-weight-light">
                    Contact Us
                  </div>

                  <v-text-field
                    color="secondary"
                    label="Name..."
                    prepend-icon="mdi-face"
                    v-model="name"
                  />

                  <v-text-field
                    color="secondary"
                    label="Email..."
                    prepend-icon="mdi-email"
                    v-model="email"
                  />

                  <v-text-field
                    color="secondary"
                    label="Phone"
                    prepend-icon="mdi-phone"
                    v-model="contact"
                  />

                  <v-text-field
                    color="secondary"
                    label="Password..."
                    type="password"
                    v-model="password"
                    prepend-icon="mdi-lock-outline"
                  />

                  <v-text-field
                    color="secondary"
                    label="Company Name..."
                    v-model="companyName"
                    prepend-icon="mdi-briefcase"
                  />

                  <v-select
                    color="secondary"
                    class="mb-8"
                    v-model="industry"
                    :items="categories"
                    label="Business Categories..."
                    hide-details
                    prepend-icon="mdi-map"
                    single-line
                  ></v-select>

                  <v-text-field
                    color="secondary"
                    label="Company Address..."
                    v-model="address"
                    prepend-icon="mdi-map-marker"
                  />

                  <v-checkbox :input-value="true" color="secondary">
                    <template v-slot:label>
                      <div>
                        I agree that
                        <a
                          target="_blank"
                          href="https://vuetifyjs.com"
                          @click.stop
                          class="secondary--text"
                        >
                          terms and conditions
                        </a>
                      </div>
                    </template>
                  </v-checkbox>

                  <pages-btn color="success" @click="register()">
                    Sign Up
                  </pages-btn>
                </div>
              </v-col>
            </v-row>
          </v-card>
        </v-slide-y-transition>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import { BASEURL } from "@/api/baseurl";
import axios from "axios";
export default {
  name: "PagesRegister",

  components: {
    PagesBtn: () => import("./components/Btn"),
    PagesHeading: () => import("./components/Heading"),
  },

  data: () => ({
    sections: [
      {
        icon: "mdi-chart-timeline-variant",
        iconColor: "primary",
        title: "Marketing",
        text: `We've created the marketing campaign of the website. It was a very interesting collaboration.`,
      },
      {
        icon: "mdi-code-tags",
        iconColor: "secondary",
        title: "Fully Coded in HTML5",
        text: `We've developed the website with HTML5 and CSS3. The client has access to the code using GitHub.`,
      },
      {
        icon: "mdi-account-multiple",
        iconColor: "cyan",
        title: "Built Audience",
        text:
          "There is also a Fully Customizable CMS Admin Dashboard for this product.",
      },
    ],
    socials: [
      {
        href: "#",
        icon: "mdi-twitter",
        iconColor: "#1DA1F2",
      },
      {
        href: "#",
        icon: "mdi-google",
        iconColor: "#ea4c89",
      },
      {
        href: "#",
        icon: "mdi-facebook",
        iconColor: "#3B5998",
      },
    ],
    domain: BASEURL,
    contact: "",
    name: "",
    email: "",
    password: "",
    categories: [
      "F&B",
      "Pet Service",
      "Medical & Health",
      "Beauty, cosmetic & personal care",
      "others",
    ],
    industry: "",
    companyName:'',
    address:'',
  }),
  computed: {
    checkboxErrors() {
      const errors = [];
      if (!this.$v.checkbox.$dirty) return errors;
      !this.$v.checkbox.checked && errors.push("You must agree to continue!");
      return errors;
    },
  },
  created() {},
  watch: {},
  methods: {
    register() {
      const params = new URLSearchParams();
      params.append("create", "done");
      params.append("name", this.name);
      params.append("email", this.email);
      params.append("contact", this.contact);
      params.append("password", this.password);
      params.append("company_name", this.companyName);
      params.append("industry", this.industry);
      params.append("address", this.address);
      params.append("password", this.password);

      axios({
        method: "post",
        url: this.domain + "/user/index.php",
        data: params,
      })
        .then((response) => {
          console.log(response);
          if (response.data.status == "1") {
            console.log("register successfully");
          } else if(response.data.status=="User Existed!") {
            console.log("Email existed");
          } else if(response.data.status=="Add Company Failed!"){
            console.log("add company failed")
          } else {
            console.log("check your information");
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
};
</script>

<style lang="sass">
#register
  .v-list-item__subtitle
    -webkic-line-clamp: initial
    -webkit-box-orient: initial
</style>
