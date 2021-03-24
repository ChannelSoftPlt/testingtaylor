<template>
  <div>

      <v-row class="mt-5">
         <v-col cols="12" md="6" align="center">
            <h3>Company Name</h3>
         </v-col>
         <v-col  cols="12" md="6" align="center">
            
            <h3 class="hidden-sm-and-down"><v-icon
      medium
      color="green darken-2"
    >
      mdi-phone
    </v-icon>Contact Us</h3>
         </v-col>
      </v-row>
      <v-row class="my-12">
        <v-col cols="12" md="4"></v-col>
        <v-col cols="12" md="4" align="center">
          <h2>Book Appointment Now!</h2>
          <p>Make an appointment with us now to save your time </p>
        </v-col>
        <v-col cols="12" md="4"></v-col>

      </v-row>
        <!-- <span>selectedBranch: {{ selectedBranch }}</span>
        <br>
        <span>selectedDate: {{ selectedDate }}</span>
        <br>
        <span>selectedTime: {{ selectedTime }}</span>
        <br>
        <span>selectedPerson: {{ selectedPerson }}</span> -->
        <v-row>
          <v-col cols="12" md="4" ></v-col>
        <v-col cols="12" md="4">
       <v-stepper v-model="e6" vertical>
    <v-stepper-step
      :complete="e6 > 1"
      step="1"
      
    >  
      Choose a Branch
    </v-stepper-step>

    <v-stepper-content step="1" >
  
      

        <v-select
          :items="items"
          label="Branch"
          v-model="selectedBranch"
        ></v-select>
      
        <!-- <v-list rounded>
      <v-list-item-group
        v-model="selectedItem"
        color="primary"
      >
        <v-list-item
          v-for="(item, i) in items"
          :key="i"
        >
          <v-list-item-content>
            <v-list-item-title v-text="item.text"></v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list-item-group>
    </v-list> -->
     
      <v-btn
        color="primary"
        @click="e6 = 2"
      >
        Continue
      </v-btn>
      
    </v-stepper-content>

    <v-stepper-step
      :complete="e6 > 2"
      step="2"
      
    >
      Pick a date
    </v-stepper-step>

    <v-stepper-content step="2">
        <vc-date-picker v-model='selectedDate' color="blue  " is-expanded  />
    <br>
    <br> 
      <v-btn
        color="primary"
        @click="e6 = 3"
      >
        Continue
      </v-btn>
      <v-btn text @click="e6 = 1">
        Back
      </v-btn>
    </v-stepper-content>

    <v-stepper-step
      :complete="e6 > 3"
      step="3"
    >
      Choose a time
    </v-stepper-step>

    <v-stepper-content step="3">
      <v-row>
      <v-col
        cols="4"
        sm="4"
        
        
      >
      <p >Morning</p>
      <div v-for="(time, i) in time"
          :key="i" >
        
        <v-btn
      class="mb-2 mt-1 mr-1"
      outlined
      color="indigo"
      small
      v-model="selectedTime"
        @click="selectedTime=time.text
              e6 = 4"
      v-if="parseFloat(time.text.substring(0,2))<12"
    >
      {{time.text}}
    </v-btn>
  

      </div>
      </v-col>
      <v-col
        cols="4"
        sm="4"
  
      >
      <p>Noon</p>
        <div v-for="(time, i) in time"
          :key="i">
        <v-btn
      class="mb-2 mt-1 mr-1"
      outlined
      color="indigo"
      small
      v-model="selectedTime"
        @click="selectedTime=time.text
              e6 = 4"
      v-if="parseFloat(time.text.substring(0,2))>12"
    >
      {{time.text}}
    </v-btn>

      </div>
    
      </v-col>
      <v-col
        cols="4"
        sm="4"
  
      >
      <p>Night</p>
        <div v-for="(time, i) in time"
          :key="i">
        <v-btn
      class="mb-2 mt-1 mr-1"
      outlined
      color="indigo"
      small
      v-model="selectedTime"
        @click="selectedTime=time.text
              e6 = 4"
      v-if="parseFloat(time.text.substring(0,2))>18"
    >
      {{time.text}}
    </v-btn>

      </div>
    
      </v-col>
      </v-row>
      <v-btn text @click="e6 = 2">
        Back
      </v-btn>
    </v-stepper-content>

    <v-stepper-step step="4">
      Total person
    </v-stepper-step>
    <v-stepper-content step="4">
    <v-checkbox
      v-model="selectedPerson"
      :label="pax.text+' pax'" 
      :value="pax.text"
      v-for="(pax, i) in pax"
          :key="i"
   ></v-checkbox>

    
        <v-dialog
      v-model="dialog"
      persistent
      max-width="600px"
    >
    <template v-slot:activator="{ on, attrs }">
        <v-btn
          color="primary"
          dark
          v-bind="attrs"
          v-on="on"
        >
          Continue
        </v-btn>
     </template>
      
      <v-card>
        <v-card-title>
          <span class="headline">Customer Information</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col
                cols="12"
                sm="5"
                md="6"
              >
                <v-text-field
                  label="First name"
                  v-model="firstname"
                  required
                ></v-text-field>
              </v-col>
              <v-col
                cols="12"
                sm="6"
                md="6"
              >
                <v-text-field
                v-model="lastname"
                  label="Last name"
                ></v-text-field>
              </v-col>
              
              <v-col cols="12">
                <v-text-field
                  v-model="email"
                  label="Email*"
                  hint="example@hotmail.com"
                  required
                ></v-text-field>
              </v-col>
              <v-col
                cols="12"
                sm="6"
              >
                <v-text-field
                    v-model="phoneNumber"
                    :counter="7"
                    :error-messages="errors"
                    label="Phone Number"
                    required
                    ></v-text-field>
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="blue darken-1"
            text
            @click="dialog = false"
          >
            Close
          </v-btn>
          <v-btn
            color="blue darken-1"
            text
            @click="dialog = false"
          >
            submit
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
      
      
      <v-btn text @click="e6 = 3">
        Back
      </v-btn>
       
    </v-stepper-content>
  </v-stepper>
  </v-col>

    <v-col cols="12" md="4"></v-col>
        </v-row>

    <v-row class="mt-16  mb-n16">
        <v-col cols="12" md="6" align="center" >
               <p>@2021 | <a href="https://channelsoft.com.my/" style="text-decoration: none; color: black;"> Channel Soft PLT. </a></p>
              
        </v-col>
    </v-row>
    </div>
</template>

<script>
  import Vue from 'vue';
  import VCalendar from 'v-calendar';
  Vue.use(VCalendar, {
  componentPrefix: 'vc',  // Use <vc-calendar /> instead of <v-calendar />
                  // ...other defaults
});
  export default {
    data: () => ({
     e6:1,
      items: [
        { text: 'Taman Rinting'},
        { text: 'Taman Molek'},
        { text: 'Taman Nusa Bestari'},
        { text: 'Taman Bukit Indah'},
      ], 
       time: [
        { text: '08:00'},
        { text: '08:30'},
        { text: '09:00'},
        { text: '09:30'},
        { text: '10:00'},
        { text: '10:30'},
        { text: '11:00'},
        { text: '11:30'},
        { text: '12:00'},
        { text: '12:30'},
        { text: '13:00'},
        { text: '13:30'},
        { text: '14:00'},
        { text: '14:30'},
        { text: '15:00'},
        { text: '15:30'},
        { text: '16:00'},
        { text: '16:30'},
        { text: '17:00'},
        { text: '17:30'},
        { text: '18:00'},
      ],
      pax: [
        { text: '1-2'},
        { text: '3-4'},
        { text: '5-6'},
        { text: '7-8'},
        { text: '9-10'},
       
      ],
      dialog: false,
      email:'',
      firstname:'',
      lastname:'',
      phoneNumber:'',
      errors:'',
      selectedTime:true,
      selectedBranch:'Taman Rinting',
      selectedPerson:'',
      selectedDate:'',
    
  }),
  computed: {


     
     
  },
  
  
   methods: {
     
    
    },
    
  }
</script>