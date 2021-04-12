<template>
  <div 
    id="vue-wordpress-app"
    @click="handleClicks"
    class="bg-gray-200" 
    style="min-height: 640px;"
  >
    <Header
      name="main"
    />
    <transition
      name="fade"
      mode="out-in"
      @after-leave="updateScroll"
    >
    <router-view :key="$route.path" />
    </transition>
    <transition name="fade">
      <site-loading v-if="loading" />
    </transition>
  </div>
</template>

<script>
import Header from '@/components/template-parts/Header'
import SiteLoading from '@/components/utility/SiteLoading'

export default {
  components: {
    Header,
    SiteLoading
  },
  data() {
    return {
      site: this.$store.state.site
    }
  },
  computed: {
    loading() {
      return this.$store.state.site.loading
    },
    logo() {
      if (this.site.logo) {
        return this.$store.getters.singleById({ type: 'media', id: this.site.logo })
      }
    }
  },
  methods: {
    getLinkEl(el) {
      while (el.parentNode) {
        if (el.tagName === 'A') return el
        el = el.parentNode
      }
    },
    handleClicks (e) {
      const a = this.getLinkEl(e.target)
      if (a && a.href.includes(this.site.url)) {
        const { altKey, ctrlKey, metaKey, shiftKey, button, defaultPrevented } = e
        // don't handle if has class 'no-router'
        if (a.className.includes('no-router')) return
        // don't handle with control keys
        if (metaKey || altKey || ctrlKey || shiftKey) return
        // don't handle when preventDefault called
        if (defaultPrevented) return
        // don't handle right clicks
        if (button !== undefined && button !== 0) return
        // don't handle if `target="_blank"`
        if (a.target && a.target.includes('_blank')) return
        // don't handle same page links
        let currentURL = new URL(a.href, window.location.href)
        if (currentURL && currentURL.pathname === window.location.pathname) {
          // if same page link has same hash prevent default reload
          if (currentURL.hash === window.location.hash) e.preventDefault()
          return
        }
        // Prevent default and push to vue-router
        e.preventDefault()
        let path = a.href.replace(this.site.url, '')
        this.$router.push(path)
      }
    },
    updateScroll() {
      window.scroll(0,0)
    }
  }
}
</script>

<style>
/* Vue transition classes
-------------------------------------------- */

.fade-enter-active {
  transition: opacity .4s cubic-bezier(.4,0,0,1);
}

.fade-leave-active {
  transition: opacity .2s cubic-bezier(.4,0,0,1);
}

.fade-enter-to,
.fade-leave {
  opacity: 1;
}

.fade-enter,
.fade-leave-to {
  opacity: 0;
}

</style>
