<template>
  <q-page padding class="flex flex-center">
    <q-form @submit="updatePassword()">
      <div class="row q-gutter-lg">
        <div class="col-12 col-md-auto">
          <q-input
            type="password"
            v-model="form.old_password"
            label="Contraseña actual"
            :rules="[v => !!v || 'Campo requerido']"
            hint="Obligatorio*"
          />
          <q-input
            type="password"
            v-model="form.new_password"
            label="Nueva contraseña"
            :rules="[v => !!v || 'Campo requerido']"
            hint="Obligatorio*"
            @keyup="checkNewRepeat()"
          />
          <q-input
            type="password"
            v-model="form.repeat_new_password"
            label="Repita la nueva contraseña"
            :rules="[v => !!v || 'Campo requerido']"
            hint="Obligatorio*"
            @keyup="checkNewRepeat()"
          />
          <q-btn
            class="full-width glossy q-mt-sm"
            rounded
            color="primary"
            type="submit"
            :loading="loading"
            :disable="check"
          >
            Cambiar contraseña
          </q-btn>
          <span class="text-red">{{ error }}</span>
        </div>
      </div>
    </q-form>
  </q-page>
</template>

<script>
export default {
  name: 'Password',
  data () {
    return {
      form: {
        old_password: '',
        new_password: '',
        repeat_new_password: '',
        id: 0
      },
      loading: false,
      check: true,
      error: ''
    }
  },
  methods: {
    async updatePassword () {
      try {
        this.loading = true
        this.form.id = this.$store.state.auth.user.id
        const res = await this.$axios.post('change_password', this.form)
        this.$q.notify({
          message: res.data.message,
          color: 'positive'
        })
        this.loading = false
      } catch (error) {
        console.log(error)
        this.$q.notify({
          message: 'Contraseña incorrecta',
          color: 'negative'
        })
        this.loading = false
      }
    },
    checkNewRepeat () {
      if (this.form.new_password !== this.form.repeat_new_password) {
        this.error = 'Las contraseñas no coinciden'
      } else if (this.form.new_password !== this.form.old_password) {
        this.error = ''
        this.check = false
      } else {
        this.error = 'La contraseña nueva es la misma que la anterior'
        this.check = true
      }
    }
  }
}
</script>
