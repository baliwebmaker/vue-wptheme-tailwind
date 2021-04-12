<template>
  <main class="container flex justify-center sm:block pt-24">
    <article v-if="post" class="text-lg px-6 py-6 text-gray-600 mx-auto max-w-2xl">
      <header>
        <responsive-image
          v-if="post.featured_media"
          :media-id="post.featured_media"
          :sizes="'(max-width: 1200px) 100vw, 1200px'"
        />
        <h1 v-html="post.title.rendered"></h1>
        <post-meta :post="post" />
        <post-taxonomies :post="post" />
      </header>
      <div v-html="post.content.rendered"></div>
    </article>
  </main>
</template>

<script>
import ResponsiveImage from '@/components/utility/ResponsiveImage'
import PostMeta from '@/components/utility/PostMeta'
import PostTaxonomies from '@/components/utility/PostTaxonomies'

export default {
  name: 'Single',
  components: { 
    ResponsiveImage,
    PostMeta,
    PostTaxonomies
  },
  props: {
    slug: {
      type: String,
      required: false
    }
  },
  data() {
    return {
      request: {
        type: 'posts',
        slug: this.slug,
        showLoading: true }
    }
  },
  computed: {
    post() {
      return this.$store.getters.singleBySlug(this.request)
    }
  },
  methods: {
    getPost() {
      this.$store.dispatch('getSingleBySlug', this.request).then(() => {
        this.$store.dispatch('updateDocTitle', { parts: [ this.post.title.rendered, this.$store.state.site.name ] })
      })
    }
  },
  created() {
    this.getPost()
  }
}
</script>
