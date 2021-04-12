<template>
<b-container><main>
    <div v-if="specialpackage">
      <h1 v-html="specialpackage.title.rendered"></h1>
      <div v-html="specialpackage.content.rendered"></div>
    </div>
  </main></b-container>
</template>

<script>

export default {
  name: 'SpecialPackage',
  props: {
    slug: {
      type: String,
      required: false
    }
  },
  data() {
    return {
      request: {
        type: 'special_package',
        slug: this.slug,
        showLoading: true 
      }
    }
  },
  computed: {
    specialpackage() {
      return this.$store.getters.singleBySlug(this.request)
    }
  },
  methods: {
    getSpecialPackage () {
        this.$store.dispatch('getSingleBySlug', this.request).then(() => {
          if (this.specialpackage) {
            this.$store.dispatch('updateDocTitle', { parts: [ this.specialpackage.title.rendered, this.$store.state.site.name] })
          } else {
            this.$router.replace('/404')
          }
        })
      }
  },
  created () {
    this.getSpecialPackage()
  }
}
</script>
