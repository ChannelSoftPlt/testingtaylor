<template >
  <div :style="{ backgroundImage: createBackgroundString ,height: backgroundHeight}" >
      <v-row class="pt-5">
         <v-col cols="12" md="6" align="center">
            <h3 :class="headerTextColor">Company Name</h3>
         </v-col>
         <v-col  cols="12" md="6" align="center">
            
            <a :class="headerTextColor"><h3 class="hidden-sm-and-down"><v-icon
      medium
      color="green lighten-2"
    >
      mdi-phone
    </v-icon>Contact Us</h3></a>
         </v-col>
      </v-row>
      <v-row class="my-12">
        <v-col cols="12" md="4"></v-col>
        <v-col cols="12" md="4" align="center">
          <h2 :class="headerTextColor">Book Appointment Now!</h2>
          <p class="px-9"><span :class=" descriptionTextColor ">Make an appointment with us now to save your time </span> </p>
        </v-col>
        <v-col cols="12" md="4"></v-col>

      </v-row>
        
        <v-row>
          <v-col cols="12" md="4" ></v-col>

        <v-col cols="12" md="4" class="mb-16">
       <v-stepper v-model="e6" vertical class="mx-3 grey lighten-5" >
    <v-stepper-step
      :complete="e6 > 1"
      step="1"
      :color="stepButtonColor"
      
    >  
      Choose a Branch
    </v-stepper-step>

    <v-stepper-content step="1" >
  
      

        <v-select
          :items="items"
          label="Branch"
          v-model="selectedBranch"
        ></v-select>
      
      
      <v-btn
        :color="continueButtonColor"
        outlined
        @click="e6 = 2"
      >
        Continue
      </v-btn>
      
    </v-stepper-content>

    <v-stepper-step
      :complete="e6 > 2"
      step="2"
      :color="stepButtonColor"
    >
      Pick a date
    </v-stepper-step>

    <v-stepper-content step="2">
        <vc-date-picker v-model='selectedDate' color="purple" is-expanded  />
    <br>
    <br> 
      <v-btn
        :color="continueButtonColor"
        outlined
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
      :color="stepButtonColor"
    >
      Choose a time
    </v-stepper-step>

    <v-stepper-content step="3">
      <v-row class="mb-2"> 
      <v-col
        cols="4"
        sm="12"
      
        
      >
      <p >Morning</p>
      <v-row>
      <div v-for="(time, i) in time"
          :key="i" >
        
        <v-btn
      class="mb-2 mt-1 mr-1 ml-3"
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
      </v-row>
      </v-col>
      <v-col
        cols="4"
        sm="12"
  
      >
      <p>Noon</p>
      <v-row>
        <div v-for="(time, i) in time"
          :key="i">
        <v-btn
      class="mb-2 mt-1 mr-1 ml-3"
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
      </v-row>
      </v-col>
      <v-col
        cols="4"
        sm="12"
  
      >
      <p>Night</p>
      <v-row>
        <div v-for="(time, i) in time"
          :key="i">
        <v-btn
      class="mb-2 mt-1 mr-1 ml-3"
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
      </v-row>
    
      </v-col>
      </v-row>
      <v-btn text @click="e6 = 2">
        Back
      </v-btn>
    </v-stepper-content>
    <v-stepper-step
      :complete="e6 > 4"
      step="4"
      :color="stepButtonColor"
    >
      Total person
    </v-stepper-step>
    <v-stepper-content step="4">
    <v-checkbox
      v-model="selectedPerson"
      :color="stepButtonColor"
      :label="pax.text+' pax'" 
      :value="pax.text"
      v-for="(pax, i) in pax"
          :key="i"
   ></v-checkbox>

   <v-btn
        :color="continueButtonColor"
        outlined
        @click="e6 = 5"
      >
        Continue
      </v-btn>
      <v-btn text @click="e6 = 3">
        Back
      </v-btn>
</v-stepper-content>
<v-stepper-step
      step="5"
      :color="stepButtonColor"
    >  
      Your Info 
    </v-stepper-step>

    <v-stepper-content step="5" >
       
        <v-card-title>
          <v-icon>mdi-account</v-icon><span>Customer Information</span>
        </v-card-title>
        <v-form
        class="mb-2"
        ref="form"
    v-model="valid"
    lazy-validation>
            <v-row >
              <v-col
                cols="12"
                sm="4"
                md="6"
              >
                <v-text-field
                  label="First name"
                  v-model="firstname" 
                  :rules="firstnameRules"
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
                  :rules="lastnameRules"
                   required
                ></v-text-field>
              </v-col>
               <v-col 
              cols="12"
              sm="8">
                <v-text-field
                  v-model="email"
                  label="Email"
                  :rules="emailRules"
                  hint="example@hotmail.com"
                  required
                ></v-text-field>
              </v-col>
              
              <v-col
                cols="12"
                sm="4"
              >
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
                  value="Remind me earlier"
                  v-model="remark"
                  clear-icon="mdi-close-circle"
                  label="Remark"
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
      <v-btn text @click="e6 = 4">
        Back
      </v-btn>
      
    </v-stepper-content>
    

    <v-dialog
      v-model="dialog"
      persistent
      max-width="600px"
    >
    <v-card>
        <v-card-title>
          <v-container>
           <v-icon class="light-green--text">mdi-check-circle-outline</v-icon>Comfirm your booking
          </v-container>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col sm="3"> Branch : </v-col>
              <v-col sm="3">{{selectedBranch}} </v-col>
            </v-row>
            <v-row>
              <v-col sm="3"> Date and Time : </v-col>
              <v-col sm="9">{{selectedDate}}{{selectedTime}}</v-col>
            </v-row>
            <v-row>
              <v-col sm="3"> Total person : </v-col>
              <v-col sm="3"> {{selectedPerson}} </v-col>
            </v-row>
            <v-row>
              <v-col sm="3"> Your info : </v-col>
              <v-col sm="9"> {{firstname}}{{lastname}} 
                        <br>
                        {{email}}
                        <br>
                        {{phoneNumber}}
                        <br>
                        {{remark}}</v-col>
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
            @click="dialog = false , submit_data"
          >
            Submit
          </v-btn>
        </v-card-actions>
    </v-card>
      
    </v-dialog>
      
      
      
       
    
  </v-stepper>
  </v-col>

    <v-col cols="12" md="4"></v-col>
        </v-row>

    <v-row class="pt-16  pb-2 ">
        <v-col cols="12" md="6" align="center" >
               <p :class="headerTextColor">@2021 | <a href="https://channelsoft.com.my/" style="text-decoration: none;" :class="headerTextColor"> Channel Soft PLT. </a></p>
              
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
        { text: '18:30'},
        { text: '19:00'},
        { text: '19:30'},
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
      remarkRules: [
        v => !!v || 'Remark is required',
        v => v.length <= 200 || 'Max 200 characters'
       ],
      firstnameRules: [v => !!v || 'Firstname is required'],
      lastnameRules: [v => !!v || 'Lastname is required'],
      emailRules: [
        v => !!v || 'E-mail is required',
        v => /.+@.+\..+/.test(v) || 'E-mail must be valid',
      ], 
      phoneRules: [v => !!v || 'Phone is required'],
      valid:true,
      remark:'',
      angle: '120',
      color1: '#F9A0FA',
      color2: '#558AE9  ',
      backgroundHeight : '102%',
      stepButtonColor: 'deep-purple lighten-1',
      continueButtonColor:'purple lighten-4',
      headerTextColor:'white--text',
      descriptionTextColor:'grey--text text--lighten-2',
      
     
    
  }),
  computed: {
      createBackgroundString() {
      return `linear-gradient(${this.angle}deg, ${this.color1}, ${this.color2})`;
    },
     

     
     
  },
  
  
   methods: {
     validate () {
        this.$refs.form.validate();
        
      },
      submit_data(){
        
      }
     
    
    },
    
  }
</script>