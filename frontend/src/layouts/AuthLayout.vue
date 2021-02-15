
<template>
  <q-layout view="hHh Lpr fFf">
    <q-page-container>
      <transition
        appear
        enter-active-class="animated fadeIn"
        leave-active-class="animated fadeOut"
      >
        <router-view />
      </transition>
    </q-page-container>
  </q-layout>
</template>

<script>
export default {
  name: 'AuthLayout',
  data () {
    return {}
  }
}
</script>
