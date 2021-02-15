<template>
  <q-page padding class="flex flex-center bg-grey-3">
    <Register />
    <div class="row">
      <div class="col-xs-12 text-center">
      </div>
      <div class="col-xs-12 text-center">
        <div class="text-center">
          <q-img
            alt="Fenix Code Logo"
            src="~assets/quasar-logo-full.svg"
            style="width: 350px"
            class="q-my-lg"
          />
        </div>
        <q-card style="min-width: 350px" class="text-center shadow-5">
          <q-form @submit="submit()">
            <q-card-section>
              <q-input
                v-model="form.email"
                label="Correo Electrónico"
                :rules="[rules.required('email')]"
                @input="clearErrors('email')">
                <template v-slot:prepend>
                  <q-icon name="people" />
                </template>
              </q-input>
              <q-input
                v-model="form.password"
                :type="isPwd ? 'password' : 'text'"
                label="Contraseña"
                :rules="[rules.required('password')]"
                @input="clearErrors('password')">
                <template v-slot:append>
                  <q-icon
                    :name="isPwd ? 'visibility_off' : 'visibility'"
                    class="cursor-pointer"
                    @click="isPwd = !isPwd"
                  />
                </template>
                <template v-slot:prepend>
                  <q-icon name="lock" />
                </template>
              </q-input>
            </q-card-section>
            <q-card-actions>
              <div class="row full-width">
                <div class="col-12">
                  <div>
                    <q-btn
                      color="primary"
                      type="submit"
                      :loading="loading"
                      no-caps
                      class="full-width">
                      <strong>
                        Iniciar sesión
                      </strong>
                    </q-btn>
                  </div>
                </div>
                <div class="col-12 q-py-sm">
                  ¿Olvidaste tu contraseña?
                </div>
                <div class="col-12">
                  <q-btn
                    color="positive"
                    no-caps
                    @click="register()">
                    <strong>Crear nueva cuenta</strong>
                  </q-btn>
                </div>
              </div>
            </q-card-actions>
          </q-form>
        </q-card>
      </div>
    </div>

    <q-dialog
      v-model="dialog">
      <q-card>
        <q-card-section>
          <span>
            Gracias por registrarte, enviamos un mensaje de confimación a su correo electrónico
          </span>
        </q-card-section>
      </q-card>
    </q-dialog>
  </q-page>
</template>

<script>
import Form from '../../mixins/form'
import Register from './Register'

export default {
  name: 'Index',
  mixins: [Form],
  components: {
    Register
  },
  data () {
    return {
      form: {
        email: null,
        password: null
      },
      isPwd: true,
      dialog: false
    }
  },
  created () {
    this.form.email = this.$route.query.email || null
  },
  mounted () {
    this.$root.$on('closeDialogRegister', () => {
      this.dialog = true
    })
  },
  methods: {
    submit () {
      this.loading = true
      this.$axios.post('login', this.form)
        .then(res => {
          this.$store.dispatch('auth/saveToken', res.data)
          this.$store.dispatch('auth/setUser', res.data)
          this.$router.push({ name: 'index' })
          this.$q.notify({
            message: 'Bienvenido',
            color: 'positive',
            icon: 'check',
            position: 'bottom-right'
          })
        })
        .catch(err => {
          console.log(err)
        })
        .then(() => {
          this.loading = false
        })
    },
    register () {
      this.$root.$emit('openDialogRegister')
    }
  }
}
</script>
