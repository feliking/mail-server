<template>
  <q-page padding class="flex flex-center">
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
              <q-btn
                color="primary"
                class="full-width"
                type="submit"
                :loading="loading">
                Ingresar
              </q-btn>
            </q-card-actions>
          </q-form>
        </q-card>
      </div>
    </div>
  </q-page>
</template>

<script>
import Form from '../../mixins/form'
export default {
  name: 'Index',
  mixins: [Form],
  data () {
    return {
      form: {
        email: null,
        password: null
      },
      isPwd: true
    }
  },
  created () {
    this.form.email = this.$route.query.email || null
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
    }
  }
}
</script>
