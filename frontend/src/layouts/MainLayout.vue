<template>
  <q-layout view="hHh Lpr lff">
    <q-header elevated class="glossy bg-black">
      <q-toolbar>
        <q-btn
          flat
          dense
          round
          icon="menu"
          aria-label="Menu"
          @click="switchDrawer()"
        />

        <q-toolbar-title>
          {{ title }}
        </q-toolbar-title>
        <q-avatar>
          <img :src="`https://ui-avatars.com/api/?name=${$store.state.auth.user.name}`" alt="">
        </q-avatar>
        <q-btn flat color="white" :label="`${$store.state.auth.user.name}`">
          <q-menu>
            <q-list style="min-width: 100px">
              <q-item clickable v-close-popup to="/perfil">
                <q-item-section>Perfil</q-item-section>
              </q-item>
              <q-item clickable v-close-popup to="/change_password">
                <q-item-section>Cambiar contraseña</q-item-section>
              </q-item>
              <q-separator />
              <q-item clickable v-close-popup @click="logout()">
                <q-item-section>Cerrar sesión</q-item-section>
              </q-item>
            </q-list>
          </q-menu>
        </q-btn>

      </q-toolbar>
    </q-header>

    <AppNav />
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
import AppNav from '../components/appNav/AppNav'
export default {
  name: 'MainLayout',
  components: {
    AppNav
  },
  data () {
    return {
      title: ''
    }
  },
  methods: {
    switchDrawer () {
      this.$root.$emit('switchDrawer')
    },
    async logout () {
      await this.$store.dispatch('auth/logout')
      this.$q.notify({
        message: '¡Hasta pronto!',
        color: 'negative',
        position: 'bottom-right'
      })
      this.$router.push({ name: 'login' })
    }
  },
  mounted () {
    this.title = process.env.APP_NAME
  }
}
</script>
