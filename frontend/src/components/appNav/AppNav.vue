<template>
  <q-drawer
    v-model="drawer"
    show-if-above

    :mini="miniState"
    @mouseover="miniState = false"
    @mouseout="miniState = true"
    mini-to-overlay

    :width="300"
    :breakpoint="500"
    bordered
    content-class="bg-grey-3"
  >
    <q-scroll-area class="fit">
      <q-list padding>
        <div v-for="(item, index) in items" :key="index">
          <q-item
            clickable
            v-ripple
            v-if="!item.children"
            :to="item.to"
          >
            <q-item-section avatar>
              <q-icon :name="item.icon" />
            </q-item-section>
            <q-item-section>
              {{ item.title }}
            </q-item-section>
          </q-item>

          <q-expansion-item
            :content-inset-level="0.3"
            expand-separator :icon="item.icon"
            :label="item.title"
            v-if="item.children">
            <q-item
              clickable
              v-ripple
              :to="subitem.to"
              v-for="(subitem, index) in item.children"
              :key="index">
              <q-item-section avatar>
                <q-icon :name="subitem.icon" />
              </q-item-section>
              <q-item-section>
                {{ subitem.title }}
              </q-item-section>
            </q-item>
          </q-expansion-item>

          <q-separator />
        </div>
      </q-list>
    </q-scroll-area>
  </q-drawer>
</template>

<script>
import { nav } from './navigation'
export default {
  name: 'AppNav',
  data () {
    return {
      drawer: false,
      miniState: true,
      items: []
    }
  },
  mounted () {
    this.items = nav
    this.$root.$on('switchDrawer', () => {
      this.drawer = !this.drawer
    })
  }
}
</script>
