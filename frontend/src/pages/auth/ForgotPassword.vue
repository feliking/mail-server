<template>
  <q-dialog
    v-model="dialog"
    persistent
    @hide="close()">
    <q-card style="width: 350px">
      <q-card-section class="row items-center q-pb-none">
        <div class="text-h5">{{ send ? 'Mensaje enviado' : 'Buscar cuenta' }} <br><span class="text-subtitle2 text-grey" v-if="send == false">Introduce tu correo</span></div>
        <q-space />
        <q-btn icon="close" flat round dense v-close-popup />
      </q-card-section>

      <q-separator />

      <q-card-section
        class="q-px-md"
        v-if="send == false">
        <q-form @submit="verifyEmail()">
          <q-input
            label="Correo Electrónico"
            v-model="user.email"
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
              Buscar
            </strong>
          </q-btn>
        </q-form>
      </q-card-section>
      <q-card-section>
        <div
          class="row q-py-sm"
          transition-show="flip-down"
          transition-hide="flip-up"
          v-if="find"
          >
          <div class="col-2 text-negative text-center">
            <q-btn
              icon="clear"
              round
              color="negative"
              size="sm"
              glossy
            />
          </div>
          <div class="col-10">
            <span class="text-negative text-subtitle1">
              No se encontró la cuenta
            </span>
          </div>
        </div>
        <div
          class="row q-py-sm"
          transition-show="flip-down"
          transition-hide="flip-up"
          v-if="send">
          <div class="col-2 text-positive text-center">
            <q-btn
              icon="check"
              round
              color="positive"
              size="xs"
              glossy
            />
          </div>
          <div class="col-10">
            <span class="text-positive text-subtitle2">
              Mensaje de recuperación envíado
            </span>
            <span>
              Revisa tu correo electrónico, si no aparece en la bandeja principal, revisa el Spam
            </span>
          </div>
        </div>
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
        email: ''
      },
      loading: false,
      find: false,
      send: false
    }
  },
  mounted () {
    this.$root.$on('openDialogForgotPassword', () => {
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
      this.loading = true
      try {
        const res = await this.$axios.post('user/find', this.user)
        if (res.data) {
          this.send = true
          this.find = false
        } else {
          this.send = false
          this.find = true
        }
      } catch (error) {
        console.log(error)
      }
      this.loading = false
    },
    close () {
      this.user = {
        email: ''
      }
      this.find = false
      this.send = false
      this.dialog = false
    }
  }
}
</script>
