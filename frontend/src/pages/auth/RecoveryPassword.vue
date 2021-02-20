<template>
  <q-page padding class="flex flex-center">
    <q-card
      style="min-width: 350px"
      v-if="sw && visible == false">
      <q-card-section class="row items-center q-pb-none">
        <div class="text-h6">Restablecer contraseña <br><span class="text-subtitle2 text-grey">{{ user.email }}</span></div>
      </q-card-section>

      <q-separator />

      <q-card-section
        class="q-px-md">
        <q-form @submit="changePassword()">
          <q-input
            type="password"
            label="Introduzca su nueva contraseña"
            v-model="user.password"
            :rules="[v => !!v || 'Campo obligatorio']"
          />
          <q-input
            type="password"
            label="Repita su nueva contraseña"
            v-model="repeat_password"
            :rules="[v => !!v || 'Campo obligatorio']"
          />
          <br>
          <div class="full-width text-center" v-if="pass == true">
            <span class="text-negative">Las contraseñas no coinciden</span>
          </div>
          <q-btn
            type="submit"
            class="full-width"
            color="positive"
            no-caps
            :loading="loading">
            <strong>
              Restablecer contraseña
            </strong>
          </q-btn>
        </q-form>
      </q-card-section>
    </q-card>

    <q-card
      style="min-width: 350px"
      v-if="!sw && visible == false">
      <q-card-section class="row items-center q-pb-none">
        <div class="text-h6">Oops!!!!</div>
      </q-card-section>

      <q-separator />

      <q-card-section
        class="q-px-md">
        <div class="row q-gutter-sm">
          <div class="col-12">
            <span>
              Algo salió mal, parece que el enlace de recuperación caducó
            </span>
          </div>
          <div class="col-12 text-center">
            <q-btn
              color="primary"
              label="Ir a la página principal"
              no-caps
              to="/"
            />
          </div>
        </div>
      </q-card-section>
    </q-card>
    <q-inner-loading :showing="visible">
      <q-spinner-gears size="50px" color="primary" />
    </q-inner-loading>
    <q-dialog v-model="dialog" @hide="close()">
      <q-card>
        <q-card-section>
          Su contraseña se restableció exitosamente
        </q-card-section>
      </q-card>
    </q-dialog>
  </q-page>
</template>

<script>
export default {
  data () {
    return {
      code: '',
      user: {
        password: ''
      },
      repeat_password: '',
      loading: false,
      sw: false,
      visible: false,
      pass: false,
      dialog: false
    }
  },
  mounted () {
    this.verifyCode(this.$route.params.code)
  },
  methods: {
    async verifyCode (code) {
      this.visible = true
      const res = await this.$axios.post('user/verify_code', { code })
      if (res.data.length > 0) {
        this.sw = true
        this.user = res.data[0]
      } else {
        this.sw = false
      }
      this.visible = false
    },
    async changePassword () {
      this.loading = true
      if (this.user.password === this.repeat_password) {
        try {
          await this.$axios.post('user/reset_password', this.user)
          this.dialog = true
          // this.$router.push({ name: 'index' })
        } catch (error) {
          console.log(error)
        }
      } else {
        this.pass = true
      }
      this.loading = false
    },
    close () {
      this.dialog = false
      this.$router.push('/')
    }
  }
}
</script>

<style>

</style>
