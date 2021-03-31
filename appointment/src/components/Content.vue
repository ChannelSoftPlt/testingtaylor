<template>
  <div
    :style="{
      backgroundImage: createBackgroundString,
      height: backgroundHeight,
    }"
  >
    <v-row class="pt-5">
      <v-col cols="12" md="6" align="center">
        <h3 :style="{ color: headerTextColor }">{{ company_name }}</h3>
      </v-col>
      <v-col cols="12" md="6" align="center">
        <a :style="{ color: headerTextColor }"
          ><h3 class="hidden-sm-and-down">
            <v-icon medium color="green lighten-2"> mdi-phone </v-icon>Contact
            Us
          </h3></a
        >
      </v-col>
    </v-row>
    <v-row class="my-4">
      <v-col cols="12" md="4" class="d-none d-lg-block"></v-col>
      <v-col cols="12" md="4" align="center">
        <h2 :style="{ color: headerTextColor }">Book Appointment Now!</h2>
        <p class="px-7">
          <span :style="{ color: descriptionTextColor }"
            >Make an appointment with us now to save your time {{offday}}
          </span>
        </p>
      </v-col>
      <v-col cols="12" md="4" class="d-none d-lg-block"></v-col>
    </v-row>

    <v-row>
      <v-col cols="12" md="4"></v-col>

      <v-col cols="12" md="4" class="mb-16">
        <v-stepper v-model="e6" vertical class="mx-3 grey lighten-5">
          <v-stepper-step :complete="e6 > 1" step="1" :color="stepButtonColor">
            Choose a Branch
          </v-stepper-step>

          <v-stepper-content step="1">
            <v-select
              :items="items"
              item-text="name"
              item-value="branch_id"
              label="Branch"

              v-model="selectedBranch"
              @change="
                (selectedDate = ''),
                  (e6 = 2),
                  
                  getBranchDateAndTime(),                 
                  getBranchHoliday()
 
                  
              "
              return-object
            ></v-select>
          </v-stepper-content>

          <v-stepper-step :complete="e6 > 2" step="2" :color="stepButtonColor">
            Pick a date
          </v-stepper-step>

          <v-stepper-content step="2">
            <vc-date-picker
              @dayclick="selectedDate? (e6 = 3) : (e6 = 2)"
              v-model="selectedDate"
              :model-config="modelConfig"
              color="purple"
              is-expanded
              :disabled-dates='[{weekdays:weekdays},offday ]' 
              
              :min-date='new Date()'
              
              
              

              
              
            />
            <br />
            <br />

            <v-btn text :color="continueButtonColor" outlined @click="e6 = 1">
              Back
            </v-btn>
          </v-stepper-content>

          <v-stepper-step :complete="e6 > 3" step="3" :color="stepButtonColor">
            Choose a time
          </v-stepper-step>

          <v-stepper-content step="3">
            <v-row class="mb-2">
              <v-col cols="4" sm="12">
                <p>Morning</p>
                <v-row>
                  <div v-for="(time, i) in time" :key="i">
                    <v-btn
                      class="mb-2 mt-1 mr-1 ml-3"
                      outlined
                      color="indigo"
                      small
                      v-model="selectedTime"
                      @click="
                        selectedTime = time.text;
                        e6 = 4;
                      "
                      v-if="parseFloat(time.text.substring(0, 2)) < 12"
                    >
                      {{ time.text }}
                    </v-btn>
                  </div>
                </v-row>
              </v-col>
              <v-col cols="4" sm="12">
                <p>Noon</p>
                <v-row>
                  <div v-for="(time, i) in time" :key="i">
                    <v-btn
                      class="mb-2 mt-1 mr-1 ml-3"
                      outlined
                      color="indigo"
                      small
                      v-model="selectedTime"
                      @click="
                        selectedTime = time.text;
                        e6 = 4;
                      "
                      v-if="
                        parseFloat(time.text.substring(0, 2)) > 12 &&
                        parseFloat(time.text.substring(0, 2)) <= 18
                      "
                    >
                      {{ time.text }}
                    </v-btn>
                  </div>
                </v-row>
              </v-col>
              <v-col cols="4" sm="12">
                <p>Night</p>
                <v-row>
                  <div v-for="(time, i) in time" :key="i">
                    <v-btn
                      class="mb-2 mt-1 mr-1 ml-3"
                      outlined
                      color="indigo"
                      small
                      v-model="selectedTime"
                      @click="
                        selectedTime = time.text;
                        e6 = 4;
                      "
                      v-if="parseFloat(time.text.substring(0, 2)) > 18"
                    >
                      {{ time.text }}
                    </v-btn>
                  </div>
                </v-row>
              </v-col>
            </v-row>
            <v-btn
              text
              :color="continueButtonColor"
              outlined
              @click="(selectedDate = ''), (e6 = 2)"
            >
              Back
            </v-btn>
          </v-stepper-content>
          <v-stepper-step :complete="e6 > 4" step="4" :color="stepButtonColor">
            Total person
          </v-stepper-step>
          <v-stepper-content step="4">
            <v-checkbox
              @click="e6 = 5"
              v-model="selectedPerson"
              :color="stepButtonColor"
              :label="pax.text + ' pax'"
              :value="pax.text"
              v-for="(pax, i) in pax"
              :key="i"
            ></v-checkbox>
            <v-btn text @click="e6 = 3" :color="continueButtonColor" outlined>
              Back
            </v-btn>
          </v-stepper-content>
          <v-stepper-step step="5" :color="stepButtonColor">
            Your Info
          </v-stepper-step>

          <v-stepper-content step="5">
            <v-card-title>
              <v-row>
                <v-icon>mdi-account</v-icon>
                <span>Customer Information</span>
              </v-row>
            </v-card-title>
            <v-form class="mb-2" ref="form" v-model="valid" lazy-validation>
              <v-row>
                <v-col cols="12" sm="4" md="6">
                  <v-text-field
                    label="First name"
                    v-model="firstname"
                    :rules="firstnameRules"
                    required
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="6" md="6">
                  <v-text-field
                    v-model="lastname"
                    label="Last name"
                    :rules="lastnameRules"
                    required
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="8">
                  <v-text-field
                    v-model="email"
                    label="Email"
                    :rules="emailRules"
                    hint="example@hotmail.com"
                    required
                  ></v-text-field>
                </v-col>

                <v-col cols="12" sm="4">
                  <v-text-field
                    v-model="phoneNumber"
                    :counter="7"
                    :rules="phoneRules"
                    :error-messages="errors"
                    label="Phone Number"
                    required
                  ></v-text-field>
                </v-col>

                <v-col>
                  <v-textarea
                    clearable
                    counter
                    remark="Remind me earlier"
                    v-model="remark"
                    clear-icon="mdi-close-circle"
                    label="Remark(Optional)"
                    :rules="remarkRules"
                  ></v-textarea>
                </v-col>
              </v-row>
            </v-form>

            <v-btn
              :color="continueButtonColor"
              outlined
              @click="validate"
              @click.stop="dialog = true"
            >
              Continue
            </v-btn>
            <v-btn text @click="e6 = 4"> Back </v-btn>
          </v-stepper-content>

          <v-dialog v-model="dialog" persistent max-width="600px">
            <v-card>
              <v-card-title class="grey lighten-4">
                <v-container>
                  <v-icon class="light-green--text"
                    >mdi-check-circle-outline</v-icon
                  >Comfirm your booking
                </v-container>
              </v-card-title>
              <v-card-text>
                <v-container>
                  <v-row no-gutters>
                    <v-col cols="6" md="4">
                      <h5>Branch:</h5>
                    </v-col>
                    <v-col cols="12" sm="6" md="8">
                      <p>{{ selectedBranch.name }}</p>
                    </v-col>
                  </v-row>

                  <v-row no-gutters>
                    <v-col cols="6" md="4">
                      <h5>Date and Time:</h5>
                    </v-col>
                    <v-col cols="12" sm="6" md="8">
                      <p>{{ selectedDate }} {{ selectedTime }}</p>
                    </v-col>
                  </v-row>

                  <v-row no-gutters>
                    <v-col cols="6" md="4">
                      <h5>Total Person:</h5>
                    </v-col>
                    <v-col cols="12" sm="6" md="8">
                      <p>{{ selectedPerson }}</p>
                    </v-col>
                  </v-row>

                  <v-row no-gutters>
                    <v-col cols="6" md="4">
                      <h5>Your Info:</h5>
                    </v-col>
                    <v-col cols="12" sm="6" md="8">
                      <p>
                        {{ firstname }}{{ lastname }}<br />{{ email }}<br />{{
                          phoneNumber
                        }}
                      </p>
                    </v-col>
                  </v-row>

                  <v-row no-gutters>
                    <v-col cols="6" md="4">
                      <h5>Remark:</h5>
                    </v-col>
                    <v-col cols="12" sm="6" md="8">
                      <p>{{ remark }}</p>
                    </v-col>
                  </v-row>
                </v-container>
              </v-card-text>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" text @click="dialog = false">
                  Close
                </v-btn>
                <v-btn
                  color="blue darken-1"
                  text
                  @click="(dialog = false), submit_data"
                >
                  Submit
                </v-btn>
              </v-card-actions>
            </v-card>
          </v-dialog>
        </v-stepper>
      </v-col>

      <v-col cols="12" md="4" class="d-none d-lg-block"></v-col>
    </v-row>

    <v-row class="pt-16">
      <v-col cols="12" md="6" align="center">
        <p :style="{ color: headerTextColor }">
          @2021 |
          <a
            href="https://channelsoft.com.my/"
            style="text-decoration: none"
            :style="{ color: headerTextColor }"
          >
            Channel Soft PLT.
          </a>
        </p>
      </v-col>
    </v-row>
  </div>
</template>

<script>
import Vue from "vue";
import VCalendar from "v-calendar";
import { BASEURL } from "@/api/baseurl";
import axios from "axios";
Vue.use(VCalendar, {
  componentPrefix: "vc", // Use <vc-calendar /> instead of <v-calendar />
  // ...other defaults
});
export default {
  data: () => ({
    domain: BASEURL,
    e6: 1,
    items: [],
    time: [
      { text: "08:00" },
      { text: "08:30" },
      { text: "09:00" },
      { text: "09:30" },
      { text: "10:00" },
      { text: "10:30" },
      { text: "11:00" },
      { text: "11:30" },
      { text: "12:00" },
      { text: "12:30" },
      { text: "13:00" },
      { text: "13:30" },
      { text: "14:00" },
      { text: "14:30" },
      { text: "15:00" },
      { text: "15:30" },
      { text: "16:00" },
      { text: "16:30" },
      { text: "17:00" },
      { text: "17:30" },
      { text: "18:00" },
      { text: "18:30" },
      { text: "19:00" },
      { text: "19:30" },
    ],
    pax: [
      { text: "1-2" },
      { text: "3-4" },
      { text: "5-6" },
      { text: "7-8" },
      { text: "9-10" },
    ],
    dialog: false,
    email: "",
    firstname: "",
    lastname: "",
    phoneNumber: "",
    errors: "",
    selectedTime: true,
    selectedBranch: "",
    selectedPerson: "",
    selectedDate: "",
    remarkRules: [(v) => v.length <= 200 || "Max 30  characters"],
    firstnameRules: [(v) => !!v || "Firstname is required"],
    lastnameRules: [(v) => !!v || "Lastname is required"],
    emailRules: [
      (v) => !!v || "E-mail is required",
      (v) => /.+@.+\..+/.test(v) || "E-mail must be valid",
    ],
    phoneRules: [(v) => !!v || "Phone is required"],
    valid: true,
    remark: "",
    angle: "120",
    color1: "#F9A0FA",
    color2: "#558AE9",
    backgroundHeight: "103%",
    stepButtonColor: "#7E57C2",
    continueButtonColor: "#B39DDB",
    headerTextColor: "#FFFFFF",
    descriptionTextColor: "#E0E0E0",
    modelConfig: {
      type: "string",
      mask: "WWW, MMM D,YYYY", // Uses 'iso' if missing
    },
    company_id: "",
    company_name: "",
    branch_id: "",
    workingDays: '',
    startTime :'',
    endTime :[],
    holiday: [],
    workingTime:'',
    duration:'',
    
    
   
  }),
  computed: {
    createBackgroundString() {
      return `linear-gradient(${this.angle}deg, ${this.color1}, ${this.color2})`;
    },

    weekdays() {
      var value = [];

      if (this.workingDays[0] == 1) {
        value.push(1);
      }
      if (this.workingDays[1] == 1) {
        value.push(2);
      }
      if (this.workingDays[2] == 1) {
        value.push(3);
      }
      if (this.workingDays[3] == 1) {
        value.push(4);
      }
      if (this.workingDays[4] == 1) {
        value.push(5);
      }
      if (this.workingDays[5] == 1) {
        value.push(6);
      }
      if (this.workingDays[6] == 1) {
        value.push(7);
      }

      return value;
    },
    offday(){
      var value=[];
        for (var i = 0; i < this.holiday.length; i++) {
            value.push(' new Date('+(this.holiday[i])+') ');

        }
        
      
        var v = JSON.stringify(value).replaceAll('"', '');
        v=v.replaceAll('[','');
        v=v.replaceAll(']','');
        
      return v;

    },
    // workTime(){
      
        
    //       this.startTime = this.workingTime[0];
    //       this.endTime = this.workingTime[1];
        
      
    //   return this.startTime + ' '+this.endTime;
    // }
    
    
  },
  created() {
    //check form availble
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);

    if (urlParams.has("id")) {
      const id = urlParams.get("id");
      this.company_id = id;
      this.getCompanyName();
      this.getBranchName();
    }
  },
  methods: {
    validate() {
      this.$refs.form.validate();
    },
    getCompanyName() {
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
            this.company_name = response.data.company[0].name;
            this.color1 = JSON.parse(response.data.company[0].color).color1;
            this.color2 = JSON.parse(response.data.company[0].color).color2;
            this.continueButtonColor = JSON.parse(
              response.data.company[0].color
            ).continueButtonColor;
            this.stepButtonColor = JSON.parse(
              response.data.company[0].color
            ).stepButtonColor;
            this.headerTextColor = JSON.parse(
              response.data.company[0].color
            ).headerTextColor;
            this.descriptionTextColor = JSON.parse(
              response.data.company[0].color
            ).descriptionTextColor;
          } else {
            console.log("no company");
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
    getBranchName() {
      const params = new URLSearchParams();
      params.append("read", "done");
      params.append("company_id", this.company_id);

      axios({
        method: "post",
        url: this.domain + "/branch/index.php",
        data: params,
      })
        .then((response) => {
          console.log(response);
          if (response.data.status == "1") {
            this.items = response.data.branch;
          } else {
            console.log("no branch");
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },

    getBranchDateAndTime() {
      for (var i = 0; i < this.items.length; i++) {
        if (this.items[i].branch_id == this.selectedBranch.branch_id) {
          this.workingDays = JSON.parse(this.items[i].working_day);
          this.workingTime = JSON.parse(this.items[i].working_time);
         
        }
      }
    },
    getBranchHoliday() {
      const params = new URLSearchParams();
      params.append("read", "done");
      params.append("branch_id", this.selectedBranch.branch_id);
      axios({
        method: "post",
        url: this.domain + "/holiday/index.php",
        data: params,
      })
        .then((response) => {
          console.log(response);
          if (response.data.status == "1") {
            this.holiday = JSON.parse(response.data.holiday[0].date);
            
    
          } else {
            console.log("no holiday");
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
    getServiceDuration() {
      const params = new URLSearchParams();
      params.append("read", "done");
      params.append("branch_id", this.selectedBranch.branch_id);
      axios({
        method: "post",
        url: this.domain + "/service/index.php",
        data: params,
      })
        .then((response) => {
          console.log(response);
          if (response.data.status == "1") {
            this.duration = JSON.parse(response.data.duration[0]);
            console.log(this.duration);
    
          } else {
            console.log("no service");
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
    
    
  },
};
</script>