import { abilitiesPlugin } from '@casl/vue'
import ability from './services/ability'
import EventHub from './components/EventHubPlugin/EventHub.vue'

const GlobalComponents = {
  install(Vue) {
    Vue.use(abilitiesPlugin, ability)
    Vue.use(EventHub)
  }
}

export default GlobalComponents
