<template>
  <v-footer
    id="pages-core-footer"
    absolute
    color="transparent"
    dark
  >
    <v-container>
      <v-row
        align="center"
        no-gutters
      >
        <!-- <v-col
          v-for="(link, i) in links"
          :key="i"
          class="text-center"
          cols="6"
          md="auto"
        >
          <a
            :href="link.href"
            class="mr-0"
            rel="noopener"
            target="_blank"
            v-text="link.text"
          />
        </v-col> -->

        <v-spacer class="hidden-sm-and-down" />

        <v-col
          cols="12"
        >
          <div class="body-1 font-weight-light pt-6 pt-md-0 text-center">
            <p>Copyright &copy; 2020 <a href="https://channelsoft.com.my/" style="color:white!important; font-size:14px!important;">Channel Soft PLT</a>. All Rights Reserved</p>
          </div>
        </v-col>
      </v-row>
    </v-container>
  </v-footer>
</template>

<script>
  export default {
    name: 'PagesCoreFooter',

    data: () => ({
      links: [
        {
          href: '#',
          text: 'Creative Tim'
        },
        {
          href: '#',
          text: 'About Us'
        },
        {
          href: '#',
          text: 'Blog'
        },
        {
          href: '#',
          text: 'Licenses'
        }
      ]
    })
  }
</script>

<style lang="sass">
  #pages-core-footer
    a
      color: #FFFFFF
      font-size: .825rem
      font-weight: 500
      text-decoration: none
      text-transform: uppercase
</style>
