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
      <v-col cols="12" md="4" class="d-none d-md-block"></v-col>
      <v-col cols="12" md="4" align="center">
        <h2 :style="{ color: headerTextColor }">Book Appointment Now!</h2>
        <p class="px-7">
          <span :style="{ color: descriptionTextColor }"
            >Make an appointment with us now to save your time
          </span>
        </p>
      </v-col>
      <v-col cols="12" md="4" class="d-none d-lg-block"></v-col>
    </v-row>
    <v-snackbar
      :timeout="timeout"
      :value="snackbar"
      fixed
      center
      shaped
      :color="stepButtonColor"
    >
      Booked successfully!
      <template v-slot:action="{ attrs }">
        <v-btn color="blue" text v-bind="attrs" @click="snackbar = false">
          <v-icon> mdi-close </v-icon>
        </v-btn>
      </template>
    </v-snackbar>
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
              :loading="branchLoading"
              v-model="selectedBranch"
              @change="
                (branchLoading = true), getBranchDateAndTime(), findAllService()
              "
              return-object
            >
            </v-select>
          </v-stepper-content>

          <v-stepper-step :complete="e6 > 2" step="2" :color="stepButtonColor">
            Choose Your Service
          </v-stepper-step>

          <v-stepper-content step="2">
            <v-list shaped>
              <v-list-item-group v-model="selectedService" color="primary">
                <v-list-item
                  v-for="(item, i) in allService"
                  :key="i"
                  :value="item.service_id"
                  @click="(selectedService = 'value'), (e6 = 3)"
                >
                  <v-list-item-content>
                    <v-list-item-title v-text="item.title"></v-list-item-title>
                    <v-list-item-subtitle
                      v-text="item.description"
                    ></v-list-item-subtitle>
                    <v-list-item-subtitle
                      v-text="item.duration + ' minit'"
                    ></v-list-item-subtitle>
                  </v-list-item-content>
                </v-list-item>
              </v-list-item-group>
            </v-list>

            <v-btn :color="continueButtonColor" outlined text @click="e6 = 1">
              Back
            </v-btn>
          </v-stepper-content>

          <v-stepper-step :complete="e6 > 3" step="3" :color="stepButtonColor">
            Choose Provider
          </v-stepper-step>

          <v-stepper-content step="3">
            <v-list shaped>
              <v-list-item-group v-model="selectedProvider" color="primary">
                <v-list-item
                  v-for="(item, i) in allProvider"
                  :key="i"
                  :value="item.provider_id"
                  @click="e6 = 4"
                >
                  <v-list-item-content>
                    <v-list-item-title v-text="item.name"></v-list-item-title>
                    <v-list-item-subtitle
                      v-text="item.staff_description"
                    ></v-list-item-subtitle>
                  </v-list-item-content>
                </v-list-item>
              </v-list-item-group>
            </v-list>

            <v-btn :color="continueButtonColor" outlined text @click="e6 = 2">
              Back
            </v-btn>
          </v-stepper-content>

          <v-stepper-step :complete="e6 > 4" step="4" :color="stepButtonColor">
            Choose Date and time
          </v-stepper-step>
          <v-stepper-content step="4">
            <v-row class="mt-2">
              <v-col cols="12">
                <div class="text-center">
                  <v-progress-circular
                    :size="50"
                    color="primary"
                    indeterminate
                    v-if="calendarCheck"
                  ></v-progress-circular>
                </div>
                <FunctionalCalendar
                  v-model="selectedDated"
                  :disabled-day-names="weekdays"
                  :disabledDates="offday"
                  :limits="{ min: today, max: '01/01/2200' }"
                  :date-format="'dd/mm/yyyy'"
                  v-if="check && selectedProvider"
                  :hidden-elements="['leftAndRightDays']"
                  :is-date-picker="true"
                  class="elevation-0"
                  v-on:choseDay="this.getBooking"
                ></FunctionalCalendar>
              </v-col>
            </v-row>
            <div class="d-flex justify-center mt-16">
              <v-progress-circular
                :size="50"
                :color="stepButtonColor"
                indeterminate
                v-if="showTime"
              ></v-progress-circular>
            </div>
            <v-row
              class="mb-2"
              v-if="
                selectedService &&
                selectedProvider &&
                selectedDated.selectedDate &&
                this.showTime == false
              "
            >
              <v-col cols="4" sm="12">
                <p>Morning</p>
                <v-row>
                  <div v-for="(time, i) in timesPlusDuration" :key="i">
                    <v-btn
                      class="mb-2 mt-1 mr-1 ml-3"
                      outlined
                      color="indigo"
                      small
                      v-model="selectedTime"
                      @click="
                        selectedTime = time;
                        personInput = true;
                        e6 = 5;
                      "
                      v-if="parseFloat(time.substring(0, 2)) < 12"
                    >
                      {{ time }}
                    </v-btn>
                  </div>
                </v-row>
              </v-col>
              <v-col cols="4" sm="12">
                <p>Noon</p>
                <v-row>
                  <div v-for="(time, i) in timesPlusDuration" :key="i">
                    <v-btn
                      class="mb-2 mt-1 mr-1 ml-3"
                      outlined
                      color="indigo"
                      small
                      v-model="selectedTime"
                      @click="
                        selectedTime = time;
                        personInput = true;
                        e6 = 5;
                      "
                      v-if="
                        parseFloat(time.substring(0, 2)) >= 12 &&
                        parseFloat(time.substring(0, 2)) <= 18
                      "
                    >
                      {{ time }}
                    </v-btn>
                  </div>
                </v-row>
              </v-col>
              <v-col cols="4" sm="12">
                <p>Night</p>
                <v-row>
                  <div v-for="(time, i) in timesPlusDuration" :key="i">
                    <v-btn
                      class="mb-2 mt-1 mr-1 ml-3"
                      outlined
                      color="indigo"
                      small
                      v-model="selectedTime"
                      @click="
                        selectedTime = time;
                        personInput = true;
                        e6 = 5;
                      "
                      v-if="parseFloat(time.substring(0, 2)) > 18"
                    >
                      {{ time }}
                    </v-btn>
                  </div>
                </v-row>
              </v-col>
            </v-row>

            <br />
            <br />

            <v-btn
              text
              :color="continueButtonColor"
              outlined
              @click="(selectedProvider =''),selectedDated ='', (e6 = 3)"
            >
              Back
            </v-btn>
          </v-stepper-content>

          <v-stepper-step :complete="e6 > 5" step="5" :color="stepButtonColor">
            Your info
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
                <v-col cols="12" sm="12">
                  <v-text-field
                    v-model="email"
                    label="Email"
                    :rules="emailRules"
                    hint="example@hotmail.com"
                    required
                  ></v-text-field>
                </v-col>

                <v-col cols="12" sm="12">
                  <vue-phone-number-input
                    size="sm"
                    default-country-code="MY"
                    v-model="phoneNumber"
                    :rules="phoneRules"
                    :error="checkTelInput"
                    valid-color="#919191"
                    @update="results = $event"
                  ></vue-phone-number-input>
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

            <v-btn :color="continueButtonColor" outlined @click="validate()">
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
                      <p>{{ selectedDated.selectedDate }},{{ selectedTime }}</p>
                    </v-col>
                  </v-row>

                  <v-row no-gutters>
                    <v-col cols="6" md="4">
                      <h5>Service:</h5>
                    </v-col>
                    <v-col cols="12" sm="6" md="8">
                      <p>{{ serviceName }}</p>
                    </v-col>
                  </v-row>

                   <v-row no-gutters>
                    <v-col cols="6" md="4">
                      <h5>Service Provider:</h5>
                    </v-col>
                    <v-col cols="12" sm="6" md="8">
                      <p>{{ providerName }}</p>
                    </v-col>
                  </v-row>

                  <v-row no-gutters>
                    <v-col cols="6" md="4">
                      <h5>Your Info:</h5>
                    </v-col>
                    <v-col cols="12" sm="6" md="8">
                      <p>
                        {{ firstname }} {{ lastname }}<br />{{ email }}<br />{{
                          phoneNumber
                        }}
                      </p>
                    </v-col>
                  </v-row>

                  <v-row
                    no-gutters
                    v-if="remark == '' ? (remark = 'none') : remark"
                  >
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
                  @click="(dialog = false), createCustomer()"
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
import { BASEURL } from "@/api/baseurl";
import axios from "axios";
import FunctionalCalendar from "vue-functional-calendar";
import VuePhoneNumberInput from "vue-phone-number-input";
import "vue-phone-number-input/dist/vue-phone-number-input.css";

Vue.component("vue-phone-number-input", VuePhoneNumberInput);

Vue.use(FunctionalCalendar, {
  dayNames: ["Mo", "Tu", "We", "Th", "Fr", "Sa", "Su"],
  isAutoCloseable: true,
});

export default {
  data: () => ({
    domain: BASEURL,
    e6: 1,
    items: [],
    dialog: false,
    email: "",
    firstname: "",
    lastname: "",
    phoneNumber: "",
    errors: "",
    selectedTime: true,
    selectedBranch: "",
    selectedPerson: "",
    selectedDated: "",
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
    color1: "",
    color2: "",
    backgroundHeight: "103%",
    stepButtonColor: "",
    continueButtonColor: "",
    headerTextColor: "",
    descriptionTextColor: "",
    company_id: "",
    company_name: "",
    branch_id: "",
    workingDays: "",
    holiday: [],
    workingTime: "",
    branchLoading: false,
    table: [],
    check: false,
    serviceID: "",
    booking: [],
    serviceDuration: "",
    slot: "",
    customerID: "",
    contact: "",
    results: "",
    checkTelInput: false,
    maxPerson: "",
    showTime: false,
    timeout: 2000,
    snackbar: false,
    timesPlusDuration: [],
    allService: [],
    selectedService: "",
    checkbox: false,
    serviceName: "",
    personInput: false,
    serviceDescription: "",
    merchantPhone: "",
    whatsappRedirect: 0,
    bookingID: "",
    allProvider: [],
    selectedProvider: "",
    providerWorkDay: [],
    providerWorkTime: [],
    providerBreakTime: [],
    calendarCheck: false,
    providerName:'',
  }),
  computed: {
    createBackgroundString() {
      return `linear-gradient(${this.angle}deg, ${this.color1}, ${this.color2})`;
    },
    progress() {
      return Math.min(100, this.value.length * 10);
    },
    color() {
      return ["error", "warning", "success"][Math.floor(this.progress / 40)];
    },
    weekdays() {
      var value = [];
      if (this.workingDays[0] == 1 || this.providerWorkDay[0] == 1) {
        value.push("Su");
      }
      if (this.workingDays[1] == 1 || this.providerWorkDay[1] == 1) {
        value.push("Mo");
      }
      if (this.workingDays[2] == 1 || this.providerWorkDay[2] == 1) {
        value.push("Tu");
      }
      if (this.workingDays[3] == 1 || this.providerWorkDay[3] == 1) {
        value.push("We");
      }
      if (this.workingDays[4] == 1 || this.providerWorkDay[4] == 1) {
        value.push("Th");
      }
      if (this.workingDays[5] == 1 || this.providerWorkDay[5] == 1) {
        value.push("Fr");
      }
      if (this.workingDays[6] == 1 || this.providerWorkDay[6] == 1) {
        value.push("Sa");
      }

      

      return value;
    },
    offday() {
      var value = [];
      for (var i = 0; i < this.holiday.length; i++) {
        value.push(this.holiday[i]);
      }
      return value;
    },
    start() {
      var start = JSON.stringify(this.workingTime[0]);

      return start;
    },
    end() {
      var end = this.workingTime[1];

      return end;
    },
    today() {
      var d = new Date();
      var datestring =
        ("0" + d.getDate()).slice(-2) +
        "/" +
        ("0" + (d.getMonth() + 1)).slice(-2) +
        "/" +
        d.getFullYear();
      return datestring;
    },
    timeSession() {
      this.setShowTimeToTrue();
      var moment = require("moment"); // require
      moment().format();
      var currentTime = moment(new Date(), "hmm").format("HH:mm");
      var currentDay = moment(new Date(), "ddmmyy").format("D/M/YYYY");
      var startTime ='';
      var endTime = '';
      var breakStartTime = this.providerBreakTime[0];
      var breakEndTime = this.providerBreakTime[1];
      if (this.selectedProvider != "") {
         startTime = this.providerWorkTime[0];
         endTime = this.providerWorkTime[1];
      } else {
         startTime = this.start;
         endTime = this.end;
      }
      var breakStartTimeMoment = moment(breakStartTime, "HH:mm");
      var breakEndTimeMoment = moment(breakEndTime, "HH:mm");

      var interval = this.gap;
      var firstSession = [];
      var secondSession = [];
      var times = [];
      var period = "m";
      var periodsInADay = moment.duration(1, "day").as(period);
      var startTimeMoment = moment(startTime, "HH:mm");
      var endTimeMoment = moment(endTime, "HH:mm");

      for (let i = 0; i <= periodsInADay; i += interval) {
        var time = startTimeMoment.add(i === 0 ? 0 : interval, period);

        if (this.selectedDated.selectedDate == currentDay) {
          if (time.format("HH:mm") > currentTime && time <= endTimeMoment) {
            if (time <= breakStartTimeMoment) {
              firstSession.push(time.format("HH:mm"));
            }
            if (time >= breakEndTimeMoment) {
              secondSession.push(time.format("HH:mm"));
            }
            times = firstSession.concat(secondSession);
          }
        } else {
          if (time <= endTimeMoment) {
            if (time < breakStartTimeMoment) {
              firstSession.push(time.format("HH:mm"));
            }
            if (time >= breakEndTimeMoment) {
              secondSession.push(time.format("HH:mm"));
            }
            times = firstSession.concat(secondSession);
          }
        }
      }

      return times;
    },
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
  watch: {
    selectedService() {
      this.getSelectedService();
    },
    selectedProvider() {
      this.getProviderInfo();
    },

    phoneNumber() {
      if (this.results.isValid == true) {
        this.checkTelInput = false;
      } else if (this.results.isValid == false) {
        this.checkTelInput = true;
      }
    },
  },
  methods: {
    validate() {
      var mailformat = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
      if (
        this.firstname != "" &&
        this.lastname != "" &&
        this.phoneNumber != "" &&
        this.email != "" &&
        this.results.isValid == true &&
        this.email.match(mailformat)
      ) {
        this.dialog = true;
      } else if (this.results.isValid == true) {
        this.checkTelInput = false;
      } else {
        this.$refs.form.validate();
        this.checkTelInput = true;
      }
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
      this.check = false;
      for (var i = 0; i < this.items.length; i++) {
        if (this.items[i].branch_id == this.selectedBranch.branch_id) {
          this.workingDays = JSON.parse(this.items[i].working_day);
          this.workingTime = JSON.parse(this.items[i].working_time);
          this.gap = JSON.parse(this.items[i].gap);
          this.merchantPhone = this.items[i].phone_number;
          this.whatsappRedirect = this.items[i].redirect;
        }
      }
      this.getBranchHoliday();
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
            this.check = true;
            this.e6 = 2;
            this.branchLoading = false;
          } else {
            console.log("no holiday");
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },

    getBooking() {
      const params = new URLSearchParams();
      params.append("getBooking", "done");
      params.append("selected_date", this.selectedDated.selectedDate);
      params.append("service_id", this.selectedService);
      params.append("provider_id", this.selectedProvider);
      axios({
        method: "post",
        url: this.domain + "/booking/index.php",
        data: params,
      })
        .then((response) => {
          console.log(response);
          if (response.data.status == "1") {
            this.booking = response.data.booking;
            this.finalTime();
          } else {
            console.log("no booking");
            this.booking = [];
            this.finalTime();
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
    createCustomer() {
      const params = new URLSearchParams();
      params.append("create", "done");
      params.append("name", this.firstname + " " + this.lastname);
      params.append("contact", this.results.formattedNumber);
      params.append("email", this.email);
      params.append("remark", this.remark);

      axios({
        method: "post",
        url: this.domain + "/customer/index.php",
        data: params,
      })
        .then((response) => {
          console.log(response);
          if (response.data.status == "1") {
            console.log("Add customer successfully");
            this.customerID = response.data.customer;
            this.createBooking();
          } else {
            console.log("Please check again your info");
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
    createBooking() {
      const params = new URLSearchParams();
      params.append("createBooking", "done");
      params.append("service_id", this.selectedService);
      params.append("selected_time", this.selectedTime);
      params.append("duration", this.serviceDuration);
      params.append("service_title", this.serviceName);
      params.append("service_description", this.serviceDescription);
      params.append("selected_date", this.selectedDated.selectedDate);
      params.append("person", this.selectedPerson);
      params.append("customer_id", this.customerID);
      params.append("provider_id", this.selectedProvider);

      axios({
        method: "post",
        url: this.domain + "/booking/index.php",
        data: params,
      })
        .then((response) => {
          console.log(response);
          if (response.data.status == "1") {
            console.log("Booking successfully");
            this.bookingID = response.data.booking;
            this.whatsappMerchant();
          } else {
            console.log("Booking failed");
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
    setShowTimeToTrue() {
      this.showTime = true;
    },
    setShowTimeToFalse() {
      this.showTime = false;
    },
    finalTime() {
      var moment = require("moment"); // require
      moment().format();
      var duration = this.serviceDuration;
      this.timesPlusDuration = [];
      var first = this.timeSession;
      var period = "m";
      // var second = [];
      for (let i = 0; i < first.length; i++) {
        var start = moment(first[i], "HH:mm");
        var s = moment(first[i], "HH:mm");
        var end = s.add(duration, period);
        var slot = 0;
        for (let j = 0; j < this.booking.length; j++) {
          var bookingStart = moment(this.booking[j].selected_time, "HH:mm");
          var bookings = moment(this.booking[j].selected_time, "HH:mm");
          var bookingEnd = bookings.add(this.booking[j].duration, period);

          if (bookingStart >= start && bookingStart < end) {
            slot += 1;
            continue;
          }
          if (bookingEnd > start && bookingEnd <= end) {
            slot += 1;

            continue;
          }
          if (bookingStart < start && bookingEnd > end) {
            slot += 1;

            continue;
          }
        }

        if (slot < this.slot) {
          this.timesPlusDuration.push(start.format("HH:mm"));
        }
      }
      this.setShowTimeToFalse();
    },
    findAllService() {
      const params = new URLSearchParams();
      params.append("findAllService", "done");
      params.append("branch_id", this.selectedBranch.branch_id);

      axios({
        method: "post",
        url: this.domain + "/service/index.php",
        data: params,
      })
        .then((response) => {
          console.log(response);
          if (response.data.status == "1") {
            this.allService = response.data.service;
          } else {
            console.log("no service found");
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
    getSelectedService() {
      const params = new URLSearchParams();
      params.append("getSelectedService", "done");
      params.append("service_id", this.selectedService);

      axios({
        method: "post",
        url: this.domain + "/service/index.php",
        data: params,
      })
        .then((response) => {
          console.log(response);
          if (response.data.status == "1") {
            this.serviceDuration = JSON.parse(
              response.data.service[0].duration
            );
            
            this.serviceName = response.data.service[0].title;
            this.serviceDescription = response.data.service[0].description;
            this.getAllProvider();
          } else {
            console.log("something went wrong");
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
    // clear() {
    //   this.selectedService = null;
    //   this.selectedProvider = null;
    // },
    whatsappMerchant() {
      if (this.whatsappRedirect == 1) {
        window.location.href =
          "https://api.whatsapp.com/send?phone=" +
          this.merchantPhone +
          "&text=My%20Appointment%20ID:%20" +
          this.bookingID +
          "%0AName:%20" +
          this.firstname +
          "%20" +
          this.lastname +
          "%0ADate:%20" +
          this.selectedDated.selectedDate +
          "%0ATime:%20" +
          this.selectedTime +
          "%0ARemark:%20" +
          this.remark +
          "%0A" +
          this.domain;
      } else if (this.whatsappRedirect == 0) {
        this.snackbar = true;
        this.e6 = 1;
      }
    },
    getAllProvider() {
      this.allProvider = [];
      const params = new URLSearchParams();
      params.append("getAllProvider", "done");
      params.append("service_id", this.selectedService);

      axios({
        method: "post",
        url: this.domain + "/provider/index.php",
        data: params,
      })
        .then((response) => {
          console.log(response);
          if (response.data.status == "1") {
            this.allProvider = response.data.provider;
          } else {
            console.log("no provider found");
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
    getProviderInfo() {
      for (var i = 0; i < this.allProvider.length; i++) {
        if (this.allProvider[i].provider_id == this.selectedProvider) {
          this.providerWorkDay = JSON.parse(this.allProvider[i].work_day);
          this.providerWorkTime = JSON.parse(this.allProvider[i].work_time);
          this.providerBreakTime = JSON.parse(this.allProvider[i].break_time);
          this.slot = JSON.parse(this.allProvider[i].slot);
          this.providerName = this.allProvider[i].name;
        }
      }
    },
  },
};
</script>
<style lang="postcss">
.vfc-week .vfc-day span.vfc-span-day.vfc-cursor-not-allowed {
  pointer-events: none !important;
}
.vfc-single-input {
  padding: 7px !important;
  width: 100% !important;
  color: #9b9b9b !important;
}

.v-application--is-ltr .v-list.v-sheet--shaped {
  background-color: transparent !important;
}
</style>