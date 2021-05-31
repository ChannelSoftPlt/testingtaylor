<template>
  <v-container id="widgets" fluid>
    <!-- <base-v-component link="components/calendars" /> -->
    <v-row>
      <!-- {{table}}
      {{gap}}
    
     -->
     
     <!-- {{booking}} -->
      <!-- {{booking}}
      {{}} -->

      <v-col cols="12" md="3">
        <v-row class="ml-3">
          <h2>Customer</h2>
        </v-row>
        <v-card height="710px">
          <v-row class="mx-1 mr-2">
            <v-col cols="12">
              <v-text-field
                v-model="searchCustomer"
                label="Search..."
              ></v-text-field>
            </v-col>
            <!-- <v-col cols="3">
        <v-btn outlined  color="grey" small>
        <v-icon>mdi-plus</v-icon>
        </v-btn>   
      </v-col> -->
          </v-row>
          <v-list two-line class="overflow">
            <v-list-item-group
              v-model="selected"
              active-class="pink--text"
              mandatory
            >
              <template>
                <v-list-item
                  v-for="(item, index) in customer"
                  :key="index"
                  :value="item.customer_id"
                >
                  <template>
                    <v-list-item-avatar>
                      <v-avatar color="#2196F3" size="56" class="white--text">
                        {{ item.name[0] }}
                      </v-avatar>
                    </v-list-item-avatar>
                    <v-list-item-content>
                      <v-list-item-title v-text="item.name"></v-list-item-title>
                    </v-list-item-content>
                  </template>
                </v-list-item>
              </template>
            </v-list-item-group>
          </v-list>
        </v-card>
      </v-col>
      <v-col cols="12" md="3">
        <v-row class="ml-3">
          <h2>Customer Details</h2>
        </v-row>
        <v-row>
          <v-col cols="12" class="px-8">
            <v-text-field
              v-model="customerName"
              outlined
              label="Name"
              clearable
            ></v-text-field>
            <v-text-field
              v-model="customerContact"
              outlined
              label="Contact"
              clearable
            ></v-text-field>
            <v-text-field
              v-model="customerEmail"
              outlined
              label="Email"
              clearable
            ></v-text-field>
          </v-col>
        </v-row>
        <v-row>
          <v-col class="text-center ml-4">
            <v-btn color="success" @click="updateCustomerDetail()">
              Save
            </v-btn>
            <v-snackbar v-model="snackbar" :timeout="timeout">
              {{ text }}

              <template v-slot:action="{ attrs }">
                <v-btn
                  color="blue"
                  text
                  icon
                  v-bind="attrs"
                  @click="snackbar = false"
                >
                  <v-icon>mdi-close</v-icon>
                </v-btn>
              </template>
            </v-snackbar>

            <v-btn color="error" @click.stop="confirmDeleteDialog = true">
              Delete
            </v-btn>
            <v-dialog v-model="confirmDeleteDialog" max-width="290">
              <v-card>
                <v-card-title> Are you confirm to delete? </v-card-title>

                <v-card-text>
                  <span class="font-weight-medium"
                    >All the appointment and customer detail will be delete
                    too</span
                  >
                </v-card-text>

                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn
                    color="red darken-1"
                    text
                    @click="confirmDeleteDialog = false"
                  >
                    cancel
                  </v-btn>

                  <v-btn
                    color="green darken-1"
                    text
                    @click="deleteCustomerAndBooking()"
                  >
                    Agree
                  </v-btn>
                  <v-spacer></v-spacer>
                </v-card-actions>
              </v-card>
            </v-dialog>
          </v-col>
        </v-row>
      </v-col>
      <v-col cols="12" md="4">
        <v-row class="ml-3">
          <h2>Appointment</h2>
        </v-row>
        <v-card color="grey lighten-4" v-if="appointmentList != ''">
          <v-row>
            <v-col class="px-8">
              <v-list two-line color="grey lighten-4">
                <template>
                  <v-list-item
                    v-for="(item, index) in appointmentList"
                    :key="index"
                  >
                    <v-list-item-content>
                      <v-list-item-title
                        ><b class="font-weight-black">Total Person: </b
                        ><span class="font-weight-medium">{{
                          item.person
                        }}</span></v-list-item-title
                      >
                      <v-list-item-subtitle>
                        <b class="font-weight-black"
                          >{{ item.selected_date }} {{ item.selected_time }}</b
                        ></v-list-item-subtitle
                      >
                      <v-list-item-subtitle
                        ><b class="font-weight-bold"
                          >Branch: {{ item.name }}</b
                        ></v-list-item-subtitle
                      >
                      <v-list-item-subtitle
                        ><b class="font-weight-bold"
                          >Note: {{ item.remark }}</b
                        ></v-list-item-subtitle
                      >
                    </v-list-item-content>

                    <v-list-item-action>
                      <v-dialog v-model="dialog" width="500">
                        <template v-slot:activator="{ on, attrs }">
                          <v-btn
                            v-bind="attrs"
                            v-on="on"
                            text
                            icon
                            color="secondary"
                            v-model="selectedAppointment"
                            @click="
                              (selectedAppointment = item.booking_id),
                                getAppointmentForUpdate()
                            "
                          >
                            <v-icon>mdi-pencil</v-icon>
                          </v-btn>
                        </template>
                        <template v-slot:default="dialog">
                          <v-card>
                            <v-toolbar color="indigo" dark
                              >Edit appointment</v-toolbar
                            >
                            <v-card-text>

                              <v-row class="mt-2">
                                <v-col cols="12">
                                  <v-select
                                    :items="branchItem"
                                    v-model="editBranch"
                                    item-text="name"
                                    item-value="branch_id"
                                    label="Branch"
                                    prepend-icon="mdi-store"
                                  ></v-select>
                                </v-col>
                                <v-col cols="12">
                                  <v-text-field
                                    v-model="editPerson"
                                    min="1"
                                    :max="maxPerson"
                                    type="number"
                                    oninput="if(Number(this.value) > Number(this.max)) this.value = this.max; "
                                    label="Total Person"
                                    prepend-icon="mdi-account"
                                  ></v-text-field>
                                </v-col>
                                <v-col cols="12" sm="6" md="6">
                                  <v-menu
                                    ref="menu"
                                    v-model="menu"
                                    :close-on-content-click="false"
                                    :return-value.sync="date"
                                    transition="scale-transition"
                                    offset-y
                                    min-width="auto"
                                  >
                                    <template v-slot:activator="{ on, attrs }">
                                      <v-text-field
                                        v-model="editDate"
                                        label="Choose your date"
                                        prepend-icon="mdi-calendar"
                                        readonly
                                        v-bind="attrs"
                                        v-on="on"
                                      ></v-text-field>
                                    </template>
                                    <FunctionalCalendar
                                      v-model="editCustomerDate"
                                      :limits="{
                                        min: today,
                                        max: '01/01/3000',
                                      }"
                                      :disabledDates="branchHoliday"
                                      :disabled-day-names="weekdays"
                                      :hidden-elements="['leftAndRightDays']"
                                      :is-date-picker="true"
                                      v-on:choseDay="
                                        editDate = editCustomerDate.selectedDate
                                        
                                      "
                                      v-if="isReset"
                                    >
                                    </FunctionalCalendar>
                                  </v-menu>
                                </v-col>
                                <v-col cols="12" sm="6" md="6">
                                  <v-select
                                    :items="timesPlusDuration"
                                    v-model="editTime"
                                    label="Pick your time"
                                    prepend-icon="mdi-clock"
                                    single-line
                                    v-if="isResets"
                                  ></v-select>
                                </v-col>
                                <v-col cols="12">
                                  <v-textarea
                                    v-model="editRemark"
                                    label="Customer Remark"
                                    rows="5"
                                    prepend-icon="mdi-comment"
                                  ></v-textarea>
                                </v-col>
                              </v-row>
                            </v-card-text>
                            <v-card-actions class="justify-end">
                              <v-btn
                                color="blue darken-1"
                                text
                                @click="dialog.value = false"
                              >
                                Close
                              </v-btn>
                              <v-btn
                                color="blue darken-1"
                                text
                                @click="
                                  editAppointment(), (dialog.value = false)
                                "
                              >
                                Save
                              </v-btn>
                            </v-card-actions>
                          </v-card>
                        </template>
                      </v-dialog>
                    </v-list-item-action>
                  </v-list-item>

                  <!-- <v-divider
            v-if="index < appointmentList.length - 1"
            :key="index"
          ></v-divider> -->
                </template>
              </v-list>
            </v-col>
          </v-row>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
// Components
// import PagesPlanCard from '@/views/pages/components/PlanCard'
import { BASEURL } from "@/api/baseurl";
import axios from "axios";
import { FunctionalCalendar } from "vue-functional-calendar";

export default {
  name: "Widgets",

  components: {
    // PagesPlanCard
    FunctionalCalendar,
  },

  data: () => ({
    domain: BASEURL,
    color: "#2196F3",
    appointmentList: [],
    company_id: "",
    customer: [],
    selected: "",
    customerName: "",
    customerContact: "",
    customerEmail: "",
    searchCustomer: "",
    snackbar: false,
    text: "",
    timeout: 2000,
    confirmDeleteDialog: false,
    selectedAppointment: "true",
    dialog: "",
    menu: false,
    date: "",
    editBranch: "",
    editPerson: "",
    editDate: "",
    editTime: "",
    editRemark: "",
    editCustomerDate: {},
    branchItem: [],
    maxPerson: "",
    branchHoliday: "",
    branchWorkingTime: "",
    workingDays: "",
    gap: "",
    table: "",
    serviceDuration: "",
    serviceID: "",
    slot: "",
    timesPlusDuration: [],
    booking: "",
    isReset: true,
    isResets: true,
  }),
  created() {
    //check form availble
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);

    if (urlParams.has("id")) {
      const id = urlParams.get("id");
      this.company_id = id;
      this.getAllCustomer();
      this.getCompanyBranch();
    }
  },

  watch: {
    selected() {
      this.getCustomerDetail();
      this.getCustomerAppointment();
    },
    searchCustomer() {
      this.searchCustomerByName();
    },
    editBranch() {
      this.isReset = false;
      this.getBranchWorkDayAndTime();
      this.findMaxPerson();
      this.getService();
      this.$nextTick(() => {
        this.isReset = true;
      });
    },
    editPerson() {
      this.getService();
    },
    
  },
  computed: {
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
    weekdays() {
      var value = [];

      if (this.workingDays[0] == 1) {
        value.push("Su");
      }
      if (this.workingDays[1] == 1) {
        value.push("Mo");
      }
      if (this.workingDays[2] == 1) {
        value.push("Tu");
      }
      if (this.workingDays[3] == 1) {
        value.push("We");
      }
      if (this.workingDays[4] == 1) {
        value.push("Th");
      }
      if (this.workingDays[5] == 1) {
        value.push("Fr");
      }
      if (this.workingDays[6] == 1) {
        value.push("Sa");
      }

      return value;
    },
    timeSession() {
      var moment = require("moment"); // require
      moment().format();
      var currentTime = moment(new Date(), "hmm").format("HH:mm");
      var currentDay = moment(new Date(), "ddmmyy").format("D/M/YYYY");
      var startTime = this.branchWorkingTime[0];
      var interval = this.gap;
      var times = [];
      var period = "m";
      var periodsInADay = moment.duration(1, "day").as(period);
      var startTimeMoment = moment(startTime, "HH:mm");
      var endTime = this.branchWorkingTime[1];
      var endTimeMoment = moment(endTime, "HH:mm");

      for (let i = 0; i <= periodsInADay; i++) {
        var time = startTimeMoment.add(i === 0 ? 0 : interval, period);
        if (this.selectedDate == currentDay) {
          if (time.format("HH:mm") > currentTime && time <= endTimeMoment) {
            times.push(time.format("HH:mm"));
          }
        } else {
          if (time <= endTimeMoment) {
            times.push(time.format("HH:mm"));
          }
        }
      }

      return times;
    },
  },
  methods: {
    getAllCustomer() {
      const params = new URLSearchParams();
      params.append("getAllCustomer", "done");
      params.append("company_id", this.company_id);

      axios({
        method: "post",
        url: this.domain + "/customer/index.php",
        data: params,
      })
        .then((response) => {
          console.log(response);
          if (response.data.status == "1") {
            this.customer = response.data.customer;
          } else {
            console.log("no customer found on this company");
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
    searchCustomerByName() {
      const params = new URLSearchParams();
      params.append("searchCustomerByName", "done");
      params.append("company_id", this.company_id);
      params.append("search_customer", this.searchCustomer);

      axios({
        method: "post",
        url: this.domain + "/customer/index.php",
        data: params,
      })
        .then((response) => {
          console.log(response);
          if (response.data.status == "1") {
            this.customer = response.data.customer;
          } else {
            console.log("no customer found on this company");
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },

    getCustomerDetail() {
      for (let i = 0; i < this.customer.length; i++) {
        if (this.customer[i].customer_id == this.selected) {
          this.customerName = this.customer[i].name;
          this.customerContact = this.customer[i].contact;
          this.customerEmail = this.customer[i].email;
        }
      }
    },

    getCustomerAppointment() {
      const params = new URLSearchParams();
      params.append("getCustomerAppointment", "done");
      params.append("customer_id", this.selected);

      axios({
        method: "post",
        url: this.domain + "/booking/index.php",
        data: params,
      })
        .then((response) => {
          console.log(response);
          if (response.data.status == "1") {
            this.appointmentList = response.data.booking;
          } else {
            console.log("no customer found on this company");
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },

    updateCustomerDetail() {
      const params = new URLSearchParams();
      params.append("update", "done");
      params.append("customer_id", this.selected);
      params.append("name", this.customerName);
      params.append("contact", this.customerContact);
      params.append("email", this.customerEmail);

      axios({
        method: "post",
        url: this.domain + "/customer/index.php",
        data: params,
      })
        .then((response) => {
          console.log(response);
          if (response.data.status == "1") {
            this.snackbar = true;
            this.text = "Update Successful";
            this.getAllCustomer();
          } else {
            console.log("update fail");
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },

    deleteCustomerAndBooking() {
      const params = new URLSearchParams();
      params.append("delete", "done");
      params.append("customer_id", this.selected);

      axios({
        method: "post",
        url: this.domain + "/customer/index.php",
        data: params,
      })
        .then((response) => {
          console.log(response);
          if (response.data.status == "1") {
            this.confirmDeleteDialog = false;
            this.snackbar = true;
            this.text = "Delete Successful";
            this.getAllCustomer();
          } else {
            console.log("Something went wrong");
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
    editAppointment() {
      const params = new URLSearchParams();
      params.append("updateBooking", "done");
      params.append("booking_id", this.selectedAppointment);

      axios({
        method: "post",
        url: this.domain + "/booking/index.php",
        data: params,
      })
        .then((response) => {
          console.log(response);
          if (response.data.status == "1") {
            console.log("hahahahahahah");
          } else {
            console.log("Something went wrong");
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
    getCompanyBranch() {
      const params = new URLSearchParams();
      params.append("getHolidayDayTime", "done");
      params.append("company_id", this.company_id);

      axios({
        method: "post",
        url: this.domain + "/branch/index.php",
        data: params,
      })
        .then((response) => {
          console.log(response);
          if (response.data.status == "1") {
            this.branchItem = response.data.branch;
          } else {
            console.log("no branch find");
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
    findMaxPerson() {
      const params = new URLSearchParams();
      params.append("findMaxPerson", "done");
      params.append("branch_id", this.editBranch);

      axios({
        method: "post",
        url: this.domain + "/service/index.php",
        data: params,
      })
        .then((response) => {
          console.log(response);
          if (response.data.status == "1") {
            this.maxPerson = response.data.service[0].seat;
          } else {
            console.log("Booking failed");
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
    getBranchWorkDayAndTime() {
      for (var i = 0; i < this.branchItem.length; i++) {
        if (this.branchItem[i].branch_id === this.editBranch) {
          this.workingDays = JSON.parse(this.branchItem[i].working_day);
          this.branchWorkingTime = JSON.parse(this.branchItem[i].working_time);
          this.gap = JSON.parse(this.branchItem[i].gap);
          this.branchHoliday = JSON.parse(this.branchItem[i].date);
        }
      }
    },

    getService() {
      const params = new URLSearchParams();
      params.append("read", "done");
      params.append("branch_id", this.editBranch);
      params.append("seat", this.editPerson);
      axios({
        method: "post",
        url: this.domain + "/service/index.php",
        data: params,
      })
        .then((response) => {
          console.log(response);
          if (response.data.status == "1") {
            this.table = response.data.service[0];
            this.serviceID = this.table.service_id;
            this.serviceDuration = this.table.duration;
            this.slot = this.table.slot;
            this.getBooking();
          } else {
            console.log("no service");
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },

    getBooking() {
      const params = new URLSearchParams();
      params.append("read", "done");
      params.append("selected_date", this.editDate);
      params.append("service_id", this.serviceID);
      params.append("booking_id", this.selectedAppointment);

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
    getAppointmentForUpdate() {
      for (var i = 0; i < this.appointmentList.length; i++) {
        if (this.appointmentList[i].booking_id == this.selectedAppointment) {
          this.editBranch = this.appointmentList[i].branch_id;
          this.editPerson = this.appointmentList[i].person;
          this.editDate = this.appointmentList[i].selected_date;
          this.editTime = this.appointmentList[i].selected_time;
          this.editRemark = this.appointmentList[i].remark;
        }
      }
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
      console.log;
    },
  },
};
</script>
<style>
.v-card {
  display: flex !important;
  flex-direction: column;
}

.overflow {
  flex-grow: 100;
  overflow: auto;
}
</style>
