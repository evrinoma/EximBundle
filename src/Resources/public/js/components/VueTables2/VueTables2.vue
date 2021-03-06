<template>
  <div>
    <filter-bar></filter-bar>
    <vuetable ref="vuetable"
              :http-fetch= "loadFetch"
              :api-url="apiUrl"
              :fields="fields"
              :per-page="perPage"
              :multi-sort="true"
              multi-sort-key="ctrl"
              :sort-order="sortOrder"
              pagination-path=""
              @vuetable:pagination-data="onPaginationData"
              @vuetable:cell-clicked="onCellClicked"
              :append-params="moreParams"
    ></vuetable>
    <div class="vuetable-pagination ui basic segment grid">
      <vuetable-pagination-info ref="paginationInfo">
      </vuetable-pagination-info>

      <vuetable-pagination ref="pagination"
                           @vuetable-pagination:change-page="onChangePage"
      ></vuetable-pagination>
    </div>
  </div>
</template>

<script>
import Vue from 'vue';
import VueEvents from 'vue-events';
import Vuetable from 'vuetable-2/src/components/Vuetable';
import VuetablePagination from 'vuetable-2/src/components/VuetablePagination';
import VuetablePaginationInfo from 'vuetable-2/src/components/VuetablePaginationInfo'
import CustomActions from './CustomActions';
import FilterBar from './FilterBar';
import axios from 'axios';

Vue.use(VueEvents);
Vue.use(axios);
Vue.component('custom-actions', CustomActions);
Vue.component('filter-bar', FilterBar);

let component = {
  components: {
    Vuetable,
    VuetablePagination,
    VuetablePaginationInfo
  },
  props: {
    fields: {
      type: Array,
      required: true
    },
    apiUrl: {
      type: String,
      required: true
    },
    apiUrlDelete: {
      type: String,
      required: true
    },
    domainClass: {
      type: String,
      required: true
    },
    sortOrder: {
      type: Array,
      default() {
        return []
      }
    },
    perPage: {
      type: Number,
      default() {
        return 5
      }
    },
  },
  data() {
    return {
      moreParams: {
      },
    }
  },
  mounted() {
    this.doLoad();
  },
  methods: {
    onChangePage(page) {
      this.$refs.vuetable.changePage(page)
    },
    onPaginationData(paginationData) {
      this.$refs.pagination.setPaginationData(paginationData);
      this.$refs.paginationInfo.setPaginationData(paginationData);
    },
    onCellClicked(data, field, event) {
      this.$events.fire('info-set', data);
    },
    onFilterSet(filterText) {
      this.moreParams.filter = filterText;
      Vue.nextTick(() => this.$refs.vuetable.refresh());
    },
    onFilterReset() {
      delete this.moreParams.filter;
      Vue.nextTick(() => this.$refs.vuetable.refresh());
    },
    onUpdate() {
      Vue.nextTick(() => this.$refs.vuetable.refresh());
    },
    onDelete(data) {
      axios
          .delete(this.apiUrlDelete, data)
          .then(response => (this._axiosResponse('custom-actions-delete', response)));
    },
    doLoad() {
      this.$events.$on('filter-set', eventData => this.onFilterSet(eventData));
      this.$events.$on('filter-reset', eventData => this.onFilterReset());
      this.$events.$on('table-save', eventData => this.onUpdate());
      this.$events.$on('custom-actions-delete', eventData => this.onDelete(eventData));
    },
    loadFetch(apiUrl, httpOptions) {
      httpOptions.params['class'] = this.domainClass;
      return axios.get(apiUrl, httpOptions);
    },
    _axiosResponse(type, response) {
      switch (type) {
        case 'custom-actions-delete':
          Vue.nextTick(() => this.$refs.vuetable.refresh());
          break;
      }
    }
  }
};


export default component
</script>