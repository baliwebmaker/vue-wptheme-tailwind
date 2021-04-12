<template>
<header x-data="{ mobileMenuOpen : false }" class="flex flex-wrap flex-row justify-between md:items-center md:space-x-4 bg-white py-6 px-6 relative navigasi">
    <a href="#" class="block">
    <span class="sr-only">themes.dev</span>
    <img class="h-6 md:h-8" src="https://d33wubrfki0l68.cloudfront.net/c07183f9fe31fb422dfa12ae010c99b46901d761/459c1/images/themesdev-logo-dark.svg" alt="Themes.dev Logo" title="Themes.dev Logo">
  </a><nav>
    <a
      v-for="item in menu"
      :key="item.id"
      :href="item.url"
      :target="item.target"
      :title="item.title"
      v-html="item.content"
    ></a>
  </nav>
</header>
</template>
<script>
export default {
  name: 'NavMenu',
  props: {
    name: {
      type: String,
      required: true
    }
  },
  data() {
    return {}
  },
  computed: {
    menu() {
      return this.$store.getters.menu({ name: this.name })
    }
  }
}
</script>
<style scoped>
.navigasi {
    position: fixed;
    top: 0px;
    width: 100vw;
    height: 70px;
    z-index: 99;
    background-color: rgb(255, 255, 255);
    box-shadow: rgba(0, 0, 0, 0.05) 0px 10px 12px;
}
</style>