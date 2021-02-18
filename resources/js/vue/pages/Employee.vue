<template>
  <div class="container mt-3 mb-5">
    <h2>Employee Management</h2>
    <b-row class="mb-3 mt-4">
      <b-col md="3">
        <b-form-input
          v-model="filter"
          type="search"
          id="filterInput"
          placeholder="Type to Search"
        ></b-form-input>
      </b-col>
      <b-col md="3">
        <b-button variant="danger" v-b-modal.modal-1>Add</b-button>
      </b-col>
    </b-row>
    <b-row>
      <b-col>
        <b-table
          striped
          hover
          outlined
          :items="posts"
          :fields="fields"
          :current-page="currentPage"
          :per-page="perPage"
          :filter="filter"
        >
          <template v-slot:cell(actions)="data">
            <b-button variant="danger" @click="deleteItem(data.item.id)"
              >Delete</b-button
            >
          </template>
        </b-table>
        <b-pagination
          v-model="currentPage"
          :total-rows="rows"
          :per-page="perPage"
          aria-controls="my-table"
        ></b-pagination>
      </b-col>
    </b-row>
    <b-button v-b-modal.modal-1>Launch demo modal</b-button>
    <b-modal id="modal-1" title="BootstrapVue">
      <p class="my-4">Hello from modal!</p>
    </b-modal>
  </div>
</template>

<script>
export default {
  name: "Employee",
  data() {
    return {
      filter: "",
      perPage: 1,
      currentPage: 1,
      fields: ["userId", "id", "title", "actions"],
      posts: [],
    };
  },
  methods: {
    deleteItem(id) {
      const index = this.posts.indexOf((x) => x.id === id);
      this.posts.splice(index, 1);
    },
  },
  computed: {
    rows() {
      return this.posts.length;
    },
  },
};
</script>

<style>
</style>