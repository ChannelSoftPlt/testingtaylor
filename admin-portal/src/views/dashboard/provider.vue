<template>
  <v-container id="provider" fluid>
    <v-row>
      <v-col cols="12" md="2">

        <v-row class="ml-3">
          <h2>Provider</h2>
        </v-row>
        <v-card height="1000px">
          <v-row class="mx-1 mr-2">
            <v-col cols="12">
              <v-text-field
                v-model="searchProvider"
                label="Search..."
              ></v-text-field>
            </v-col>
            <!-- <v-col cols="2" class="d-inline">
       <v-btn
      class="ma-2"
      outlined
      fab
      color="teal"
    >
      <v-icon>mdi-format-list-bulleted-square</v-icon>
    </v-btn>
      </v-col> -->
          </v-row>
          <v-list two-line class="overflow">
            <v-list-item-group
              v-model="selectedProvider"
              active-class="pink--text"
            >
              <template>
                <v-list-item
                  v-for="(item, index) in providerItem"
                  :key="index"
                  :value="item.provider_id"
                >
                  <template>
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
      <v-col cols="12" md="10">
        <v-row class="ml-3">
          <v-col class="text-center">
            <h2>Provider Details</h2>
          </v-col>
        </v-row>

        <v-row>
          <v-col cols="12" class="px-8">
            <v-row>
              <v-col cols="12" md="4">
                <span class="ml-4">Name</span>
                <v-subheader>
                  The service provider name that show on the system
                  list</v-subheader
                >
              </v-col>
              <v-col cols="12" md="8" class="px-7">
                <v-text-field
                  v-model="providerName"
                  placeholder="e.g Alex Chandra"
                  clearable
                ></v-text-field>
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="12" md="4">
                <span class="ml-4">Role</span>
                <v-subheader>
                  The role description of the service provider
                </v-subheader>
              </v-col>
              <v-col cols="12" md="8" class="px-7">
                <v-text-field
                  v-model="providerRole"
                  placeholder="e.g Hair Designer"
                  clearable
                ></v-text-field>
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="12" md="4">
                <span class="ml-4">Contact</span>
                <v-subheader>
                  The service provider contact number that show on the
                  system</v-subheader
                >
              </v-col>
              <v-col cols="12" md="8" class="px-7">
                <v-text-field
                  v-model="providerPhone"
                  placeholder="e.g +60167148105"
                  clearable
                ></v-text-field>
              </v-col>
            </v-row>

            <v-row>
              <v-col cols="12" md="4">
                <span class="ml-4">Email</span>
                <v-subheader>
                  The provider email that show on the system</v-subheader
                >
              </v-col>
              <v-col cols="12" md="8" class="px-7">
                <v-text-field v-model="providerEmail" clearable></v-text-field>
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="12" md="4">
                <span class="ml-4">Branch</span>
                <v-subheader
                  >Assign this provider to the specific branch for easy
                  management</v-subheader
                >
              </v-col>
              <v-col cols="12" md="7" class="px-7">
                <v-select
                  v-model="providerBranch"
                  :items="branchItem"
                  attach
                  dense
                  item-text="name"
                  item-value="branch_id"
                ></v-select>
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="12" md="4">
                <span class="ml-4">Working day</span>
                <v-subheader>
                  Working day of service provider that can be overlapping with
                  the branch working day</v-subheader
                >
              </v-col>
              <v-col cols="12" md="7" class="px-7">
                <v-select
                  v-model="providerWorkingDay"
                  :items="day"
                  attach
                  chips
                  dense
                  multiple
                ></v-select>
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="12" md="4">
                <span class="ml-4">Working hour</span>
                <v-subheader
                  >Select the start time and end time for service provider
                  working hours
                </v-subheader>
              </v-col>
              <v-col cols="12" md="7" class="px-7">
                <v-row>
                  <v-col cols="6">
                    <v-menu
                      ref="menu1"
                      v-model="startWorkingMenu"
                      :close-on-content-click="false"
                      :nudge-right="40"
                      :return-value.sync="time"
                      transition="scale-transition"
                      offset-y
                      max-width="290px"
                      min-width="290px"
                    >
                      <template v-slot:activator="{ on, attrs }">
                        <v-text-field
                          v-model="providerStartWorkingTime"
                          prepend-icon="mdi-clock-time-four-outline"
                          readonly
                          v-bind="attrs"
                          v-on="on"
                        ></v-text-field>
                      </template>
                      <v-time-picker
                        v-if="startWorkingMenu"
                        v-model="providerStartWorkingTime"
                        full-width
                        @click:minute="$refs.menu1.save(time)"
                      ></v-time-picker>
                    </v-menu>
                  </v-col>
                  <v-col cols="6">
                    <v-menu
                      ref="menu2"
                      v-model="endWorkingMenu"
                      :close-on-content-click="false"
                      :nudge-right="40"
                      :return-value.sync="time"
                      transition="scale-transition"
                      offset-y
                      max-width="290px"
                      min-width="290px"
                    >
                      <template v-slot:activator="{ on, attrs }">
                        <v-text-field
                          v-model="providerEndWorkingTime"
                          prepend-icon="mdi-clock-time-four-outline"
                          readonly
                          v-bind="attrs"
                          v-on="on"
                        ></v-text-field>
                      </template>
                      <v-time-picker
                        v-if="endWorkingMenu"
                        v-model="providerEndWorkingTime"
                        full-width
                        @click:minute="$refs.menu2.save(time)"
                      ></v-time-picker>
                    </v-menu>
                  </v-col>
                </v-row>
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="12" md="4">
                <span class="ml-4">Break Time</span>
                <v-subheader
                  >Choose the break time e.g. 12:00 - 13:00 for the service
                  provider
                </v-subheader>
              </v-col>
              <v-col cols="12" md="7" class="px-7">
                <v-row>
                  <v-col cols="6">
                    <v-menu
                      ref="menu3"
                      v-model="startBreakMenu"
                      :close-on-content-click="false"
                      :nudge-right="40"
                      :return-value.sync="time"
                      transition="scale-transition"
                      offset-y
                      max-width="290px"
                      min-width="290px"
                    >
                      <template v-slot:activator="{ on, attrs }">
                        <v-text-field
                          v-model="providerStartBreakTime"
                          prepend-icon="mdi-clock-time-four-outline"
                          readonly
                          v-bind="attrs"
                          v-on="on"
                        ></v-text-field>
                      </template>
                      <v-time-picker
                        v-if="startBreakMenu"
                        v-model="providerStartBreakTime"
                        full-width
                        @click:minute="$refs.menu3.save(time)"
                      ></v-time-picker>
                    </v-menu>
                  </v-col>
                  <v-col cols="6">
                    <v-menu
                      ref="menu4"
                      v-model="endBreakMenu"
                      :close-on-content-click="false"
                      :nudge-right="40"
                      :return-value.sync="time"
                      transition="scale-transition"
                      offset-y
                      max-width="290px"
                      min-width="290px"
                    >
                      <template v-slot:activator="{ on, attrs }">
                        <v-text-field
                          v-model="providerEndBreakTime"
                          prepend-icon="mdi-clock-time-four-outline"
                          readonly
                          v-bind="attrs"
                          v-on="on"
                        ></v-text-field>
                      </template>
                      <v-time-picker
                        v-if="endBreakMenu"
                        v-model="providerEndBreakTime"
                        full-width
                        @click:minute="$refs.menu4.save(time)"
                      ></v-time-picker>
                    </v-menu>
                  </v-col>
                </v-row>
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="12" md="4">
                <span class="ml-4">slot</span>
                <v-subheader>
                  This is the slot for the customer to book appointment on this
                  service provider</v-subheader
                >
              </v-col>
              <v-col cols="12" md="2" class="px-7">
                <v-text-field
                  v-model="providerSlot"
                  suffix="Times"
                ></v-text-field>
              </v-col>
            </v-row>

            <v-row>
              <v-col cols="12" md="4">
                <span class="ml-4">Status</span>
                <v-subheader
                  >Represent the branch status show on customer selection when
                  branch is active
                </v-subheader>
              </v-col>
              <v-col cols="12" md="1" class="px-7">
                <v-switch v-model="providerStatus"></v-switch>
              </v-col>
            </v-row>
          </v-col>
        </v-row>

        <v-row class="text-center mr-n7">
          <v-col>
            <v-btn
              color="blue darken-1"
              @click="addProvider()"
              v-if="!selectedProvider"
            >
              Add
            </v-btn>
            <v-btn
              color="success"
              @click="updateProvider()"
              v-if="selectedProvider"
            >
              Save
            </v-btn>
            <v-btn
              color="error"
              @click.stop="confirmDeleteDialog = true"
              v-if="selectedProvider"
            >
              Delete
            </v-btn>
            <v-dialog v-model="confirmDeleteDialog" max-width="290">
              <v-card>
                <v-card-title> Are you confirm to delete? </v-card-title>

                <v-card-text>
                  <span class="font-weight-medium"
                    >The selected provider and it's information will be
                    delete</span
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

                  <v-btn color="green darken-1" text @click="deleteProvider()">
                    Agree
                  </v-btn>
                  <v-spacer></v-spacer>
                </v-card-actions>
              </v-card>
            </v-dialog>

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
          </v-col>
        </v-row>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import { BASEURL } from "@/api/baseurl";
import axios from "axios";
export default {
  name: "DashboardCalendar",

  data: () => ({
    domain: BASEURL,
    company_id: "",
    providerName: "",
    providerRole: "",
    providerPhone: "",
    providerBranch: "",
    providerEmail: "",
    providerWorkingDay: [],
    providerStartWorkingTime: "",
    providerEndWorkingTime: "",
    providerStartBreakTime: "",
    providerEndBreakTime: "",
    providerSlot: "",
    providerStatus: '',
    startWorkingMenu: null,
    endWorkingMenu: null,
    startBreakMenu: null,
    endBreakMenu: null,
    searchProvider: "",
    selectedProvider: "",
    snackbar: false,
    timeout: 2000,
    day: [
      "Sunday",
      "Monday",
      "Tuesday",
      "Wednesday",
      "Thursday",
      "Friday",
      "Saturday",
    ],
    time: "",
    providerItem: [],
    text: "",
    confirmDeleteDialog: false,
    branchItem: [],
    providerWorking:"",
  }),
  created() {
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);

    if (urlParams.has("id")) {
      const id = urlParams.get("id");
      this.company_id = id;
      this.getProviderByCompany();
      this.getCompanyBranch();
    }
  },
  watch: {
    providerStatus() {
      this.changeStatusFormat();
    },
    selectedProvider(){
      this.getProviderDetail();
    }
  },
  computed: {
    workingDayCheck() {
      var value = [];

      if (this.providerWorking[0] == 0) {
        value.push("Sunday");
      }
      if (this.providerWorking[1] == 0) {
        value.push("Monday");
      }
      if (this.providerWorking[2] == 0) {
        value.push("Tuesday");
      }
      if (this.providerWorking[3] == 0) {
        value.push("Wednesday");
      }
      if (this.providerWorking[4] == 0) {
        value.push("Thursday");
      }
      if (this.providerWorking[5] == 0) {
        value.push("Friday");
      }
      if (this.providerWorking[6] == 0) {
        value.push("Saturday");
      }

      return value;
    },
    realWorkingDay() {
      var day = [0, 0, 0, 0, 0, 0, 0];

      if (!this.providerWorkingDay.includes("Sunday")) {
        day[0] = 1;
      }
      if (!this.providerWorkingDay.includes("Monday")) {
        day[1] = 1;
      }
      if (!this.providerWorkingDay.includes("Tuesday")) {
        day[2] = 1;
      }
      if (!this.providerWorkingDay.includes("Wednesday")) {
        day[3] = 1;
      }
      if (!this.providerWorkingDay.includes("Thursday")) {
        day[4] = 1;
      }
      if (!this.providerWorkingDay.includes("Friday")) {
        day[5] = 1;
      }
      if (!this.providerWorkingDay.includes("Saturday")) {
        day[6] = 1;
      }

      return day;
    },
    realWorkingTime() {
      var time = [];

      time.push('"' + this.providerStartWorkingTime + '"');
      time.push('"' + this.providerEndWorkingTime + '"');

      return time;
    },
    realBreakTime() {
      var time = [];

      time.push('"' + this.providerStartBreakTime + '"');
      time.push('"' + this.providerEndBreakTime + '"');

      return time;
    },
  },

  methods: {
    changeStatusFormat() {
      if (this.providerStatus == true) {
        this.providerStatus = 1;
      } else {
        this.providerStatus = 0;
      }
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
    getProviderByCompany() {
      const params = new URLSearchParams();
      params.append("getProviderByCompany", "done");
      params.append("company_id", this.company_id);

      axios({
        method: "post",
        url: this.domain + "/provider/index.php",
        data: params,
      })
        .then((response) => {
          console.log(response);
          if (response.data.status == "1") {
            this.providerItem = response.data.provider;
          } else {
            console.log("no provider find");
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },

    getProviderDetail() {
      this.providerName = "";
      this.providerRole = "";
      this.providerPhone = "";
      this.providerEmail = "";
      this.providerBranch = "";
      this.providerWorkingTime = "";
      this.providerStartWorkingTime = "";
      this.providerEndWorkingTime = "";
      this.providerWorking = "";
      this.providerWorkingDay ="";
      this.providerSlot='';
      this.providerStatus = 0;
      this.providerBreakTime = "";
      this.providerStartBreakTime = '';
      this.providerEndBreakTime = '';
 
      for (var i = 0; i < this.providerItem.length; i++) {
        if (this.providerItem[i].provider_id == this.selectedProvider) {
          this.providerName  = this.providerItem[i].name;
          this.providerRole = this.providerItem[i].staff_description;
          this.providerPhone = this.providerItem[i].phone;
          this.providerEmail = this.providerItem[i].email;
          this.providerBranch = this.providerItem[i].branch_id;
          this.providerWorkingTime = JSON.parse(this.providerItem[i].work_time);
          this.providerStartWorkingTime = this.providerWorkingTime[0];
          this.providerEndWorkingTime = this.providerWorkingTime[1];
          this.providerWorking = JSON.parse(this.providerItem[i].work_day);
          this.providerWorkingDay = this.workingDayCheck;
          this.providerSlot = this.providerItem[i].slot;
          this.providerStatus = this.providerItem[i].status;
          this.providerBreakTime = JSON.parse(this.providerItem[i].break_time);
          this.providerStartBreakTime = this.providerBreakTime[0];
          this.providerEndBreakTime = this.providerBreakTime[1];
        }
      }
     
      
    },
    addProvider() {
      const params = new URLSearchParams();
      params.append("create", "done");
      params.append("branch_id", this.providerBranch);
      params.append("name", this.providerName);
      params.append("staff_description", this.providerRole);
      params.append("phone", this.providerPhone);
      params.append("email", this.providerEmail);
      params.append("work_day", "[" + this.realWorkingDay + "]");
      params.append("work_time", "[" + this.realWorkingTime + "]");
      params.append("slot", this.providerSlot);
      params.append("status", this.providerStatus);
      params.append("break_time", "[" + this.realBreakTime + "]");

      axios({
        method: "post",
        url: this.domain + "/provider/index.php",
        data: params,
      })
        .then((response) => {
          console.log(response);
          if (response.data.status == "1") {
            
            this.snackbar = true;
            this.text = "Provider add successfully";
            this.getProviderByCompany();
          } else {
              this.snackbar = true;
              this.text = "Add Provider failed! Something went wrong";
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
    updateProvider(){
        const params = new URLSearchParams();
        params.append("update", "done");
        params.append("provider_id", this.selectedProvider);
        params.append("branch_id", this.providerBranch);
        params.append("name", this.providerName);
        params.append("staff_description", this.providerRole);
        params.append("phone", this.providerPhone);
        params.append("email", this.providerEmail);
        params.append("work_day", "[" + this.realWorkingDay + "]");
        params.append("work_time", "[" + this.realWorkingTime + "]");
        params.append("slot", this.providerSlot);
        params.append("status", this.providerStatus);
        params.append("break_time", "[" + this.realBreakTime + "]");

        axios({
          method: "post",
          url: this.domain + "/provider/index.php",
          data: params,
        })
          .then((response) => {
            console.log(response);
            if (response.data.status == "1") {
              
              this.snackbar = true;
              this.text = "Provider Update successfully";
              this.getProviderByCompany();
            } else {
              this.snackbar = true;
              this.text = "Update failed! Something went wrong";
            }
          })
          .catch((error) => {
            console.log(error);
          });
    },
    deleteProvider() {
      const params = new URLSearchParams();
      params.append("delete", "done");
      params.append("provider_id", this.selectedProvider);
      axios({
        method: "post",
        url: this.domain + "/provider/index.php",
        data: params,
      })
        .then((response) => {
          console.log(response);
          if (response.data.status == "1") {
            this.confirmDeleteDialog = false;
            this.snackbar = true;
            this.text = "Provider delete successfully";
            this.getProviderByCompany();
          } else {
              this.confirmDeleteDialog = false;
              this.snackbar = true;
              this.text = "Delete Provider failed! Something went wrong";
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
