<template>
  <v-container id="calendar" fluid tag="section">
    <v-row>
      <v-col cols="12" md="2">
        <v-row class="ml-3">
          <h2>Service</h2>
        </v-row>
        <v-card height="800px">
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
            <v-list-item-group v-model="selected" active-class="pink--text">
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
                  v-model="branchName"
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
                  v-model="branchAddress"
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
                  v-model="branchGap"
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
                <v-text-field v-model="branchGap" suffix="min"></v-text-field>
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
                <v-text-field v-model="branchGap" suffix="Times"></v-text-field>
              </v-col>
            </v-row>

            <!-- <v-row>
              <v-col cols="12" md="4">
                <span class="ml-4">Provider</span>
                <v-subheader
                  >Provider that provide this service to customer</v-subheader
                >
              </v-col>
              <v-col cols="12" md="7" class="px-7">
                <v-select v-model="selectedFruits" :items="fruits" multiple chips>
                  <template v-slot:prepend-item>
                    <v-list-item ripple @click="toggle">
                      <v-list-item-action>
                        <v-icon
                          :color="
                            selectedFruits.length > 0 ? 'indigo darken-4' : ''
                          "
                        >
                          {{ icon }}
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
            </v-row> -->
            <v-row>
              <v-col cols="12" md="4">
                <span class="ml-4">status</span>
                <v-subheader
                  >To ensure the availability of the service</v-subheader
                >
              </v-col>
              <v-col cols="12" md="1" class="px-7">
                <v-switch v-model="branchRedirect" ></v-switch>
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
                <v-swatches v-model="color" swatches="text-advanced"></v-swatches>

              </v-col>
            </v-row>
          </v-col>
        </v-row>

        <v-row class="text-center mr-n7">
          <v-col>
            <v-btn color="blue darken-1" @click="addBranchToCompany()">
              Add
            </v-btn>
            <v-btn color="success" @click="updateBranch()"> Save </v-btn>
            <v-btn color="error" @click.stop="confirmDeleteDialog = true">
              Delete
            </v-btn>
            <v-dialog v-model="confirmDeleteDialog" max-width="290">
              <v-card>
                <v-card-title> Are you confirm to delete? </v-card-title>

                <v-card-text>
                  <span class="font-weight-medium"
                    >The selected branch and it's information will be
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
// Components
import VSwatches from 'vue-swatches'
import 'vue-swatches/dist/vue-swatches.css'

export default {
  name: "DashboardCalendar",

  components: {
     VSwatches 
  },

  data: () => ({
    fruits: [
        'Apples',
        'Apricots',
        'Avocado',
        'Bananas',
        'Blueberries',
        'Blackberries',
        'Boysenberries',  
      ],
      selectedFruits: [],
      color: '#1CA085',
  }),
  created(){
    


  },
  watch:{

    branchRedirect(){
      this.changeRedirectFormat();
  

    }

  },
  computed: {
      likesAllFruit () {
        return this.selectedFruits.length === this.fruits.length
      },
      likesSomeFruit () {
        return this.selectedFruits.length > 0 && !this.likesAllFruit
      },
      icon () {
        if (this.likesAllFruit) return 'mdi-close-box'
        if (this.likesSomeFruit) return 'mdi-minus-box'
        return 'mdi-checkbox-blank-outline'
      },
    },

    methods: {
      toggle () {
        this.$nextTick(() => {
          if (this.likesAllFruit) {
            this.selectedFruits = []
          } else {
            this.selectedFruits = this.fruits.slice()
          }
        })
      },
      changeRedirectFormat(){
      if(this.branchRedirect==true){
        this.branchRedirect=1;
      }
      else{
        this.branchRedirect=0;
      }
    },
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
