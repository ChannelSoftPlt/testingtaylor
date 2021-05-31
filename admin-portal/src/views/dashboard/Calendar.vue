<template>
  <v-container id="calendar" fluid tag="section">
    <v-row>
      <v-col cols="12" md="2">
        <v-row class="ml-3">
          <h2>Service</h2>
        </v-row>
        <v-card height="900px">
          <v-row class="mx-1 mr-2">
            <v-col cols="12">
              <v-text-field
                v-model="searchService"
                label="Search..."
              ></v-text-field>
            </v-col>
          </v-row>
          <v-list two-line class="overflow">
            <v-list-item-group
              v-model="selectedService"
              active-class="pink--text"
            >
              <template>
                <v-list-item
                  v-for="(item, index) in serviceItem"
                  :key="index"
                  :value="item.service_id"
                >
                  <template>
                    <v-list-item-content>
                      <v-list-item-title
                        v-text="item.title"
                      ></v-list-item-title>
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
            <h2>Service Details</h2>
          </v-col>
        </v-row>

        <v-row>
          <v-col cols="12" class="px-8">
            <v-row>
              <v-col cols="12" md="4">
                <span class="ml-4">Title</span>
                <v-subheader> Your service name </v-subheader>
              </v-col>
              <v-col cols="12" md="8" class="px-7">
                <v-text-field
                  v-model="serviceName"
                  placeholder="e.g Hair Wash"
                  clearable
                ></v-text-field>
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="12" md="4">
                <span class="ml-4">Description</span>
                <v-subheader>
                  Your description that use to describe the service
                </v-subheader>
              </v-col>
              <v-col cols="12" md="8" class="px-7">
                <v-textarea
                  v-model="serviceDescription"
                  placeholder="e.g Our hair wash is using the best shampoo and high professional technology"
                ></v-textarea>
              </v-col>
            </v-row>

            <v-row>
              <v-col cols="12" md="4">
                <span class="ml-4">Seat</span>
                <v-subheader>Total Person that the table can seats</v-subheader>
              </v-col>
              <v-col cols="12" md="2" class="px-7">
                <v-text-field
                  v-model="serviceSeat"
                  suffix="Person"
                ></v-text-field>
              </v-col>
            </v-row>

            <v-row>
              <v-col cols="12" md="4">
                <span class="ml-4">Duration</span>
                <v-subheader
                  >The estimate time your service will take</v-subheader
                >
              </v-col>
              <v-col cols="12" md="2" class="px-7">
                <v-text-field
                  v-model="serviceDuration"
                  suffix="min"
                ></v-text-field>
              </v-col>
            </v-row>

            <v-row>
              <v-col cols="12" md="4">
                <span class="ml-4">Slot</span>
                <v-subheader
                  >Allow for how many times can be book for this service in one
                  day
                </v-subheader>
              </v-col>
              <v-col cols="12" md="2" class="px-7">
                <v-text-field
                  v-model="serviceSlot"
                  suffix="Times"
                ></v-text-field>
              </v-col>
            </v-row>

            <v-row>
              <v-col cols="12" md="4">
                <span class="ml-4">Branch</span>
                <v-subheader
                  >Branch that provide this service to customer</v-subheader
                >
              </v-col>
              <v-col cols="12" md="7" class="px-7">
                <v-select
                  v-model="selectedBranch"
                  :items="branchItem"
                  item-text="name"
                  item-value="branch_id"
                  multiple
                  chips
                >
                  <template v-slot:prepend-item>
                    <v-list-item ripple @click="toggleForBranch">
                      <v-list-item-action>
                        <v-icon
                          :color="
                            selectedBranch.length > 0 ? 'indigo darken-4' : ''
                          "
                        >
                          {{ iconForBranch }}
                        </v-icon>
                      </v-list-item-action>
                      <v-list-item-content>
                        <v-list-item-title> Select All </v-list-item-title>
                      </v-list-item-content>
                    </v-list-item>
                    <v-divider class="mt-2"></v-divider>
                  </template>
                </v-select>
              </v-col>
            </v-row>

            <v-row v-if="selectedBranch != ''">
              <v-col cols="12" md="4">
                <span class="ml-4">Provider</span>
                <v-subheader
                  >Provider that provide this service to customer</v-subheader
                >
              </v-col>
              <v-col cols="12" md="7" class="px-7">
                <v-select
                  v-model="selectedProvider"
                  :items="getProviderItem"
                  item-text="name"
                  item-value="provider_id"
                  multiple
                  chips
                >
                  <template v-slot:prepend-item>
                    <v-list-item ripple @click="toggleForProvider">
                      <v-list-item-action>
                        <v-icon
                          :color="
                            selectedProvider.length > 0 ? 'indigo darken-4' : ''
                          "
                        >
                          {{ iconForProvider }}
                        </v-icon>
                      </v-list-item-action>
                      <v-list-item-content>
                        <v-list-item-title> Select All </v-list-item-title>
                      </v-list-item-content>
                    </v-list-item>
                    <v-divider class="mt-2"></v-divider>
                  </template>
                </v-select>
              </v-col>
            </v-row>

            <v-row>
              <v-col cols="12" md="4">
                <span class="ml-4">status</span>
                <v-subheader
                  >To ensure the availability of the service</v-subheader
                >
              </v-col>
              <v-col cols="12" md="1" class="px-7">
                <v-switch v-model="serviceStatus"></v-switch>
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="12" md="4">
                <span class="ml-4">Color</span>
                <v-subheader
                  >This color set will show on the calendar
                </v-subheader>
              </v-col>
              <v-col cols="12" md="1" class="px-7">
                <v-swatches
                  v-model="serviceColor"
                  show-fallback
                  swatches="text-advanced"
                ></v-swatches>
              </v-col>
            </v-row>
          </v-col>
        </v-row>

        <v-row class="text-center mr-n7">
          <v-col>
            <v-btn
              color="blue darken-1"
              @click="addService()"
              v-if="!selectedService"
            >
              Add
            </v-btn>
            <v-btn
              color="success"
              @click="editService()"
              v-if="selectedService"
            >
              Save
            </v-btn>
            <v-btn
              color="error"
              @click.stop="confirmDeleteDialog = true"
              v-if="selectedService"
            >
              Delete
            </v-btn>
            <v-dialog v-model="confirmDeleteDialog" max-width="290">
              <v-card>
                <v-card-title> Are you confirm to delete? </v-card-title>

                <v-card-text>
                  <span class="font-weight-medium"
                    >The selected service and it's information will be
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

                  <v-btn color="green darken-1" text @click="deleteBranch()">
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
import VSwatches from "vue-swatches";
import "vue-swatches/dist/vue-swatches.css";

export default {
  name: "DashboardCalendar",

  components: {
    VSwatches,
  },

  data: () => ({
    domain: BASEURL,
    company_id: "",
    serviceItem: "",
    searchService: "",
    selectedService: "",
    serviceName: "",
    serviceDescription: "",
    serviceSeat: 0,
    serviceDuration: "",
    serviceSlot: "",
    selectedProvider: "",
    selectedBranch: "",
    serviceStatus: "",
    serviceColor: "",
    snackbar: false,
    confirmDeleteDialog: false,
    text: "",
    timeout: 2000,
    providerItem: [],
    branchItem: [],
    addServiceID: "",
    serviceBranch: [],
    serviceProvider: [],
  }),
  created() {
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);

    if (urlParams.has("id")) {
      const id = urlParams.get("id");
      this.company_id = id;
      this.getServiceByCompany();
      this.getCompanyBranch();
      this.getProviderByCompany();
    }
  },
  watch: {
    serviceStatus() {
      this.changeStatusFormat();
    },
    selectedService() {
      this.getServiceDetail();
    },
  },
  computed: {
    getProviderItem() {
      var array = [];
      for (let i = 0; i < this.providerItem.length; i++) {
        for (let y = 0; y < this.selectedBranch.length; y++) {
          if (this.selectedBranch[y] == this.providerItem[i].branch_id) {
            array.push(this.providerItem[i]);
          }
        }
      }
      return array;
    },
    getAllProviderID() {
      var array = [];
      for (let i = 0; i < this.getProviderItem.length; i++) {
        array.push(this.getProviderItem[i].provider_id);
      }
      return array;
    },

    getAllBranchID() {
      var array = [];
      for (let i = 0; i < this.branchItem.length; i++) {
        array.push(this.branchItem[i].branch_id);
      }
      return array;
    },
    selectAllProvider() {
      return this.selectedProvider.length === this.getAllProviderID.length;
    },
    selectSomeProvider() {
      return this.selectedProvider.length > 0 && !this.selectAllProvider;
    },
    iconForProvider() {
      if (this.selectAllProvider) return "mdi-close-box";
      if (this.selectSomeProvider) return "mdi-minus-box";
      return "mdi-checkbox-blank-outline";
    },
    selectAllBranch() {
      return this.selectedBranch.length === this.getAllBranchID.length;
    },
    selectSomeBranch() {
      return this.selectedBranch.length > 0 && !this.selectAllBranch;
    },
    iconForBranch() {
      if (this.selectAllBranch) return "mdi-close-box";
      if (this.selectSomeBranch) return "mdi-minus-box";
      return "mdi-checkbox-blank-outline";
    },
  },

  methods: {
    toggleForProvider() {
      this.$nextTick(() => {
        if (this.selectAllProvider) {
          this.selectedProvider = [];
        } else {
          this.selectedProvider = this.getAllProviderID.slice();
        }
      });
    },
    toggleForBranch() {
      this.$nextTick(() => {
        if (this.selectAllBranch) {
          this.selectedBranch = [];
        } else {
          this.selectedBranch = this.getAllBranchID.slice();
        }
      });
    },
    changeStatusFormat() {
      if (this.serviceStatus == true) {
        this.serviceStatus = 1;
      } else {
        this.serviceStatus = 0;
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
    getServiceByCompany() {
      const params = new URLSearchParams();
      params.append("getService", "done");
      params.append("company_id", this.company_id);

      axios({
        method: "post",
        url: this.domain + "/service/index.php",
        data: params,
      })
        .then((response) => {
          console.log(response);
          if (response.data.status == "1") {
            this.serviceItem = response.data.service;
          } else {
            console.log("no provider find");
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
    addService() {
      const params = new URLSearchParams();
      params.append("create", "done");
      params.append("title", this.serviceName);
      params.append("description", this.serviceDescription);
      params.append("seat", this.serviceSeat);
      params.append("duration", this.serviceDuration);
      params.append("slot", this.serviceSlot);
      params.append("status", this.serviceStatus);
      params.append("color", this.serviceColor);

      axios({
        method: "post",
        url: this.domain + "/service/index.php",
        data: params,
      })
        .then((response) => {
          console.log(response);
          if (response.data.status == "1") {
            this.addServiceID = response.data.service;
            this.assignProviderToService();
            this.assignBranchToService();
            this.snackbar = true;
            this.text = "Service Add Successfully";
            this.getServiceByCompany();
          } else {
            console.log("add service fail");
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },

    assignProviderToService() {
      for (let i = 0; i < this.selectedProvider.length; i++) {
        const params = new URLSearchParams();
        params.append("create", "done");
        params.append("provider_id", this.selectedProvider[i]);
        params.append("service_id", this.addServiceID);

        axios({
          method: "post",
          url: this.domain + "/tb_link/index.php",
          data: params,
        })
          .then((response) => {
            console.log(response);
            if (response.data.status == "1") {
              console.log("assign provider successfully");
            } else {
              console.log("assign provider fail");
            }
          })
          .catch((error) => {
            console.log(error);
          });
      }
    },

    assignBranchToService() {
      for (let i = 0; i < this.selectedBranch.length; i++) {
        const params = new URLSearchParams();
        params.append("create", "done");
        params.append("branch_id", this.selectedBranch[i]);
        params.append("service_id", this.addServiceID);

        axios({
          method: "post",
          url: this.domain + "/tb_branch_link/index.php",
          data: params,
        })
          .then((response) => {
            console.log(response);
            if (response.data.status == "1") {
              console.log("assign branch successfully");
            } else {
              console.log("assign branch fail");
            }
          })
          .catch((error) => {
            console.log(error);
          });
      }
    },

    getServiceDetail() {
      this.serviceName = "";
      this.serviceDescription = "";
      this.serviceSeat = "";
      this.serviceDuration = "";
      this.serviceSlot = "";
      this.selectedBranch = "";
      this.selectedProvider = "";
      this.serviceStatus = "";
      this.serviceColor = "";

      for (var i = 0; i < this.serviceItem.length; i++) {
        if (this.serviceItem[i].service_id == this.selectedService) {
          this.serviceName = this.serviceItem[i].title;
          this.serviceDescription = this.serviceItem[i].description;
          this.serviceSeat = this.serviceItem[i].seat;
          this.serviceDuration = this.serviceItem[i].duration;
          this.serviceSlot = this.serviceItem[i].slot;
          this.serviceStatus = this.serviceItem[i].status;
          this.serviceColor = this.serviceItem[i].color;
          this.getServiceBranch();
          this.getServiceProvider();
        }
      }
    },
    getServiceBranch() {
      const params = new URLSearchParams();
      params.append("getServiceBranch", "done");
      params.append("service_id", this.selectedService);

      axios({
        method: "post",
        url: this.domain + "/tb_branch_link/index.php",
        data: params,
      })
        .then((response) => {
          console.log(response);
          if (response.data.status == "1") {
            this.serviceBranch = response.data.tb_branch_link;
            var array = [];
            for (let i = 0; i < this.serviceBranch.length; i++) {
              array.push(this.serviceBranch[i].branch_id);
            }
            this.selectedBranch = array;
          } else {
            console.log("No branch can get from the service");
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
    getServiceProvider() {
      const params = new URLSearchParams();
      params.append("getServiceProvider", "done");
      params.append("service_id", this.selectedService);

      axios({
        method: "post",
        url: this.domain + "/tb_link/index.php",
        data: params,
      })
        .then((response) => {
          console.log(response);
          if (response.data.status == "1") {
            this.serviceProvider = response.data.tb_link;
            var array = [];
            for (let i = 0; i < this.serviceProvider.length; i++) {
              array.push(this.serviceProvider[i].provider_id);
            }
            this.selectedProvider = array;
          } else {
            console.log("No provider can get from the service");
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
    editService(){
      const params = new URLSearchParams();
      params.append("update", "done");
      params.append("service_id", this.selectedService);
      params.append("title", this.serviceName);
      params.append("description", this.serviceDescription);
      params.append("seat", this.serviceSeat);
      params.append("duration", this.serviceDuration);
      params.append("slot", this.serviceSlot);
      params.append("status", this.serviceStatus);
      params.append("color", this.serviceColor);
 

      axios({
        method: "post",
        url: this.domain + "/service/index.php",
        data: params,
      })
        .then((response) => {
          console.log(response);
          if (response.data.status == "1") {
            this.snackbar = true;
            this.text = "Editd service successfully"
            this.editServiceBranch();
            this.getServiceByCompany();
            
          } else {
            console.log("edit service failed");
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
    editServiceBranch(){
       this.deleteOriServiceBranch();
       for (let i = 0; i < this.selectedBranch.length; i++) {
        const params = new URLSearchParams();
        params.append("create", "done");
        params.append("branch_id", this.selectedBranch[i]);
        params.append("service_id", this.selectedService);

        axios({
          method: "post",
          url: this.domain + "/tb_branch_link/index.php",
          data: params,
        })
          .then((response) => {
            console.log(response);
            if (response.data.status == "1") {
              console.log("edit Service Branch Successfully");
            } else {
              console.log("edit Service Branch fail");
            }
          })
          .catch((error) => {
            console.log(error);
          });
      }
    },
    deleteOriServiceBranch(){
        const params = new URLSearchParams();
        params.append("delete", "done");
        params.append("service_id", this.selectedService);

        axios({
          method: "post",
          url: this.domain + "/tb_branch_link/index.php",
          data: params,
        })
          .then((response) => {
            console.log(response);
            if (response.data.status == "1") {
              console.log("delete original service branch successfully");
            } else {
              console.log("delete original service branch failed");
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
