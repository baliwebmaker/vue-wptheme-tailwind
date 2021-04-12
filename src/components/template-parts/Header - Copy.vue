<template>
<div>
  <div class="md:px-8 ">
    <nav class="relative flex flex-wrap items-center justify-between md:py-4"> 
      <div class="relative z-10 flex-shrink-0 pl-4 py-4 md:p-0">
      <router-link class="inline-block" to="/">
          <span class="sr-only">{{ site.name }}</span>
          <img class="h-6 md:h-8" src="https://d33wubrfki0l68.cloudfront.net/c07183f9fe31fb422dfa12ae010c99b46901d761/459c1/images/themesdev-logo-dark.svg" alt="Themes.dev Logo" title="Themes.dev Logo">
      </router-link>
      </div>

      <div class="hidden md:block md:ml-10 md:flex md:items-baseline md:justify-between md:bg-transparent" id="topmenu">
      <ul class="flex">
      <router-link class="ml-4 rounded-full flex py-1 px-1 text-indigo-600 hover:underline xlink
      " to="/"><span>{{ site.name }}</span></router-link>
      <li
        v-for="item in menu"
        :key="item.id"
        :href="item.url"
        :target="item.target"
        :title="item.title"
        v-html="item.content"
        class="flex py-1 px-1 text-indigo-600 hover:underline"
      ></li>
      </ul>
      </div>

      <div class="flex-shrink-0 pr-4 md:hidden">
      <button
      ref="openButton"
      @click="open"
      class="block md:hidden w-8 h-8 text-gray-600"
      aria-label="Menu"
      >
        <svg fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path></svg>
      </button>
    </div>
    </nav>
  </div>

    <div class="md:hidden">
      <!-- Off-canvas menu background overlay -->
      <transition
        enter-class="opacity-0"
        enter-active-class="ease-out transition-medium"
        enter-to-class="opacity-100"
        leave-class="opacity-100"
        leave-active-class="ease-out transition-medium"
        leave-to-class="opacity-0"
        appear
      >
        <div v-show="isOpen" class="z-10 fixed inset-0 transition-opacity">
          <div
            @click="close"
            class="absolute inset-0 bg-black opacity-50"
            tabindex="-1"
          ></div>
        </div>
      </transition>
      <!-- Off-canvas menu -->
      <transition
        enter-class="translate-x-full"
        enter-active-class="ease-out transition-slow"
        enter-to-class="translate-x-0"
        leave-class="translate-x-0"
        leave-active-class="ease-in transition-medium"
        leave-to-class="translate-x-full"
        appear
      >
        <div
          v-show="isOpen"
          class="z-10 fixed inset-y-0 right-0 max-w-xs w-full bg-white transition-transform overflow-y-auto"
        >
          <div class="relative z-10 bg-white">
            <div
              :class="isOpen ? 'block' : 'hidden'"
              class="absolute top-0 right-0 p-4"
            >
              <button
                ref="closeButton"
                @click="close"
                type="button"
                class="text-gray-600 focus:outline-none focus:text-gray-900"
                aria-label="Close"
              >
                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                  <path
                    d="M18.2929 19.7071C18.6834 20.0976 19.3166 20.0976 19.7071 19.7071C20.0976 19.3166 20.0976 18.6834 19.7071 18.2929L13.4142 12L19.7071 5.70711C20.0976 5.31658 20.0976 4.68342 19.7071 4.29289C19.3166 3.90237 18.6834 3.90237 18.2929 4.29289L12 10.5858L5.70711 4.29289C5.31658 3.90237 4.68342 3.90237 4.29289 4.29289C3.90237 4.68342 3.90237 5.31658 4.29289 5.70711L10.5858 12L4.29289 18.2929C3.90237 18.6834 3.90237 19.3166 4.29289 19.7071C4.68342 20.0976 5.31658 20.0976 5.70711 19.7071L12 13.4142L18.2929 19.7071Z"
                  />
                </svg>
              </button>
            </div>


          </div>
          <div class="relative bg-white">
            <div class="px-4 pt-4 pb-6">
              <a
                href="#"
                class="block font-medium text-gray-900 hover:text-gray-700"
                >Log in</a
              >
            </div>
            <div class="p-4">
              <a
                href="#"
                class="block px-3 py-3 font-medium text-center bg-gray-300 rounded-lg text-gray-900 hover:bg-gray-400 focus:outline-none focus:bg-gray-400"
                >Create Account</a
              >
            </div>
          </div>
        </div>
      </transition>
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
      isOpen: false,
      site: this.$store.state.site
    }
  },
  methods: {
    open() {
        this.isOpen = true
        this.$nextTick(() => {
          this.$refs.closeButton.focus()
        })
      },
      close() {
        this.isOpen = false
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
      isOpen: {
        immediate: true,
        handler(isOpen) {
          if (isOpen) {
            document.body.style.setProperty('overflow', 'hidden')
          } else {
            document.body.style.removeProperty('overflow')
          }
        }
      }
    }
}
</script>
<style scoped>
.navigasi {

  height: 70px;
  z-index: 99;
}
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