<template>
  <q-dialog
    v-model="dialog"
    persistent
    @hide="close()">
    <q-card style="min-width: 350px">
      <q-card-section class="row items-center q-pb-none">
        <div class="text-h5">Registrate <br><span class="text-subtitle2 text-grey">Es rápido y fácil</span></div>
        <q-space />
        <q-btn icon="close" flat round dense v-close-popup />
      </q-card-section>

      <q-separator />

      <q-card-section class="q-px-md">
        <q-form @submit="registerUser()">
          <q-input
            label="Nombre"
            v-model="user.name"
            :rules="[v => !!v || 'Campo obligatorio']"
          />
          <q-input
            label="Correo Electrónico"
            v-model="user.email"
            :rules="[v => !!v || 'Campo obligatorio']"
          />
          <q-input
            type="password"
            label="Contraseña"
            v-model="user.password"
            :rules="[v => !!v || 'Campo obligatorio']"
          />
          <q-input
            type="password"
            label="Repita la Contraseña"
            v-model="repeat_password"
            :rules="[v => !!v || 'Campo obligatorio']"
          />
          <br>
          <q-btn
            type="submit"
            class="full-width"
            color="positive"
            no-caps
            :loading="loading">
            <strong>
              Registrar
            </strong>
          </q-btn>
        </q-form>
      </q-card-section>
    </q-card>
  </q-dialog>
</template>

<script>
export default {
  data () {
    return {
      dialog: false,
      user: {
        name: '',
        email: '',
        password: ''
      },
      repeat_password: '',
      loading: false
    }
  },
  mounted () {
    this.$root.$on('openDialogRegister', () => {
      this.dialog = true
    })
  },
  methods: {
    async registerUser () {
      this.loading = true
      if (await this.verifyEmail()) {
        if (this.user.password === this.repeat_password && (this.user.password !== '' || this.repeat_password !== '')) {
          await this.$axios.post('user', this.user)
          this.$q.notify({
            color: 'positive',
            message: 'Registrado exitosamente',
            icon: 'check'
          })
          this.close()
          this.$root.$emit('closeDialogRegister')
        } else {
          this.$q.notify({
            message: 'Las contraseñas no coinciden',
            color: 'negative',
            icon: 'clear'
          })
        }
      } else {
        this.$q.notify({
          message: 'El correo ya se encuantra registrado',
          icon: 'clear',
          color: 'negative'
        })
      }
      this.loading = false
    },
    async verifyEmail () {
      try {
        const res = await this.$axios.post('user/fill', this.user)
        if (res.data) {
          return false
        } else {
          return true
        }
      } catch (error) {
        console.log(error)
      }
    },
    close () {
      this.user = {
        name: '',
        email: '',
        password: ''
      }
      this.repeat_password = ''
      this.dialog = false
    }
  }
}
</script>
