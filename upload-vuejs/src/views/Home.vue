<template>
  <div class="home">

    <single-file></single-file>

  </div>
</template>

<script>
// @ is an alias to /src
// import HelloWorld from '@/components/HelloWorld.vue'

import SingleFile from '@/components/SingleFile'

export default {
  name: 'home',
  components: {
      SingleFile
  }
}
</script>
