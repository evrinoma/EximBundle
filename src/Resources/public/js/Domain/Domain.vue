<template>
  <div v-if="domainClass && serverClass">
    <div class="ui segment block">
      <div class="ui two column very relaxed grid">
        <div class="column">
          <vuetable
              :fields="fields"
              :sort-order="sortOrder"
              :api-url="apiUrl"
              :api-url-delete="apiUrlDelete"
              :domain-class="domainClass"
          ></vuetable>
        </div>
        <div class="column">
          <p></p>
          <p></p>
          <p></p>
          <p></p>
          <p></p>
          <p></p>
          <info-panel
              :api-url-servers="apiUrlServers"
              :api-url-save="apiUrlSave"
              :domain-class="domainClass"
          ></info-panel>
          <server-panel
              :api-url-servers="apiUrlServers"
              :api-url-save="apiUrlServerSave"
              :api-url-delete="apiUrlServerDelete"
              :server-class="serverClass"
          ></server-panel>
        </div>
      </div>
      <div class="ui vertical divider">
        |
      </div>
    </div>
  </div>
</template>

<script>
import Vue from 'vue';
import DomainFieldDefs from './DomainFieldDefs';
import InfoPanel from './InfoPanel';
import ServerPanel from './ServerPanel';
import Vuetable from '../components/VueTables2/VueTables2';
import axios from 'axios';

Vue.component('info-panel', InfoPanel);
Vue.component('server-panel', ServerPanel);
Vue.use(axios);

export default {
  name: 'domain',
  components: {
    Vuetable
  },
  data() {
    return {
      fields: DomainFieldDefs,
      sortOrder: [
        {
          field: 'domain',
          sortField: 'domain',
          direction: 'asc'
        }
      ],
      apiUrl: window.location.origin + '/evrinoma/api/exim/domain/query',
      apiUrlDelete: window.location.origin + '/evrinoma/api/exim/domain/delete',
      apiUrlServers: window.location.origin + '/evrinoma/api/exim/server/server',
      apiUrlSave: window.location.origin + '/evrinoma/api/exim/domain/save',
      apiUrlServerDelete: window.location.origin + '/evrinoma/api/exim/server/delete',
      apiUrlServerSave: window.location.origin + '/evrinoma/api/exim/server/save',
      domainClass: 'Evrinoma\\EximBundle\\Dto\\DomainDto',
      serverClass: 'Evrinoma\\EximBundle\\Dto\\ServerDto',
    }
  },
  mounted() {
    this.doMount();
  },
  methods: {
    doMount() {
    },
    _axiosResponse(type, response) {
    },
  }
}
</script>

<style>
#app {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 5px;
  font-size: smaller;
}

.ui.table.vuetable td {
  padding: 5px;

}

.ui.segment.block {
  height: 84vh;
}
</style>