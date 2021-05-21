<template>
  <v-container id="calendar" fluid tag="section">
    <base-v-component heading="Appointment" link="components/calendars" />

    <v-row>
      <v-col cols="12" md="10" class="mx-auto">
        <v-card>
          <v-sheet height="64">
            <v-toolbar flat>
              <v-menu bottom right>
                <template v-slot:activator="{ on, attrs }">
                  <v-btn
                    outlined
                    color="grey darken-2"
                    v-bind="attrs"
                    v-on="on"
                    
                    
                  >
                    <span class="d-md-flex d-none">{{branchName}}</span>
                    <span class="d-sm-flex d-md-none text-truncate " style="max-width:30px;">{{ branchName }}</span>
                    <v-icon right> mdi-menu-down </v-icon>
                  </v-btn>
                </template>
                <v-list shaped>
                  <v-list-item-group
                    v-model="selectedBranch"
                    color="primary"
                    mandatory
                  >
                    <v-list-item value="all">All</v-list-item>
                    <v-list-item
                      v-for="(item, index) in branchItem"
                      :key="index"
                      :value="item.branch_id"
                    >
                      <v-list-item-content>
                        <v-list-item-title
                          v-text="item.name"
                         ></v-list-item-title>
                      </v-list-item-content>
                    </v-list-item>
                  </v-list-item-group>
                </v-list>
              </v-menu>
              <v-spacer> </v-spacer>
              <calendar-btn class="mr-4 d-none d-sm-block" color="secondary" @click="setToday">
                Today
              </calendar-btn>

              <calendar-btn fab text small color="grey darken-2" @click="prev">
                <v-icon small>mdi-chevron-left</v-icon>
              </calendar-btn>

              <h4 v-if="$refs.calendar" class="text-center">
                {{ $refs.calendar.title }}
              </h4>

              <calendar-btn fab text small color="grey darken-2" @click="next">
                <v-icon small>mdi-chevron-right</v-icon>
              </calendar-btn>

              
              <v-spacer></v-spacer>
              <v-menu bottom right>
                <template v-slot:activator="{ on, attrs }">
                  <v-btn
                    outlined
                    color="grey darken-2"
                    v-bind="attrs"
                    v-on="on"
                  >
                    <span>{{ typeToLabel[type] }}</span>
                    <v-icon right> mdi-menu-down </v-icon>
                  </v-btn>
                </template>
                <v-list>
                  <v-list-item @click="type = 'day'">
                    <v-list-item-title>Day</v-list-item-title>
                  </v-list-item>
                  <v-list-item @click="type = 'week'">
                    <v-list-item-title>Week</v-list-item-title>
                  </v-list-item>
                  <v-list-item @click="type = 'month'">
                    <v-list-item-title>Month</v-list-item-title>
                  </v-list-item>
                  <v-list-item @click="type = '4day'">
                    <v-list-item-title>4 days</v-list-item-title>
                  </v-list-item>
                </v-list>
              </v-menu>
            </v-toolbar>
          </v-sheet>
          <v-sheet height="600" flat class="mt-5">
            <v-calendar
              ref="calendar"
              v-model="focus"
              color="primary"
              :events="getSpecificBranchBooking"
              :event-color="selectedEvent.color"
              
              :type="type"
              @click:event="showEvent"
              @click:more="viewDay"
              @click:date="viewDay"
            ></v-calendar>
            <v-menu
              v-model="selectedOpen"
              :close-on-content-click="false"
              :activator="selectedElement"
              offset-x
              color="white"
            >
              <!-- <v-card color="grey lighten-4" min-width="350px" flat> -->
                <v-toolbar :color="selectedEvent.color" dark>
                  

                  <v-dialog max-width="400">
                    
                    <template v-slot:activator="{ on, attrs }">
                      <v-btn icon v-bind="attrs" v-on="on" 
                      @click="
                      
                      
                      getBranchHolidayWorkdayTime(),
                      findMaxPerson(),
                      selectedPerson=selectedEvent.person,
                      selectedDate =selectedEvent.dateFormat,
                      selectedTime =selectedEvent.time,
                      selectedCustomerName = selectedEvent.customerName,
                      selectedCustomerEmail = selectedEvent.email,
                      selectedCustomerContact = selectedEvent.contact,
                      selectedCustomerRemark = selectedEvent.remark
                      


                      "
                        ><v-icon>mdi-pencil</v-icon></v-btn
                      >
                    </template>
                    <template v-slot:default="dialog">
                      
                      <v-card>
                        <v-toolbar dark>Booking</v-toolbar>
                        <v-card-text>
                          <v-row class="mt-2">
                            <v-col cols="12" >
                              <v-text-field
                                v-model="selectedPerson"
                                 min=1
                                :max="maxPerson"
                                type="number"
                                oninput="if(Number(this.value) > Number(this.max)) this.value = this.max;"
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
                                    v-model="selectedDate"
                                    label="Picker in menu" 
                                    prepend-icon="mdi-calendar"
                                    readonly
                                    v-bind="attrs"
                                    v-on="on"
                                  ></v-text-field>
                                </template>
                                <FunctionalCalendar 
                                v-model="selectedCalendarDate"
                                :limits="{min: today, max: '01/01/3000'}"
                                :disabledDates="branchHoliday"
                                :disabled-day-names="weekdays"
                                :hidden-elements="['leftAndRightDays']"
                                :is-date-picker="true"
                                v-on:choseDay="selectedDate = selectedCalendarDate.selectedDate"                           
                                >
                                
                                </FunctionalCalendar>
                              </v-menu>
                            </v-col>
                            <v-col cols="12" sm="6" md="6">
                              <v-select
                                :items="timesPlusDuration"
                                v-model="selectedTime"
                                prepend-icon="mdi-clock"
                                single-line
                              ></v-select>
                            </v-col>
                            <v-col cols="12">
                              <v-text-field
                                v-model="selectedCustomerName"
                                label="Customer name "
                                prepend-icon="mdi-account"
                              ></v-text-field>
                            </v-col>
                             <v-col cols="12">
                              <v-text-field
                                v-model="selectedCustomerEmail"
                                label="Customer email "
                                prepend-icon="mdi-account"
                              ></v-text-field>
                            </v-col>
                             <v-col cols="12">
                              <v-text-field
                                v-model="selectedCustomerContact"
                                label="Customer contact "
                                prepend-icon="mdi-account"
                              ></v-text-field>
                            </v-col>
                            <v-col cols="12">
                              <v-textarea
                                    v-model="selectedCustomerRemark"
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
                            @click="dialog.value = false, selectedOpen=false"
                          >
                            Close
                          </v-btn>
                          <v-btn
                            color="blue darken-1"
                            text
                            @click="updateAppointment(), dialog.value = false,selectedOpen=false"
                          >
                            Save
                          </v-btn>
                        </v-card-actions>
                      </v-card>
                    </template>
                  </v-dialog>
                  <v-toolbar-title
                    v-html="selectedEvent.name"
                    class="white--text"
                    v-if="selectedEvent.name"
                  ></v-toolbar-title>
                  <v-toolbar-title
                    v-html="selectedEvent.person + ' Person'"
                    class="white--text"
                    v-if="selectedEvent.person && !selectedEvent.name"
                  ></v-toolbar-title>
                  <v-spacer></v-spacer>
                  <v-btn icon>
                    <v-icon>mdi-delete</v-icon>
                  </v-btn>
                </v-toolbar>
                <v-card-text style="background-color: white!important;">
                  <h3><b>Booking details</b></h3>
                  <span v-html="selectedEvent.details"></span>
                  <br />
                  <span v-html="'Remark: ' +selectedEvent.remark"></span>
                  <br />
                  <span v-html="'Customer: ' + selectedEvent.customerName"></span>
                </v-card-text>
                <!-- <v-card-actions>
                  <v-btn text color="secondary" @click="selectedOpen = false">
                    Cancel
                  </v-btn>
                </v-card-actions> -->
              <!-- </v-card> -->
            </v-menu>
          </v-sheet>
        </v-card>
        <v-card>
      <v-row class="my-12">
        <v-col cols="12" >
        <v-toolbar color="primary">
          <h2 class="text-left ml-4 white--text" >
      This's week schedule
    </h2>
        </v-toolbar>
    <v-list two-line flat>
      <v-list-item-group
        v-model="selectedWeekBooking"
        color="primary"
        
      >
        <template v-for="(item, index) in weekBooking">
          <v-list-item :key="item.service_title">
            <template v-slot:default="{ active }">
              <v-list-item-content>
                <v-list-item-title v-text="item.service_title"></v-list-item-title>

                <v-list-item-subtitle
                  class="primary--text"
                  v-text="item.person+' Person'"
                ></v-list-item-subtitle>

                <v-list-item-subtitle v-text="item.service_description"></v-list-item-subtitle>
                <v-list-item-subtitle class="black--text" v-text="item.name"></v-list-item-subtitle>
                <v-list-item-subtitle v-text="item.selected_date+' '+item.selected_time"></v-list-item-subtitle>
                
              </v-list-item-content>

              <v-list-item-action>
                <v-list-item-action-text v-text="item.duration+' min'"></v-list-item-action-text>

                <v-icon
                  v-if="!active"
                  color="grey lighten-1"
                >
                  mdi-star-outline
                </v-icon>

                <v-icon
                  v-else
                  color="yellow darken-3"
                >
                  mdi-star
                </v-icon>
              </v-list-item-action>
            </template>
          </v-list-item>

          <v-divider
            v-if="index < weekBooking.length - 1"
            :key="index"
          ></v-divider>
        </template>
      </v-list-item-group>
    </v-list>
        </v-col> 
      </v-row> 
    </v-card>
      </v-col>
    </v-row>
   
      <v-dialog
        transition="dialog-top-transition"
        max-width="400"
      >
        <template v-slot:activator="{ on, attrs }">
           <v-btn
        fab
        dark
        medium
        right
        fixed
        bottom
        color="indigo"
        v-bind="attrs" v-on="on"
      >
        <v-icon>mdi-plus</v-icon>
      </v-btn>
        </template>
        <template v-slot:default="dialog">
          <v-card>
            <v-toolbar
              color="indigo"
              dark
            >Add appointment</v-toolbar>
            <v-card-text>
                          <v-row class="mt-2">
                            <v-col cols="12">
                                    <!-- {{workingDays}}
                                    {{branchWorkingTime}} 
                                    {{gap}}
                                    {{branchHoliday}}
                                    {{weekdays}}
                                    {{timeSession}} -->
                              <v-select
                                :items ="branchItem"
                                v-model="selectBranch" 
                                 item-text="name"
                                 item-value="branch_id"
                                label="Branch"
                                prepend-icon="mdi-store"
                                return-object
                                @change="
                                    getBranchWorkDayAndTimeForAdd(),
                                    findMaxPersonForAdd()
                                    "
                              ></v-select>
                              </v-col>
                            <v-col cols="12" >
                              <v-text-field
                                v-model="selectPerson"
                                 min=1
                                :max="maxPerson"
                                type="number"
                                oninput="if(Number(this.value) > Number(this.max)) this.value = this.max;"
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
                                    v-model="selectDate.selectedDate"
                                    label="Choose your date" 
                                    prepend-icon="mdi-calendar"
                                    readonly
                                    v-bind="attrs"
                                    v-on="on"
                                  ></v-text-field>
                                </template>
                                <FunctionalCalendar 
                                v-model="selectDate"
                                :limits="{min: today, max: '01/01/3000'}"
                                :disabledDates="branchHoliday"
                                :disabled-day-names="weekdays"
                                :hidden-elements="['leftAndRightDays']"
                                :is-date-picker="true"
                                                          
                                >
                                
                                </FunctionalCalendar>
                              </v-menu>
                            </v-col>
                            <v-col cols="12" sm="6" md="6">
                              <v-select
                                :items="timesPlusDuration"
                                v-model="selectTime"
                                label="Pick your time"
                                prepend-icon="mdi-clock"
                                single-line
                              ></v-select>
                            </v-col>
                            <v-col cols="12">
                              <v-text-field
                                v-model="selectName"
                                label="Customer name "
                                prepend-icon="mdi-account"
                              ></v-text-field>
                            </v-col>
                             <v-col cols="12">
                              <v-text-field
                                v-model="selectEmail"
                                label="Customer email "
                                prepend-icon="mdi-account"
                              ></v-text-field>
                            </v-col>
                             <v-col cols="12">
                              <v-text-field
                                v-model="selectContact"
                                label="Customer contact "
                                prepend-icon="mdi-account"
                              ></v-text-field>
                            </v-col>
                            <v-col cols="12">
                              <v-textarea
                                    v-model="selectRemark"
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
                            @click="dialog.value = false, selectedOpen=false"
                          >
                            Close
                          </v-btn>
                          <v-btn
                            color="blue darken-1"
                            text
                            @click="updateAppointment(), dialog.value = false,selectedOpen=false"
                          >
                            Save
                          </v-btn>
                        </v-card-actions>
          </v-card>
        </template>
      </v-dialog> 
      
  
  </v-container>

  



</template>

<script>
// Components
import { VBtn } from "vuetify/lib";
import { BASEURL } from "@/api/baseurl";
import axios from "axios";
import { FunctionalCalendar } from 'vue-functional-calendar';

export default {
  name: "DashboardCalendar",

  components: {
    CalendarBtn: {
      extends: VBtn,

      props: {
        color: {
          type: String,
          default: "secondary",
        },
        minWidth: {
          type: Number,
          default: 0,
        },
        rounded: {
          type: Boolean,
          default: true,
        },
      },

      computed: {
        classes() {
          return {
            ...VBtn.options.computed.classes.call(this),
            "mx-1": true,
            "text-lowercase": true,
          };
        },
      },
    },

    FunctionalCalendar
  },

  data: () => ({
    domain: BASEURL,
    focus: "",
    type: "month",
    typeToLabel: {
      month: "Month",
      week: "Week",
      day: "Day",
      "4day": "4 Days",
    },
    selectedEvent: {},
    selectedElement: null,
    selectedOpen: false,
    events: [],
    company_id: "",
    branchItem: [],
    selectedBranch: "",
    specificBranchBooking: [],
    branchName: "all",
    menu: false,
    serviceID:'',
    date:'',
    branchHolidayWorkdayTime:[],
    selectedPerson: '',
    maxPerson:'',
    serviceDuration:'',
    slot:'',
    table:[],
    workingDays:[],
    branchHoliday:[],
    selectedDate:'',
    weekBooking:[],
    selectedWeekBooking:'',
    selectedCalendarDate:{},
    branchWorkingTime:'',
    gap:'',
    timesPlusDuration:[],
    booking:[],
    selectedTime:'',
    selectedCustomerName: '',
    selectedCustomerEmail: '',
    selectedCustomerContact:'',
    selectedCustomerRemark: '',
    selectPerson:'',
    selectBranch:'',
    selectDate:{},
    selectTime:'',
    selectName:'',
    selectEmail:'',
    selectContact:'',
    selectRemark:'',
  }),

  computed: {
    getSpecificBranchBooking() {
      var booking = [];
      var period = "m";
      var moment = require("moment"); // require
      moment().format();
      for (let i = 0; i < this.specificBranchBooking.length; i++) {
        var startDate = moment(
          this.specificBranchBooking[i].selected_date,
          "DD-MM-YYYY"
        ).format("YYYY-MM-DD");
        var startTime = moment(
          this.specificBranchBooking[i].selected_time,
          "hhmm"
        ).format("HH:mm");
        var start = startDate + " " + startTime;

        var endDate = startDate;
        var endTime = moment(startTime, "HH:mm")
          .add(this.specificBranchBooking[i].duration, period)
          .format("HH:mm");
        var end = endDate + " " + endTime;
        var changeDateFormat = moment(startDate).format("D/M/YYYY");

        booking.push({
          name: JSON.stringify(this.specificBranchBooking[i].person) +' Person',
          start: start,
          end: end,
          color: this.specificBranchBooking[i].color,
          details: this.specificBranchBooking[i].service_description,
          person: this.specificBranchBooking[i].person,
          remark: this.specificBranchBooking[i].remark,
          email: this.specificBranchBooking[i].email,
          contact: this.specificBranchBooking[i].contact,
          customerID: this.specificBranchBooking[i].customer_id,
          customerName: this.specificBranchBooking[i].name,
          bookingID: this.specificBranchBooking[i].booking_id,
          date: startDate,
          time: startTime,
          serviceID: this.specificBranchBooking[i].service_id,
          branchID: this.specificBranchBooking[i].branch_id,
          dateFormat: changeDateFormat,
        
        });
        
      }
      this.getBookingToUpdate();
      return booking;
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
  mounted() {
    this.$refs.calendar.checkChange();
  },
  created() {
    //check form availble
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);

    if (urlParams.has("id")) {
      const id = urlParams.get("id");
      this.company_id = id;
      this.getCompanyBranch();
      this.findAllBranchBooking();
      
    }
  },

  watch: {
    selectedBranch() {
      this.findSpecificBranchBooking();
    },
    // selectedBranchToUpdate(){
    //   this.getBranchNameForUpdate();
    // },
   
    selectedPerson() {
      this.getServiceToUpdate();
      this.getBookingToUpdate();
    
    },
    selectedDate(){
      this.getBookingToUpdate();

    },
    selectBranch(){
 
      
    },
    selectPerson(){
      
    },
    selectDate(){
      
    }
  },
  methods: {
    viewDay({ date }) {
      this.focus = date;
      this.type = "day";
    },
    setToday() {
      this.focus = "";
    },
    prev() {
      this.$refs.calendar.prev();
    },
    next() {
      this.$refs.calendar.next();
    },
    showEvent({ nativeEvent, event }) {
      const open = () => {
        this.selectedEvent = event;
        this.selectedElement = nativeEvent.target;
        setTimeout(() => {
          this.selectedOpen = true;
        }, 10);
      };

      if (this.selectedOpen) {
        this.selectedOpen = false;
        setTimeout(open, 10);
      } else {
        open();
      }

      nativeEvent.stopPropagation();
    },
    getCompanyBranch() {
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
            this.branchItem = response.data.branch;
          } else {
            console.log("no branch find");
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
    findSpecificBranchBooking() {
      
      const params = new URLSearchParams();
      params.append("findSpecificBranchBooking", "done");
      params.append("branch_id", this.selectedBranch);
     
      axios({
        method: "post",
        url: this.domain + "/booking/index.php",
        data: params,
      })
        .then((response) => {
          console.log(response);
          if (response.data.status == "1") {
            
            this.specificBranchBooking = response.data.booking;
            this.getBranchName();
            
          } else {
            
            this.findAllBranchBooking();
            this.branchName = "all";
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
    getBranchName() {
      for (var i = 0; i < this.branchItem.length; i++) {
        if (this.branchItem[i].branch_id == this.selectedBranch) {
          this.branchName = this.branchItem[i].name;
        }
      }
    },

    findAllBranchBooking() {
      const params = new URLSearchParams();
      params.append("findAllBranchBooking", "done");
      params.append("company_id", this.company_id);

      axios({
        method: "post",
        url: this.domain + "/booking/index.php",
        data: params,
      })
        .then((response) => {
          console.log(response);
          if (response.data.status == "1") {
            this.specificBranchBooking = response.data.booking;
            this.getThisWeekBooking();
            
          } else {
            console.log("bad");
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
    getBranchHolidayWorkdayTime(){

      const params = new URLSearchParams();
      params.append("getBranchHolidayWorkdayTime", "done");
      params.append("service_id", this.selectedEvent.serviceID);

      axios({
        method: "post",
        url: this.domain + "/branch/index.php",
        data: params,
      })
        .then((response) => {
          console.log(response);
          if (response.data.status == "1") {
             this.branchHolidayWorkdayTime = response.data.branch[0];
             this.workingDays = JSON.parse(this.branchHolidayWorkdayTime.working_day);
             this.branchHoliday = JSON.parse(this.branchHolidayWorkdayTime.date);
             this.branchWorkingTime = JSON.parse(this.branchHolidayWorkdayTime.working_time);
             this.gap = this.branchHolidayWorkdayTime.gap;
             
             
          } else {
              console.log("no branch holiday, workingday and time found ");          }
        })
        .catch((error) => {
          console.log(error);
        });
      
    },

    getServiceToUpdate() {
      const params = new URLSearchParams();
      params.append("read", "done");
      params.append("branch_id", this.selectedEvent.branchID);
      params.append("seat", this.selectedPerson);
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
            
          } else {
            console.log("cannot read service that you type");
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
    findMaxPerson(){
      const params = new URLSearchParams();
      params.append("findMaxPerson", "done");
      params.append("branch_id", this.selectedEvent.branchID);
      
     

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
            console.log("No max person found");
            
          }
        })
        .catch((error) => {
          console.log(error);
        });
      
    },

    getThisWeekBooking(){
     
      var moment = require("moment"); // require
      moment().format();
       var weekBooking = [];
      var currentDay = moment(this.today,"DD/MM/YYYY")
      var currentDate = currentDay.format("YYYY-MM-DD");
      var addWeek = currentDay.add(7,'days').format("YYYY-MM-DD");
      for (let i = 0; i <this.specificBranchBooking.length; i++) {
        var bookingDate = moment(this.specificBranchBooking[i].selected_date,"DD/MM/YYYY").format("YYYY-MM-DD");
        // console.log(bookingDate);
        
         
        if(moment(bookingDate).isBetween(currentDate,addWeek,undefined, '[]')){
           weekBooking.push(this.specificBranchBooking[i]);
        }
      }
      
      this.weekBooking = weekBooking;

    },
    getBookingToUpdate(){
      const params = new URLSearchParams();
      params.append("check", "done");
      params.append("selected_date", this.selectedDate);
      params.append("service_id", this.serviceID);
      params.append("booking_id", this.selectedEvent.bookingID);

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
            console.log("no booking can be found in database");
            this.booking = [];
            this.finalTime(); 
          }
        })
        .catch((error) => {
          console.log(error);
        });
      
    },
    
    finalTime(){
      var moment = require("moment"); // require
      moment().format();
      var duration = this.serviceDuration;
      this.timesPlusDuration=[];
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
    },

    updateAppointment(){
      const params = new URLSearchParams();
      params.append("update", "done");
      params.append("booking_id", this.selectedEvent.bookingID);
      params.append("person", this.selectedPerson);
      params.append("selected_date", this.selectedDate);
      params.append("selected_time", this.selectedTime);
      params.append("customer_id", this.selectedEvent.customerID);
      params.append("name", this.selectedCustomerName);
      params.append("email", this.selectedCustomerEmail);
      params.append("contact", this.selectedCustomerContact);
      params.append("remark", this.selectedCustomerRemark);

      axios({
        method: "post",
        url: this.domain + "/booking/index.php",
        data: params,
      })
        .then((response) => {
          console.log(response);
          if (response.data.status == "1") {
            console.log("update successfully");
            
          } else {
            console.log("Update Fail");
          }
        })
        .catch((error) => {
          console.log(error);
        });
      
    },
    addCustomer(){
      const params = new URLSearchParams();
      params.append("create", "done");
      params.append("name", this.name);
      params.append("contact", this.contact);
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

    addAppointment(){
      
      const params = new URLSearchParams();
      params.append("create", "done");
      params.append("service_id", this.serviceID);
      params.append("selected_time", this.selectTime);
      params.append("duration", this.selectDuration);
      params.append("selected_date", this.selectDate);
      params.append("person", this.selectPerson);
      params.append("customer_id", this.customerID);

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
  

          } else {
            console.log("Booking failed");
            
          }
        })
        .catch((error) => {
          console.log(error);
        });

    },
    findMaxPersonForAdd(){
      const params = new URLSearchParams();
      params.append("findMaxPerson", "done");
      params.append("branch_id", this.selectBranch.branch_id);

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
     getServiceToAdd() {
      const params = new URLSearchParams();
      params.append("read", "done");
      params.append("branch_id", this.selectBranch.branchID);
      params.append("seat", this.selectPerson);
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
            
          } else {
            console.log("cannot read service that you type");
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
    getBranchWorkDayAndTimeForAdd() {
        
      
       for (var i = 0; i < this.branchItem.length; i++) {
        if (this.branchItem[i].branch_id == this.selectBranch.branch_id) {
             this.workingDays = JSON.parse(this.branchItem[i].working_day);
             this.branchWorkingTime =JSON.parse(this.branchItem[i].working_time);
             this.gap = JSON.parse(this.branchItem[i].gap);
        }
      }
      this.getBranchHolidayForAdd();
      

      

  
    },
    getBranchHolidayForAdd() {
      const params = new URLSearchParams();
      params.append("read", "done");
      params.append("branch_id", this.selectBranch.branch_id);
      axios({
        method: "post",
        url: this.domain + "/holiday/index.php",
        data: params,
      })
        .then((response) => {
          console.log(response);
          if (response.data.status == "1") {
            this.branchHoliday = JSON.parse(response.data.holiday[0].date);
   
          } else {
            console.log("no holiday");
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
    getBookingForAdd() {
      const params = new URLSearchParams();
      params.append("read", "done");
      params.append("selected_date", this.selectDate.selectedDate);
      params.append("service_id", this.serviceID);

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

    
  },
};
</script>


<style lang="sass">
#calendar
  .v-calendar-weekly__day:last-child,
  .v-calendar-weekly__head-weekday:last-child
    border-right: none

    .v-calendar-weekly__week:last-child .v-calendar-weekly__day
      border-bottom: none
</style>
