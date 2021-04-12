<template>
  <article class="container flex justify-center sm:block pt-24">
    <responsive-image
      v-if="post"
      class="post__featured-media"
      :media-id="post"
      :sizes="'(max-width: 680px) 40vw, 400px'"
    />
    <div>
      <h2 class="text-xl font-semibold">
        <a 
          :href="post.link"
          :title="post.title.rendered"
          v-html="post.title.rendered"
        ></a>
      </h2>
      <post-meta :post="post" />
      <div v-html="post.excerpt.rendered"></div>
      <post-taxonomies :post="post" />
    </div>
  </article>
</template>

<script>
import ResponsiveImage from '@/components/utility/ResponsiveImage'
import PostMeta from '@/components/utility/PostMeta'
import PostTaxonomies from '@/components/utility/PostTaxonomies'

export default {
  name: 'PostItem',
  components: {
    ResponsiveImage,
    PostMeta,
    PostTaxonomies
  },
  props: {
    post: {
      type: Object,
      required: true
    }
  },
  data() {
    return {}
  }
}
</script>

<style>
</style>
