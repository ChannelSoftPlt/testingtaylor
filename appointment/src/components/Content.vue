<template>
   
       <v-stepper
    v-model="e6"
    vertical
  >
    <v-stepper-step
      :complete="e6 > 1"
      step="1"
    >  
      Choose a Branch
    </v-stepper-step>

    <v-stepper-content step="1">
      
        <v-list rounded>
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
    </v-list>
     
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
     <v-row>
        <v-col align="start">
      <v-btn
        icon
        class="ma-2"
        @click="$refs.calendar.prev()"
      >
        <v-icon>mdi-chevron-left</v-icon>
      </v-btn>
        </v-col>
       <v-col align="center">
         <v-toolbar-title v-if="$refs.calendar">
            {{ $refs.calendar.title }}
          </v-toolbar-title>
       </v-col>
        <v-col align="end">
      <v-btn
        icon
        class="ma-2"
        @click="$refs.calendar.next()"
      >
        <v-icon>mdi-chevron-right</v-icon>
      </v-btn>
      </v-col>
     </v-row>
      <v-sheet height="200">
      <v-calendar
        ref="calendar"
        v-model="value"
        :type="type"
        color="primary"
      ></v-calendar>
    </v-sheet>
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
        cols="12"
        sm="6"
        align="left"
      >
        <v-btn
      class="mb-2 mt-1 mr-1"
      outlined
      color="indigo"
      small
      v-for="(time, i) in time"
          :key="i"
      
    >
      {{time.text}}
    </v-btn>
      </v-col>
      </v-row>
      <v-btn
        color="primary"
        @click="e6 = 4"
      >
        Continue
      </v-btn>
      <v-btn text @click="e6 = 2">
        Back
      </v-btn>
    </v-stepper-content>

    <v-stepper-step step="4">
      Total person
    </v-stepper-step>
    <v-stepper-content step="4">
    <v-checkbox
      v-model="selected"
      :label="pax.text+' pax'" 
      :value="pax.text"
      v-for="(pax, i) in pax"
          :key="i"
    ></v-checkbox>
      <v-btn
        color="primary"
        @click="e6 = 1"
      >
        Submit
      </v-btn>
      <v-btn text @click="e6 = 3">
        Back
      </v-btn>
    </v-stepper-content>
  </v-stepper>
   
</template>

<script>
  export default {
    data: () => ({
     e6:1,
     selectedItem: 1,
      items: [
        { text: 'Taman Rinting'},
        { text: 'Taman Molek'},
        { text: 'Taman Nusa Bestari'},
        { text: 'Taman Bukit Indah'},
      ],  
      type: 'month',
      value: '',
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
        { text: '01:00'},
        { text: '01:30'},
        { text: '02:00'},
        { text: '02:30'},
        { text: '03:00'},
        { text: '03:30'},
        { text: '04:00'},
        { text: '04:30'},
        { text: '05:00'},
        { text: '05:30'},
        { text: '06:00'},
      ],
      selected: [],
      pax: [
        { text: '1-2'},
        { text: '3-4'},
        { text: '5-6'},
        { text: '7-8'},
        { text: '9-10'},
       
      ],
    
  }),
  
   methods: {
      
    },
  }
</script>