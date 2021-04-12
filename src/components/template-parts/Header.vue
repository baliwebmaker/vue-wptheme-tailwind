<template>
<div id="main-navigation" class="fixed w-full z-10 top-0">
  <div class="md:px-8 ">
    <nav class="hidden md:block flex-1 "> 
      <div class="container flex items-center justify-between">
        <router-link class="inline-block" to="/">
            <span class="sr-only">{{ site.name }}</span>
            <img class="h-6 md:h-8" src="https://d33wubrfki0l68.cloudfront.net/c07183f9fe31fb422dfa12ae010c99b46901d761/459c1/images/themesdev-logo-dark.svg" alt="Themes.dev Logo" title="Themes.dev Logo">
        </router-link>
        <div class="" id="topmenu">
        <ul class="flex">
          <router-link class="ml-4 rounded-full flex py-1 px-1 text-indigo-600 hover:underline xlink
          " to="/best"><span>{{ site.name }}</span></router-link>
          <li v-for="item in menu" >
            <a
              :key="item.id"
              :href="item.url"
              :target="item.target"
              :title="item.title"
              v-html="item.content"
            ></a>
          </li>
        </ul>
        </div>
      </div>
    </nav>

    <nav class="md:hidden flex-1">
        <div class="container flex items-center justify-between px-4 pt-4 pb-6">
          <router-link class="inline-block" to="/">
            <span class="sr-only">{{ site.name }}</span>
            <img class="h-6 md:h-8" src="https://d33wubrfki0l68.cloudfront.net/c07183f9fe31fb422dfa12ae010c99b46901d761/459c1/images/themesdev-logo-dark.svg" alt="Themes.dev Logo" title="Themes.dev Logo">
          </router-link>  
          <button
          ref="openButton"
          class="block md:hidden w-8 h-8 text-gray-600"
          aria-label="Menu"
          @click="open()" 
          >
            <svg fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path></svg>
          </button>
        </div>
        <!-- black bg opacity 
        <div :class="isNavopen ? 'bg-black opacity-25 absolute':'opacity-100'" class=" top-0 left-0 h-screen w-screen"></div>
-->

      <!-- Off-canvas menu background overlay -->
      <transition
        enter-class="opacity-0"
        enter-active-class="ease-out transition-medium"
        enter-to-class="opacity-100"
        leave-class="opacity-100"
        leave-active-class="ease-out transition-medium"
        leave-to-class="opacity-0"
      >
        <div v-show="isNavopen" class="z-10 fixed inset-0 transition-opacity">
          <div
            @click="close"
            class="absolute inset-0 bg-black opacity-50"
            tabindex="-1"
          ></div>
        </div>
      </transition>

    <!-- Off-canvas menu class="z-10 fixed inset-y-0 right-0 max-w-xs w-full bg-white transition-transform overflow-y-auto" -->
        <div 
        class="transform ease-in-out transition-all duration-30 absolute bg-white top-0 right-0 z-10 max-w-xs w-full h-screen overflow-y-auto"
        :class="isNavopen ? 'translate-x-0' : 'translate-x-full'"  
        >
            <div class="px-4 pt-4 pb-6">
              <div class="absolute top-0 right-0 p-4 block">
                <button
                ref="closeButton"
                @click="close"
                type="button"
                class="text-gray-600 focus:outline-none focus:text-gray-900"
                aria-label="Close"
                >
                  <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
              </div>
            <img class="h-6 md:h-8" src="https://d33wubrfki0l68.cloudfront.net/c07183f9fe31fb422dfa12ae010c99b46901d761/459c1/images/themesdev-logo-dark.svg" alt="Themes.dev Logo" title="Themes.dev Logo">
              <a v-for="item in menu"
                :key="item.id"
                :href="item.url"
                :target="item.target"
                :title="item.title"
                v-html="item.content"
                class="mt-8 block text-xs font-semibold text-gray-600 uppercase tracking-wider"
              ></a>

            </div>
        </div>

    </nav>
  </div>


</div>
</template>
<script>
export default {
  props: {
    name: {
      type: String,
      required: true
    }
  },
  data() {
    return {
      isNavopen : false,
      site: this.$store.state.site
    }
  },
  methods: {
    open() {
        this.isNavopen = true
        this.$nextTick(() => {
          this.$refs.closeButton.focus()
        })
      },
    close() {
        this.isNavopen = false
        this.$nextTick(() => {
          this.$refs.openButton.focus()
        })
    }
  },
  computed: {
    menu() {
      return this.$store.getters.menu({ name: this.name })
    }
  },
  watch: {
      isNavopen: {
        immediate: true,
        handler(isNavopen) {
          if (isNavopen) {
            document.body.style.setProperty('overflow', 'hidden')
          } else {
            document.body.style.removeProperty('overflow')
          }
        }
      },
      $route (to, from){
        this.isNavopen = false;
      }
    }
}
</script>
<style scoped>

.xlink{
  padding: 0.35rem 1.5rem !important;
  color: #2880ce !important;
  background-color: #fff;
  border: 1px solid #2880ce;
}
#topmenu ul li{
  cursor: pointer;
  font-weight: bold;
  color: #2880ce;
  padding: 0.25rem 1rem;
}

</style>