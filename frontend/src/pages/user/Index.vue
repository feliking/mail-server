<template>
  <q-page padding class="flex flex-center">
    <q-form @submit="save()">
      <div class="row q-gutter-lg">
        <div class="col-12 col-md-auto">
          <q-input
            v-model="user.name"
            label="Nombre"
            :rules="[v => !!v || 'Campo requerido']"
            hint="Obligatorio*"
            :disable="edit"
          />
          <q-input
            v-model="user.email"
            label="Correo electrónico"
            :rules="[v => !!v || 'Campo requerido']"
            hint="Obligatorio*"
            disable
          />
          <q-btn
            class="full-width glossy q-my-sm"
            rounded
            color="primary"
            type="submit"
            :loading="loading"
            :disable="edit"
          >
            Guardar
          </q-btn>
        </div>
      </div>
    </q-form>
    <q-page-sticky position="bottom-right" :offset="[18, 18]">
      <q-btn
        v-if="edit"
        class="glossy"
        fab
        icon="edit"
        title="editar usuario"
        color="primary"
        @click="switchEdit()"
      />
      <q-btn
        v-if="!edit"
        class="glossy"
        fab
        icon="clear"
        title="editar usuario"
        color="negative"
        @click="switchEdit()"
      />
    </q-page-sticky>
  </q-page>
</template>

<script>
export default {
  name: 'Index',
  data () {
    return {
      user: {
        name: '',
        email: ''
      },
      edit: true,
      loading: false
    }
  },
  mounted () {
    this.getUser()
  },
  methods: {
    async getUser () {
      const res = await this.$axios.get('me')
      this.user = res.data.user
    },
    switchEdit () {
      this.edit = !this.edit
    },
    async save () {
      try {
        this.loading = true
        await this.$axios.put(`user/${this.user.id}`, this.user)
        this.$q.notify({
          message: 'Usuario actualizado',
          color: 'positive'
        })
        this.loading = false
        this.edit = !this.edit
        this.$store.dispatch('auth/fetchUser')
      } catch (error) {
        console.log(error)
      }
    }
  }
}
</script>
