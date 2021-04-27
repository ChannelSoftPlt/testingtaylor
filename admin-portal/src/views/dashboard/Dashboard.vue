<template>
  <v-container
    id="calendar"
    fluid
    tag="section"
  >
    <base-v-component
      heading="Appointment"
      link="components/calendars"
    />

    <!-- {{getSpecificBranchBooking}} -->

    <v-row>
      <v-col
        cols="12"
        md="10"
        class="mx-auto"
      >
        <v-card>
          <v-sheet height="64">
          <v-toolbar flat>

            <v-menu
            bottom
            right
          >
            <template v-slot:activator="{ on, attrs }">
              <v-btn
                outlined
                color="grey darken-2"
                v-bind="attrs"
                v-on="on"
              >
                {{branchName}}
                <v-icon right>
                  mdi-menu-down
                </v-icon>
              </v-btn>
            </template>
            <v-list shaped>
              <v-list-item-group v-model="selectedBranch" color="primary" mandatory>
                <v-list-item value="all">All</v-list-item>
                <v-list-item
                  
                  v-for="(item, i) in branchItem"
                  :key="i"
                  :value="item.branch_id"
                 
                >
                  <v-list-item-content>
                    <v-list-item-title v-text="item.name"></v-list-item-title>
                  </v-list-item-content>
                </v-list-item>
              </v-list-item-group>
            </v-list>
          </v-menu>
            <v-spacer> </v-spacer>
            <calendar-btn
              class="mr-4"
              color="secondary"
              @click="setToday"
            >
              Today
            </calendar-btn>

            <calendar-btn 
            fab
            text
            small
            color="grey darken-2"
            @click="prev">
              <v-icon small>mdi-chevron-left</v-icon>
            </calendar-btn>

            <calendar-btn 
            fab
            text
            small
            color="grey darken-2"
            @click="next">
              <v-icon small>mdi-chevron-right</v-icon>
            </calendar-btn>

            <v-toolbar-title v-if="$refs.calendar">
            {{ $refs.calendar.title }}
          </v-toolbar-title>
          <v-spacer></v-spacer>
          <v-menu
            bottom
            right
          >
            <template v-slot:activator="{ on, attrs }">
              <v-btn
                outlined
                color="grey darken-2"
                v-bind="attrs"
                v-on="on"
              >
                <span>{{ typeToLabel[type] }}</span>
                <v-icon right>
                  mdi-menu-down
                </v-icon>
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
          <v-sheet
            height="600"
            flat
            class="mt-5"
          >
            <v-calendar
              ref="calendar"
              v-model="focus"
              color="primary"
              :events="getSpecificBranchBooking"
              :event-color="getEventColor"
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
          
        >
          <v-card
            color="grey lighten-4"
            min-width="350px"
            flat
          >
            <v-toolbar
              :color="selectedEvent.color"
              dark
            >
            <v-dialog
        
        max-width="400"
        
      >
        <template v-slot:activator="{ on, attrs }">
          <v-btn 
          icon   
            v-bind="attrs"
            v-on="on"
            
          ><v-icon>mdi-pencil</v-icon></v-btn>
        </template>
        <template v-slot:default="dialog">
          <v-card>
            <v-toolbar
              dark
            >Booking</v-toolbar>
            <v-card-text>
              <v-row>
              <!-- <v-col
      cols="12"
    >
        <v-select
          v-model="e1"
          :items="states"
          menu-props="auto"
          label="Select"
          hide-details
          prepend-icon="mdi-store"
          single-line
        ></v-select>
        </v-col> -->

        <v-col
      cols="12"
      class="mt-2"
    >
        <v-text-field
                  v-model="selectedEvent.person"
                  min = 0
                  max = 3
                  type="number"
                  oninput="if(Number(this.value) > Number(this.max)) this.value = this.max;"
                  label="Total Person"
                  prepend-icon="mdi-account"
                  
                ></v-text-field>
        </v-col>
              <v-col
      cols="12"
      sm="6"
      md="6"
    >
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
            v-model="selectedEvent.date"
            label="Picker in menu"
            prepend-icon="mdi-calendar"
            readonly
            v-bind="attrs"
            v-on="on"
          ></v-text-field>
        </template>
        <v-date-picker
          v-model="selectedEvent.date"
          no-title
          scrollable
        >
          <v-spacer></v-spacer>
          <v-btn
            text
            color="primary"
            @click="menu=false"
          >
            Cancel
          </v-btn>
          <v-btn
            text
            color="primary"
            
          >
            OK
          </v-btn>
        </v-date-picker>
      </v-menu>
    </v-col>
    <v-col
      cols="12"
      sm="6"
      md="6"
    >
     <v-select
          v-model="selectedEvent.time"
          label="time"
          prepend-icon="mdi-clock"
          single-line
        ></v-select>
      
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
            @click="dialog.value = false"
          >
            Save
          </v-btn>
        
            </v-card-actions>
          </v-card>
        </template>
      </v-dialog>
              <v-toolbar-title v-html="selectedEvent.name" class="white--text" v-if="selectedEvent.name" ></v-toolbar-title>
              <v-toolbar-title v-html="selectedEvent.person +' Person' " class="white--text"  v-if="selectedEvent.person && !selectedEvent.name"></v-toolbar-title>
              <v-spacer></v-spacer>
              <v-btn icon>
                <v-icon>mdi-delete</v-icon>
              </v-btn>
            </v-toolbar>
            <v-card-text>
              <h2><b>Booking details</b></h2>
              <span v-html="selectedEvent.details"></span>
              <br>
              <h3 v-html="selectedEvent.remark"></h3>
              <br>
              <h3 v-html="selectedEvent.customerName"></h3>
            </v-card-text>
            <v-card-actions>
              <v-btn
                text
                color="secondary"
                @click="selectedOpen = false"
              >
                Cancel
              </v-btn>
            </v-card-actions>
          </v-card>
        </v-menu>
          </v-sheet>
        </v-card>
      </v-col>
    </v-row>
     
  </v-container>
</template>

<script>
  // Components
  import { VBtn } from 'vuetify/lib';
  import { BASEURL } from "@/api/baseurl";
import axios from "axios";





  
  export default {
    name: 'DashboardCalendar',

    components: {
      CalendarBtn: {
        extends: VBtn,

        props: {
          color: {
            type: String,
            default: 'secondary'
          },
          minWidth: {
            type: Number,
            default: 0
          },
          rounded: {
            type: Boolean,
            default: true
          }
        },

        computed: {
          classes() {
            return {
              ...VBtn.options.computed.classes.call(this),
              'mx-1': true,
              'text-lowercase': true
            }
          },
          
        }
      }
    },

    data: () => ({
      domain: BASEURL,
      focus: '',
      type: 'month',
      typeToLabel: {
        month: 'Month',
        week: 'Week',
        day: 'Day',
        '4day': '4 Days',
      },
      selectedEvent: {},
      selectedElement: null,
      selectedOpen: false,
      events: [],
      colors: ['blue', 'indigo', 'deep-purple', 'cyan', 'green', 'orange', 'grey darken-1'],
      company_id:'',
      branchItem:[],
      selectedBranch:'',
      specificBranchBooking:[],
      branchName:'all',
      date: '2021-04-25',
      menu: false,
    }),

    computed: {

      getSpecificBranchBooking(){
        var booking = [];
        var period = "m";
        var moment = require('moment'); // require
        moment().format(); 
      for (let i = 0; i < this.specificBranchBooking.length ; i++) {
         
         var startDate = moment(this.specificBranchBooking[i].selected_date, "DD-MM-YYYY").format("YYYY-MM-DD");
         var startTime = moment(this.specificBranchBooking[i].selected_time,"hhmm").format("HH:mm");
         var start = startDate+" "+startTime;
         
         var endDate = startDate;
         var endTime = moment(startTime,"HH:mm").add(this.specificBranchBooking[i].duration, period).format("HH:mm");
         var end = endDate+" "+endTime;
         
        booking.push({
            name: this.specificBranchBooking[i].service_title,            
            start:start,
            end: end,
            color: this.colors[this.rnd(0, this.colors.length - 1)],
            details: this.specificBranchBooking[i].service_description,
            person: this.specificBranchBooking[i].person,
            remark: "Remark: "+this.specificBranchBooking[i].remark,
            customerName: "Customer: "+this.specificBranchBooking[i].name,
            bookingID:this.specificBranchBooking[i].booking_id,
            date: startDate,
            time: startTime,
            
            
          })
        }

         
         return booking;

         
        
        
      }
      
      
    },
    mounted () {
      this.$refs.calendar.checkChange()
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
    
    },
    methods: {
      viewDay ({ date }) {
        this.focus = date
        this.type = 'day'
      },
      getEventColor (event) {
        return event.color
      },
      setToday () {
        this.focus = ''
      },
      prev () {
        this.$refs.calendar.prev()
      },
      next () {
        this.$refs.calendar.next()
      },
      showEvent ({ nativeEvent, event }) {
        const open = () => {
          this.selectedEvent = event
          this.selectedElement = nativeEvent.target
          setTimeout(() => {
            this.selectedOpen = true
          }, 10)
        }

        if (this.selectedOpen) {
          this.selectedOpen = false
          setTimeout(open, 10)
        } else {
          open()
        }

        nativeEvent.stopPropagation()
      },
      // updateBookingDetail (booking_id) {

      //    const params = new URLSearchParams();
      //     params.append("update", "done");
      //     params.append("booking_id", booking_id);
      //     axios({
      //       method: "post",
      //       url: this.domain + "/booking/index.php",
      //       data: params,
      //     })
      //       .then((response) => {
      //         console.log(response);
      //         if (response.data.status == "1") {
      //             console.log("hello");
                
      //         } 
      //         else {
              
      //         console.log("no branch find");


      //         }
      //       })
      //       .catch((error) => {
      //         console.log(error);
      //       });
      // },
      rnd (a, b) {
        return Math.floor((b - a + 1) * Math.random()) + a
      },
      getCompanyBranch(){

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
              
            
          } 
          else {
           
           console.log("no branch find");


          }
        })
        .catch((error) => {
          console.log(error);
        });
      
    },
    findSpecificBranchBooking(){

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
          } 
          else {

           this.branchName = 'all';
           
             this.findAllBranchBooking();
           
           

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

    findAllBranchBooking(){

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
              
            } 
            else {

              console.log("bad");


            }
          })
          .catch((error) => {
            console.log(error);
          });

        
      
      

    },
    // allowedDates: val => parseInt(val.split('-')[2], 10) % 2 === 0,
    
    


    },

    
    
  }
</script>

<style lang="sass">
  #calendar
    .v-calendar-weekly__day:last-child,
    .v-calendar-weekly__head-weekday:last-child
      border-right: none

    .v-calendar-weekly__week:last-child .v-calendar-weekly__day
      border-bottom: none
</style>
