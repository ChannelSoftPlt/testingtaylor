<template>
  <v-container id="widgets" fluid>
    <v-row> 
      <v-col cols="12">
        <v-snackbar v-model="error_snackbar" :timeout="timeout">
                {{ error_snackbar_text }}

                <template v-slot:action="{ attrs }">
                  <v-btn
                    color="blue"
                    text
                    icon
                    v-bind="attrs"
                    @click="error_snackbar = false"
                  >
                    <v-icon>mdi-close</v-icon>
                  </v-btn>
                </template>
       </v-snackbar>
        <v-tabs active-class="blue--text" color="blue">
          <v-tabs-slider></v-tabs-slider>
          <v-tab>
            <v-icon>mdi-briefcase</v-icon>
            <span class="pl-3">General</span>
          </v-tab>

          <v-tab>
            <v-icon>mdi-note</v-icon>
            <span class="pl-3">Booking Page</span>
          </v-tab>

          <v-tab-item class="pa-md-12">
            <v-sheet color="white" class="mt-5 mb-16">
              <v-row>
                <v-col>
                  <b
                    ><h2 class="text-center text-md-left">
                      Company Details
                    </h2></b
                  >
                </v-col>
              </v-row>
              <v-row>
                <v-col cols="12" md="4">
                  <span class="ml-4">Company Name</span>
                  <v-subheader
                    >Company name will be displayed everywhere on the
                    system</v-subheader
                  >
                </v-col>
                <v-col cols="12" md="8" class="px-7">
                  <v-text-field
                    v-model="companyName"
                    placeholder="e.g Harry Kitchen"
                    clearable
                  ></v-text-field>
                </v-col>
              </v-row>

              <v-row>
                <v-col cols="12" md="4">
                  <span class="ml-4">Logo</span>
                  <v-subheader
                    >Company logo will be displayed on the system</v-subheader
                  >
                </v-col>
                <v-col cols="12" md="8" class="px-7">
                  <!-- <v-file-input
                    v-model="companyLogo"
                    :rules="imageRules"
                    accept="image/png, image/jpeg, image/bmp"
                    prepend-icon="mdi-camera"
                    persistent-hint hint="*maximum size 1mb"
                  ></v-file-input> -->
                  <img :src="imagePath" height="150" v-if="imageName"/>
                  <v-file-input
                    label="File input"
                    accept="image/png, image/jpeg"
                    v-model="gallery_file"
                    :rules="imageRules"
                    prepend-icon="mdi-camera"
                    persistent-hint
                    hint="*maximum size 1mb"
                  >
                  </v-file-input>
                </v-col>
              </v-row>

              <v-row>
                <v-col cols="12" md="4">
                  <span class="ml-4">Email</span>
                  <v-subheader
                    >This email will same as admin login email.</v-subheader
                  >
                </v-col>
                <v-col cols="12" md="8" class="px-7">
                  <v-text-field
                    v-model="email"
                    placeholder="e.g email123@hotmail.com"
                    clearable
                  ></v-text-field>
                </v-col>
              </v-row>

              <v-row>
                <v-col cols="12" md="4">
                  <span class="ml-4">Phone</span>
                  <v-subheader
                    >This phone will show to customer as company
                    phone</v-subheader
                  >
                </v-col>
                <v-col cols="12" md="8" class="px-7">
                  <!-- <vue-tel-input-vuetify
                    v-model="companyPhone"
                  ></vue-tel-input-vuetify> -->
                  <v-text-field v-model="companyPhone"></v-text-field>
                </v-col>
              </v-row>

              <v-row>
                <v-col cols="12" md="4">
                  <span class="ml-4">Industry</span>
                  <v-subheader
                    >This phone will show to customer as company
                    phone</v-subheader
                  >
                </v-col>
                <v-col cols="12" md="8" class="px-7">
                  <v-select
                    color="primary"
                    v-model="companyIndustry"
                    :items="categories"
                    hide-details
                    single-line
                  ></v-select>
                </v-col>
              </v-row>

              <v-row>
                <v-col cols="12" md="4">
                  <span class="ml-4">Address</span>
                  <v-subheader
                    >This address will show is means where you main company
                    located
                  </v-subheader>
                </v-col>
                <v-col cols="12" md="8" class="px-7">
                  <v-textarea
                    clear-icon="mdi-close-circle"
                    v-model="companyAddress"
                  ></v-textarea>
                </v-col>
              </v-row>
              <!-- <v-row>
                <v-col>
                  <b
                    ><h2 class="text-center text-md-left">
                      Company Authorization
                    </h2></b
                  >
                </v-col>
              </v-row>
              <v-row>
                <v-col cols="12" md="4">
                  <span class="ml-4">Password</span>
                  <v-subheader
                    >This password will be used when you login to this
                    portal</v-subheader
                  >
                </v-col>
                <v-col cols="12" md="8" class="px-7">
                  <v-text-field
                    v-model="password"
                    :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                    :type="showPassword ? 'text' : 'password'"
                    @click:append="showPassword = !showPassword"
                  ></v-text-field>
                </v-col>
              </v-row> -->
              <v-row class="text-center">
                <v-col>
                  <v-btn color="success" @click="updateCompany()"> Save </v-btn>
                </v-col>
              </v-row>
            </v-sheet>
          </v-tab-item>
          <v-tab-item class="pa-md-12">
            <v-sheet color="white" class="mt-5 mb-16">
              <v-row>
                <v-col cols="9" md="4">
                  <span class="ml-4">Background Colour</span>
                  <v-subheader
                    >There is two gradient color for your booking page
                    background
                  </v-subheader>
                </v-col>
                <v-col cols="2" md="8">
                  <v-swatches
                    v-model="color1"
                    show-fallback
                    swatches="text-advanced"
                  ></v-swatches>
                  <v-spacer></v-spacer>
                  <v-swatches
                    v-model="color2"
                    show-fallback
                    swatches="text-advanced"
                  ></v-swatches>
                </v-col>
              </v-row>

              <v-row>
                <v-col cols="9" md="4">
                  <span class="ml-4">Step Button Color</span>
                  <v-subheader
                    >The step button color that will show on the booking page
                    for stepper</v-subheader
                  >
                </v-col>
                <v-col cols="2" md="8">
                  <v-swatches
                    v-model="stepButtonColor"
                    show-fallback
                    swatches="text-advanced"
                  ></v-swatches>
                </v-col>
              </v-row>

              <v-row>
                <v-col cols="9" md="4">
                  <span class="ml-4">Continue Button Color</span>
                  <v-subheader
                    >The continue button color that will show on the booking
                    page for stepper.</v-subheader
                  >
                </v-col>
                <v-col cols="2" md="8">
                  <v-swatches
                    v-model="continueButtonColor"
                    show-fallback
                    swatches="text-advanced"
                  ></v-swatches>
                </v-col>
              </v-row>

              <v-row>
                <v-col cols="9" md="4">
                  <span class="ml-4">Header Text Color</span>
                  <v-subheader
                    >This is the color for the header text on the booking
                    page</v-subheader
                  >
                </v-col>
                <v-col cols="2" md="8">
                  <v-swatches
                    v-model="headerTextColor"
                    show-fallback
                    swatches="text-advanced"
                  ></v-swatches>
                </v-col>
              </v-row>

              <v-row>
                <v-col cols="9" md="4">
                  <span class="ml-4">Description Text Color</span>
                  <v-subheader
                    >This is the color for the description text on the booking
                    page</v-subheader
                  >
                </v-col>
                <v-col cols="2" md="8">
                  <v-swatches
                    v-model="descriptionTextColor"
                    show-fallback
                    swatches="text-advanced"
                  ></v-swatches>
                </v-col>
              </v-row>

              <v-row class="text-center pb-12">
                <v-col>
                  <v-btn color="success" @click="updateColor()"> Save </v-btn>
                </v-col>
              </v-row>
              
            </v-sheet>
          </v-tab-item>
        </v-tabs>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import VSwatches from "vue-swatches";
import "vue-swatches/dist/vue-swatches.css";
import { BASEURL } from "@/api/baseurl";
import axios from "axios";
export default {
  name: "DashboardCalendar",

  components: { VSwatches },

  data: () => ({
    imageRules: [(value) => !value || value.size < 1000000],
    domain: BASEURL,
    company_id: "",
    categories: [
      "F&B",
      "Pet Service",
      "Medical & Health",
      "Beauty, cosmetic & personal care",
      "Others",
    ],
    companyName: "",
    gallery_file: [],
    email: "",
    companyPhone: "",
    companyIndustry: "",
    companyAddress: "",
    password: "",
    color1: "",
    color2: "",
    stepButtonColor: "",
    continueButtonColor: "",
    headerTextColor: "",
    descriptionTextColor: "",
    showPassword: false,
    error_snackbar: false,
    error_snackbar_text: "",
    timeout: 2000,
    imageName: "",
  }),
  created() {
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);

    if (urlParams.has("id")) {
      const id = urlParams.get("id");
      this.company_id = id;
      this.getCompany();
      this.getAdmin();
    }
  },
  watch: {
    gallery_file(){
      this.uploadImage();
    }


  },
  computed: {
    imagePath(){
      return "https://lkmng.com/appointment/logo/"+this.imageName; 
    },
    companyColor(){
      var object={'color1': this.color1,'color2': this.color2 ,'stepButtonColor':this.stepButtonColor, 'continueButtonColor': this.continueButtonColor
                 ,'headerTextColor':this.headerTextColor, 'descriptionTextColor': this.descriptionTextColor};
      var color = JSON.stringify(object);

      return color;

    }
  },

  methods: {
    getCompany() {
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
            this.companyName = response.data.company[0].name;
            this.imageName = response.data.company[0].logo; 
            this.companyIndustry = response.data.company[0].industry;
            this.color1 = JSON.parse(response.data.company[0].color).color1;
            this.color2 = JSON.parse(response.data.company[0].color).color2;
            this.stepButtonColor = JSON.parse(
              response.data.company[0].color
            ).color1;
            this.continueButtonColor = JSON.parse(
              response.data.company[0].color
            ).continueButtonColor;
            this.headerTextColor = JSON.parse(
              response.data.company[0].color
            ).headerTextColor;
            this.descriptionTextColor = JSON.parse(
              response.data.company[0].color
            ).descriptionTextColor;

            this.companyAddress = response.data.company[0].address;
          } else {
            console.log("no company found");
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
    getAdmin() {
      const params = new URLSearchParams();
      params.append("getAdmin", "done");
      params.append("company_id", this.company_id);

      axios({
        method: "post",
        url: this.domain + "/user/index.php",
        data: params,
      })
        .then((response) => {
          console.log(response);
          if (response.data.status == "1") {
            this.email = response.data.user[0].email;
            this.companyPhone = response.data.user[0].contact;
          } else {
            console.log("no admin found");
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
    uploadImage() {
      // if (
      //   this.gallery_file !== undefined &&
      //   this.gallery_file !== null &&
      //   this.gallery_file !== ""
      // ) {
      //   if (this.gallery_file.size > 1000000) {
      //     this.error_snackbar = true;
      //     this.error_snackbar_text = "maximum size 1mb";
      //     return;
      //   }

      const fr = new FileReader();
      fr.readAsDataURL(this.gallery_file);

      fr.addEventListener("load", () => {
        // console.log(fr.result);
        var base_64 = fr.result;
        const params = new URLSearchParams();
        params.append("upload_image", "upload_image");
        params.append("image_name", this.gallery_file.name);
        params.append("image", base_64);

        axios({
          method: "post",
          url: this.domain + "/company/index.php",
          data: params,
        })
          .then((response) => {
            console.log(response);
            if (response.data.status == "1") {
              this.imageName = response.data.picture_name;
            } else {
              console.log("failed");
            }
          })
          .catch((error) => {
            console.log(error);
          });
      });
      // } else {
      //   this.product_imageUrl = "";
      //   this.product_file = "";

      //   this.error_snackbar = true;
      //   this.error_snackbar_text = "Please select file";
      // }
    },
    updateCompany() {
      const params = new URLSearchParams();
      params.append("update", "done");
      params.append("company_id", this.company_id);
      params.append("name", this.companyName);
      params.append("logo", this.imageName);
      params.append("email", this.email);
       params.append("contact", this.companyPhone);
      params.append("industry", this.companyIndustry);
      params.append("address", this.companyAddress);
      axios({
        method: "post",
        url: this.domain + "/user/index.php",
        data: params,
      })
        .then((response) => {
          console.log(response);
          if (response.data.status == "1") {
            console.log("update success"); 
            this.error_snackbar =true;
            this.error_snackbar_text ="Update Successfully";
          } else {
            this.error_snackbar =true;
            this.error_snackbar_text ="Update Failed";
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
    updateColor(){
      const params = new URLSearchParams();
      params.append("update", "done");
      params.append("company_id", this.company_id);
      params.append("color", this.companyColor);
    
      axios({
        method: "post",
        url: this.domain + "/company/index.php",
        data: params,
      })
        .then((response) => {
          console.log(response);
          if (response.data.status == "1") {
            this.error_snackbar =true;
            this.error_snackbar_text ="Update Successfully";
          } else {
            this.error_snackbar =true;
            this.error_snackbar_text ="Update Failed";
          }
        })
        .catch((error) => {
          console.log(error);
        });
      
    }
  },
};
</script>

<style lang="sass">
#coloured-line
  .ct-series-a .ct-line,
  .ct-series-a .ct-point
    stroke: #00cae3 !important

  #multiple-bar
    .ct-series-a .ct-bar
      stroke: #00cae3 !important

    .ct-series-b .ct-bar
      stroke: #f44336 !important

  #pie
    .ct-series-a .ct-slice-pie
      fill: #00cae3 !important

    .ct-series-b .ct-slice-pie
      fill: #f44336 !important
</style>
