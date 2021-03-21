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
      <v-btn text>
        Cancel
      </v-btn>
    </v-stepper-content>

    <v-stepper-step
      :complete="e6 > 2"
      step="2"
    >
      Pick a date
    </v-stepper-step>

    <v-stepper-content step="2">
      <v-btn
        icon
        class="ma-2"
        @click="$refs.calendar.prev()"
      >
        <v-icon>mdi-chevron-left</v-icon>
      </v-btn>
      {{today}}

      <v-btn
        icon
        class="ma-2"
        @click="$refs.calendar.next()"
      >
        <v-icon>mdi-chevron-right</v-icon>
      </v-btn>
      <v-sheet height="200">
      <v-calendar
        ref="calendar"
        v-model="value"
        :weekdays="weekday"
        :type="type"
        :events="events"
        :event-overlap-mode="mode"
        :event-overlap-threshold="30"
        :event-color="getEventColor"
        @change="getEvents"
      ></v-calendar>
    </v-sheet>
      <v-btn
        color="primary"
        @click="e6 = 3"
      >
        Continue
      </v-btn>
      <v-btn text>
        Cancel
      </v-btn>
    </v-stepper-content>

    <v-stepper-step
      :complete="e6 > 3"
      step="3"
    >
      Select an ad format and name ad unit
    </v-stepper-step>

    <v-stepper-content step="3">
      <v-card
        color="grey lighten-1"
        class="mb-12"
        height="200px"
      ></v-card>
      <v-btn
        color="primary"
        @click="e6 = 4"
      >
        Continue
      </v-btn>
      <v-btn text>
        Cancel
      </v-btn>
    </v-stepper-content>

    <v-stepper-step step="4">
      View setup instructions
    </v-stepper-step>
    <v-stepper-content step="4">
      <v-card
        color="grey lighten-1"
        class="mb-12"
        height="200px"
      ></v-card>
      <v-btn
        color="primary"
        @click="e6 = 1"
      >
        Continue
      </v-btn>
      <v-btn text>
        Cancel
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
      today: '2019-01-10',
      tracked: {
        '2019-01-09': [23, 45, 10],
        '2019-01-08': [10],
        '2019-01-07': [0, 78, 5],
        '2019-01-06': [0, 0, 50],
        '2019-01-05': [0, 10, 23],
        '2019-01-04': [2, 90],
        '2019-01-03': [10, 32],
        '2019-01-02': [80, 10, 10],
        '2019-01-01': [20, 25, 10],
      },
      colors: ['#1867c0', '#fb8c00', '#000000'],
      category: ['Development', 'Meetings', 'Slacking'],

  }),
  }
</script>