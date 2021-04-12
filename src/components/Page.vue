<template>
  <main class="container flex justify-center sm:block pt-24">
    <div v-if="page">
      <div v-html="page.content.rendered"></div>
    </div>
  </main>
</template>

<script>

export default {
  name: 'Page',
  props: {
    slug: {
      type: String,
      required: true
    }
  },
  data() {
    return {
      request: {
        type: 'pages',
        slug: this.slug,
        showLoading: true 
      }
    }
  },
  computed: {
    page() {
      return this.$store.getters.singleBySlug(this.request)
    }
  },
  methods: {
    getPage () {
        this.$store.dispatch('getSingleBySlug', this.request).then(() => {
          if (this.page) {
            this.$store.dispatch('updateDocTitle', { parts: [ this.page.title.rendered, this.$store.state.site.name] })
          } else {
            this.$router.replace('/404')
          }
        })
      }
  },
  created () {
    this.getPage()
  }
}
</script>
