<template>
  <v-container id="wizard" tag="section" fluid>
    <v-row>
      <v-col cols="12" md="2">
        <v-row class="ml-3">
          <h2>Branch</h2>
        </v-row>
        <v-card height="1100px">
          <v-row class="mx-1 mr-2">
            <v-col cols="12">
              <v-text-field
                v-model="searchBranch"
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
             
            >
              <template>
                <v-list-item
                  v-for="(item, index) in branchItem"
                  :key="index"
                  :value="item.branch_id"
                  
                >
                  <template>
                    <!-- <v-list-item-avatar>
                      <v-avatar color="#2196F3" size="56" class="white--text">
                        {{ item.name[0] }}
                      </v-avatar>
                    </v-list-item-avatar> -->
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
        <v-row class="ml-3" >
          <v-col class="text-center"> 
          <h2>Branch Details</h2>
          </v-col>
        </v-row>

        <v-row>
          <v-col cols="12" class="px-8">
            <v-row>
              <v-col cols="12" md="4">
                <span class="ml-4">Name</span>
                <v-subheader>
                  Your branch name that appear on customer booking list</v-subheader
                >
              </v-col>
              <v-col cols="12" md="8" class="px-7">
                <v-text-field
              v-model="branchName"
              placeholder="e.g Tea Garden Taman bukit indah"
             
              clearable
            ></v-text-field>
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="12" md="4" >
                <span class="ml-4">Address</span>
                <v-subheader>
                  Your branch location that will show to customer</v-subheader
                >
              </v-col>
              <v-col cols="12" md="8" class="px-7">
                <v-textarea
              v-model="branchAddress"
              placeholder="e.g No 21, Jalan Nusa Bestari 2/3 Taman Nusa Bestari Johor Bahru, Johor"
            ></v-textarea>
              </v-col>
            </v-row>
             <v-row>
              <v-col cols="12" md="4">
                <span class="ml-4">Phone</span>
                <v-subheader>
                  Branch number that user can contact with branch directly</v-subheader
                >
              </v-col>
              <v-col cols="12" md="8" class="px-7">
             <v-text-field
              v-model="branchPhone"
              placeholder="e.g +60167148105"
              clearable
            ></v-text-field>
              </v-col>
            </v-row>

            <v-row>
              <v-col cols="12" md="4">
                <span class="ml-4">Email</span>
                <v-subheader>
                  This email is use for the branch to login</v-subheader
                >
              </v-col>
              <v-col cols="12" md="8" class="px-7">
             <v-text-field
              v-model="email"
              
              clearable
            ></v-text-field>
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
              </v-row>
            
        
            <v-row>
              <v-col cols="12" md="4">
                <span class="ml-4">Time gap</span>
                <v-subheader>
                  e.g. 15 min slots will show open slots at 8:00, 8:15, 8:30
                  etc.</v-subheader
                >
              </v-col>
              <v-col cols="12" md="2" class="px-7">
                <v-text-field v-model="branchGap" suffix="min"></v-text-field>
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="12" md="4">
                <span class="ml-4">Working day</span>
                <v-subheader
                  >Check the day for you business day. Left uncheck for
                  clossing</v-subheader
                >
              </v-col>
              <v-col cols="12" md="7" class="px-7">
                <v-select
                  v-model="realWorkingDay"
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
                <span class="ml-4">Business hour</span>
                <v-subheader
                  >Pick the start and end time of your business operation
                </v-subheader>
              </v-col>
              <v-col cols="12" md="7" class="px-7">
                <v-row>
                  <v-col cols="6">
                    <v-menu
                      ref="menu1"
                      v-model="startMenu"
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
                          v-model="branchStartTime"
                          prepend-icon="mdi-clock-time-four-outline"
                          readonly
                          v-bind="attrs"
                          v-on="on"
                        ></v-text-field>
                      </template>
                      <v-time-picker
                        v-if="startMenu"
                        v-model="branchStartTime"
                        full-width
                        @click:minute="$refs.menu1.save(time)"
                      ></v-time-picker>
                    </v-menu>
                  </v-col>
                  <!-- <v-col cols="2">
                   <v-subheader>to</v-subheader>
                  </v-col> -->
                   
                  <v-col cols="6">
                    <v-menu
                      ref="menu2"
                      v-model="endMenu"
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
                          v-model="branchEndTime"
                          prepend-icon="mdi-clock-time-four-outline"
                          readonly
                          v-bind="attrs"
                          v-on="on"
                        ></v-text-field>
                      </template>
                      <v-time-picker
                        v-if="endMenu"
                        v-model="branchEndTime"
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
                <span class="ml-4">Redirect</span>
                <v-subheader
                  >Allow customer to redirect to send their booking to branch
                  through whatsapp</v-subheader
                >
              </v-col>
              <v-col cols="12" md="1" class="px-7">
                <v-switch v-model="branchRedirect" ></v-switch>
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="12" md="4">
                <span class="ml-4">Auto Approve</span>
                <v-subheader
                  >Allow to approve customer booking automatically </v-subheader
                >
              </v-col>
              <v-col cols="12" md="1" class="px-7">
                <v-switch v-model="branchAutoApprove"></v-switch>
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="12" md="4">
                <span class="ml-4">Status</span>
                <v-subheader
                  >Represent the branch status show on customer selection when branch is active  </v-subheader
                >
              </v-col>
              <v-col cols="12" md="1" class="px-7">
                <v-switch v-model="branchStatus"></v-switch>
              </v-col>
            </v-row>
          </v-col>
        </v-row>
        
        <v-row class="text-center mr-n7">
          <v-col>
            <v-btn color="blue darken-1" @click="addBranchToCompany()"> Add </v-btn>
            <v-btn color="success" @click="updateBranch()"> Save </v-btn>
            <v-btn color="error" @click.stop="confirmDeleteDialog = true">
              Delete
            </v-btn>
            <v-dialog v-model="confirmDeleteDialog" max-width="290">
              <v-card>
                <v-card-title> Are you confirm to delete? </v-card-title>

                <v-card-text>
                  <span class="font-weight-medium"
                    >The selected branch and it's information will be delete</span>
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
                    @click="deleteBranch()"
                  >
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
  
  name: "DashboardFormsWizard",
  

  data: () => ({
    domain: BASEURL,
    startTime: null,
    endTime: null,
    startMenu: false,
    endMenu: false,
    day: [
      "Sunday",
      "Monday",
      "Tuesday",
      "Wednesday",
      "Thursday",
      "Friday",
      "Saturday",
    ],
    branchItem:'',
    selected:'',
    branchName:'',
    branchAddress:'',
    branchPhone:'',
    branchGap:15,
    branchWorkingDay:'',
    branchWorkingTime:'',
    branchStartTime:'',
    branchEndTime:'',
    branchRedirect:0,
    branchAutoApprove:0,
    searchBranch:'',
    time:'',
    realWorkingDay:[],
    confirmDeleteDialog:false,
    timeout: 2000,
    snackbar: false,
    text: "",
    showPassword: false,
    email:'',
    password:'',
    branchStatus:'',
    addBranchId:'',
    

    

  }),
  created(){
    
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);

    if (urlParams.has("id")) {
      const id = urlParams.get("id");
      this.company_id = id;
      this.getCompanyBranch();
    }

  },
  watch:{
    selected(){
      this.getBranchDetail();
      
    },
    searchBranch() {
      this.searchBranchByName();
    },
    branchRedirect(){
      this.changeRedirectFormat();
    },
    branchAutoApprove(){
      this.changeAutoApproveFormat();
    },
    branchStatus(){
      this.changeStatusFormat();
    }



  },
  computed: {
      workingDayCheck(){
         var value = [];

          if (this.branchWorkingDay[0] == 0) {
            value.push("Sunday");
          }
          if (this.branchWorkingDay[1] == 0) {
            value.push("Monday");
          }
          if (this.branchWorkingDay[2] == 0) {
            value.push("Tuesday");
          }
          if (this.branchWorkingDay[3] == 0) {
            value.push("Wednesday");
          }
          if (this.branchWorkingDay[4] == 0) {
            value.push("Thursday");
          }
          if (this.branchWorkingDay[5] == 0) {
            value.push("Friday");
          }
          if (this.branchWorkingDay[6] == 0) {
            value.push("Saturday");
          }

          return value;
    },
    saveWorkingDay(){
      var day = [0,0,0,0,0,0,0];

      if(!this.realWorkingDay.includes("Sunday")){
        day[0]=1;
      }
      if(!this.realWorkingDay.includes("Monday")){
        day[1]=1;
      }
      if(!this.realWorkingDay.includes("Tuesday")){
        day[2]=1;
      }
      if(!this.realWorkingDay.includes("Wednesday")){
        day[3]=1;
      }
      if(!this.realWorkingDay.includes("Thursday")){
        day[4]=1;
      }
      if(!this.realWorkingDay.includes("Friday")){
        day[5]=1;
      }
      if(!this.realWorkingDay.includes("Saturday")){
        day[6]=1;
      }
  
      return day;
    },
    saveWorkingTime(){
      var time=[];
      
      time.push('"'+this.branchStartTime+'"');
      time.push('"'+this.branchEndTime+'"');
      
      return time;

    }
  

  },

  methods: {
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
    getBranchDetail(){
         this.branchName = '';
         this.branchAddress = '';
         this.branchPhone = '';
         this.branchGap = 15;
         this.branchWorkingTime = '';
         this.branchStartTime = '';
         this.branchEndTime = '';
         this.branchWorkingDay = '';
         this.realWorkingDay='';
         this.branchRedirect =0;
         this.branchAutoApprove =0;
         this.branchStatus=0;
      
      for (var i = 0; i < this.branchItem.length; i++) {
        if (this.branchItem[i].branch_id == this.selected) {
          this.branchName = this.branchItem[i].name;
          this.branchAddress = this.branchItem[i].address;
          this.branchPhone = this.branchItem[i].phone_number;
          this.branchGap = this.branchItem[i].gap;
          this.branchWorkingTime = JSON.parse(this.branchItem[i].working_time);
          this.branchStartTime = this.branchWorkingTime[0];
          this.branchEndTime = this.branchWorkingTime[1];
          this.branchWorkingDay = JSON.parse(this.branchItem[i].working_day);
          this.realWorkingDay = this.workingDayCheck;
          this.branchRedirect = this.branchItem[i].redirect;
          this.branchAutoApprove =this.branchItem[i].auto_approve;
          this.branchStatus = this.branchItem[i].status;
        }

      } 
      
    },
    addBranchToCompany(){
      const params = new URLSearchParams();
      params.append("create", "done");
      params.append("company_id", this.company_id);
      params.append("name", this.branchName);
      params.append("address", this.branchAddress);
      params.append("gap", this.branchGap);
      params.append("working_day", '['+this.saveWorkingDay +']');
      params.append("working_time", '['+this.saveWorkingTime +']');
      params.append("redirect", this.branchRedirect);
      params.append("phone_number", this.branchPhone);
      params.append("auto_approve", this.branchAutoApprove);
      params.append("status", this.branchStatus);

      axios({
        method: "post",
        url: this.domain + "/branch/index.php",
        data: params,
      })
        .then((response) => {
          console.log(response);
          if (response.data.status == "1") {
            this.addBranchId = response.data.branch;
            this.addBranchUser();
            this.snackbar = true;
            this.text = "Successfully add branch";
            this.getCompanyBranch();
          } else {
            this.snackbar = true;
            this.text = "Something went wrong! Please check your information";
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
    changeRedirectFormat(){
      if(this.branchRedirect==true){
        this.branchRedirect=1;
      }
      else{
        this.branchRedirect=0;
      }
    },
    changeAutoApproveFormat(){
        if(this.branchAutoApprove==true){
        this.branchAutoApprove=1;
      }
      else{
        this.branchAutoApprove=0;
      }
    },
    changeStatusFormat(){
        if(this.branchStatus==true){
        this.branchStatus=1;
      }
      else{
        this.branchStatus=0;
      }
    },
    deleteBranch(){
      const params = new URLSearchParams();
      params.append("delete", "done");
      params.append("branch_id", this.selected);

      axios({
        method: "post",
        url: this.domain + "/branch/index.php",
        data: params,
      })
        .then((response) => {
          console.log(response);
          if (response.data.status == "1") {
            this.confirmDeleteDialog = false;
            this.snackbar = true;
            this.text = "Delete Branch Successful";
            this.getCompanyBranch();
          } else {
            this.confirmDeleteDialog = false;
            this.snackbar = true;
            this.text = "Something Went Wrong! Delete failed ";
            
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
     updateBranch(){
      const params = new URLSearchParams();
      params.append("update", "done");
      params.append("branch_id", this.selected);
      params.append("name", this.branchName);
      params.append("address", this.branchAddress);
      params.append("gap", this.branchGap);
      params.append("working_day", '['+this.saveWorkingDay +']');
      params.append("working_time", '['+this.saveWorkingTime +']');
      params.append("redirect", this.branchRedirect);
      params.append("phone_number", this.branchPhone);
      params.append("auto_approve", this.branchAutoApprove);
      params.append("status", this.branchStatus);

      axios({
        method: "post",
        url: this.domain + "/branch/index.php",
        data: params,
      })
        .then((response) => {
          console.log(response);
          if (response.data.status == "1") {
            this.confirmDeleteDialog = false;
            this.snackbar = true;
            this.text = "Update Branch Successful";
            this.getCompanyBranch();
          } else {
            this.confirmDeleteDialog = false;
            this.snackbar = true;
            this.text = "Something Went Wrong! Update failed ";
            
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
    searchBranchByName() {
      const params = new URLSearchParams();
      params.append("searchBranchByName", "done");
      params.append("company_id", this.company_id);
      params.append("search_branch", this.searchBranch);

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
            console.log("No branch found");
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
    addBranchUser(){
      const params = new URLSearchParams();
      params.append("addBranchUser", "done");
      params.append("company_id", this.company_id);
      params.append("branch_id", this.addBranchId);
      params.append("email", this.email);
      params.append("password", this.password);

      axios({
        method: "post",
        url: this.domain + "/user/index.php",
        data: params,
      })
        .then((response) => {
          console.log(response);
          if (response.data.status == "1") {
            console.log("branch user is successfully add")
          } else {
            console.log("no branch user is add");
          }
        })
        .catch((error) => {
          console.log(error);
        });
      
    }

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
