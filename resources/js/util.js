import { clone } from 'lodash'

export const requestIndex = async (api, { state, commit }, _options) => {
  app.$store.state.app.busy = true
  
  state.loading = true
  let options = clone(_options || state.options)
  if (options) {
    options.sortDesc = (options.sortDesc || []).map(e => (e ? 'desc' : 'asc'))
    state.options = options
  }
  const { data } = await axios.get(api, {
    params: options
  })
  commit('set', data.data || data)
  commit('total', data.total || data.length)
  state.loading = false
  app.$store.state.app.busy = false
}
