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
        <b-button
          variant="danger"
          v-b-modal.modal-1
          @click="
            reset();
            title = 'Add New Employee';
            type = 'add';
          "
          >Add</b-button
        >
      </b-col>
    </b-row>
    <b-row>
      <b-col>
        <b-table
          striped
          hover
          outlined
          :items="employees"
          :fields="fields"
          :current-page="currentPage"
          :per-page="perPage"
          :filter="filter"
        >
          <template v-slot:cell(actions)="data">
            <b-button
              variant="primary"
              v-b-modal.modal-1
              @click="
                title = 'Edit Employee';
                form = data.item;
                selectedId = data.item.id;
                type = 'edit';
                getStates(data.item.countryId);
                getCities(data.item.stateId);
              "
              >Edit</b-button
            >
            <b-button
              variant="danger"
              @click="
                deleteItem(data.item.id);
                remove(data.item.id);
              "
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
    <!-- form modal -->
    <b-modal id="modal-1" :title="title" hide-footer>
      <b-form @submit="onSubmit" @reset="onReset" v-if="show">
        <b-row>
          <b-col>
            <b-form-group
              id="input-group-1"
              label="First Name:"
              label-for="input-1"
            >
              <b-form-input
                id="input-1"
                v-model="form.firstName"
                type="text"
                placeholder="Enter first name"
                required
              ></b-form-input>
            </b-form-group>
          </b-col>
          <b-col>
            <b-form-group
              id="input-group-1-1"
              label="Middle Name:"
              label-for="input-1-1"
            >
              <b-form-input
                id="input-1-1"
                v-model="form.middleName"
                type="text"
                placeholder="Enter middle name"
                required
              ></b-form-input>
            </b-form-group>
          </b-col>
          <b-col>
            <b-form-group
              id="input-group-1-2"
              label="Last Name:"
              label-for="input-1-2"
            >
              <b-form-input
                id="input-1-2"
                v-model="form.lastName"
                type="text"
                placeholder="Enter last name"
                required
              ></b-form-input>
            </b-form-group>
          </b-col>
        </b-row>

        <b-form-group id="input-group-2" label="Address:" label-for="input-2">
          <b-form-input
            id="input-2"
            v-model="form.address"
            placeholder="Enter address"
            required
          ></b-form-input>
        </b-form-group>

        <b-form-group id="input-group-4" label="Zip:" label-for="input-2">
          <b-form-input
            id="input-4"
            v-model="form.zip"
            placeholder="Enter zip"
            required
          ></b-form-input>
        </b-form-group>

        <b-form-group
          id="input-group-3"
          label="Department:"
          label-for="input-3"
        >
          <b-form-select
            id="input-3"
            v-model="form.departmentId"
            :options="departments"
          ></b-form-select>
        </b-form-group>

        <b-row>
          <b-col>
            <b-form-group
              id="input-group-3"
              label="Country:"
              label-for="input-3"
            >
              <b-form-select
                id="input-3"
                v-model="form.countryId"
                :options="countries"
                @change="getStates"
              ></b-form-select>
            </b-form-group>
          </b-col>

          <b-col>
            <b-form-group
              id="input-group-3"
              label="State:"
              label-for="input-3-1"
            >
              <b-form-select
                id="input-3-1"
                v-model="form.stateId"
                :options="states"
                @change="getCities"
              ></b-form-select>
            </b-form-group>
          </b-col>
          <b-col>
            <b-form-group
              id="input-group-3"
              label="City:"
              label-for="input-3-2"
            >
              <b-form-select
                id="input-3-2"
                v-model="form.cityId"
                :options="cities"
              ></b-form-select>
            </b-form-group>
          </b-col>
        </b-row>

        <b-form-group
          id="input-group-3"
          label="Choose a brith date:"
          label-for="input-3"
        >
          <b-form-datepicker
            id="example-datepicker"
            v-model="form.birthDate"
            required
            class="mb-2"
          ></b-form-datepicker>
        </b-form-group>

        <b-button type="submit" variant="primary">Submit</b-button>
        <b-button type="reset" variant="danger">Reset</b-button>
      </b-form>
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
      type: null,
      currentPage: 1,
      selectedId: null,
      fields: ["id", "firstName", "lastName", "actions"],
      employees: [],
      departments: [],
      countries: [],
      states: [],
      cities: [],
      show: true,
      title: "Add New Employee",
      form: {
        firstName: "",
        lastName: "",
        middleName: "",
        address: "",
        departmentId: null,
        countryId: null,
        stateId: null,
        cityId: null,
        zip: "",
        birthDate: null,
        hiredDate: new Date(),
      },
    };
  },
  methods: {
    deleteItem(id) {
      const index = this.employees.indexOf((x) => x.id === id);
      this.employees.splice(index, 1);
    },
    add() {
      axios
        .post("/api/employee/store", {
          employee: this.form,
        })
        .then((response) => {
          if (response.status === 201) {
            // this.employees = response.data;
            console.log(response.body);
            this.reset();
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
    get() {
      axios
        .get("/api/employees")
        .then((response) => {
          if (response.status === 200) {
            // this.employees = response.data;
            console.log("employees details", response.data);
            this.employees = response.data.map((item) => {
              return {
                id: item.id,
                firstName: item.firstname,
                lastName: item.lastname,
                middleName: item.middlename,
                address: item.address,
                departmentId: item.department_id,
                countryId: item.country_id,
                stateId: item.state_id,
                cityId: item.city_id,
                zip: item.zip,
                birthDate: item.birthdate,
              };
            });
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
    edit() {
      axios
        .put("/api/employee/" + this.selectedId, {
          employee: this.form,
        })
        .then((response) => {
          if (response.status === 201) {
            // this.employees = response.data;
            console.log(response.body);
            this.reset();
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
    remove(id) {
      axios
        .delete("/api/employee/" + id)
        .then((response) => {
          if (response.status === 201) {
            // this.employees = response.data;
            console.log(response.body);
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
    getDepartments() {
      axios
        .get("/api/departments")
        .then((response) => {
          if (response.status === 200) {
            // this.employees = response.data;
            this.departments = response.data.map((item) => {
              return {
                value: item.id,
                text: item.name,
              };
            });
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
    getCountries() {
      axios
        .get("/api/countries")
        .then((response) => {
          if (response.status === 200) {
            // this.employees = response.data;
            this.countries = response.data.map((item) => {
              return {
                value: item.id,
                text: item.name,
              };
            });
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
    getStates(event) {
      console.log(event);
      axios
        .get("/api/state/by-country/" + event)
        .then((response) => {
          if (response.status === 200) {
            // this.employees = response.data;
            console.log(response.body);
            this.states = response.data.map((item) => {
              return {
                value: item.id,
                text: item.name,
              };
            });
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
    getCities(event) {
      console.log(event);
      axios
        .get("/api/city/by-state/" + event)
        .then((response) => {
          if (response.status === 200) {
            // this.employees = response.data;
            console.log(response.body);
            this.cities = response.data.map((item) => {
              return {
                value: item.id,
                text: item.name,
              };
            });
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
    update() {
      axios.put("/api/employee").then((response) => {
        if (response.status === 201) {
          this.employees = response.data;
          console.log(response.body);
        }
      });
    },
    onSubmit(event) {
      event.preventDefault();

      console.log("submit button", this.type);
      if (this.type === "add") {
        this.add();
      } else if (this.type === "edit") {
        this.edit();
      } else {
        console.log("error -->>");
      }
      // alert(JSON.stringify(this.form));
    },
    onReset(event) {
      event.preventDefault();
      // Reset our form values
      this.reset();
      // Trick to reset/clear native browser form validation state
      this.show = false;
      this.$nextTick(() => {
        this.show = true;
      });
      // Reset selects
      this.states = [];
      this.cities = [];
    },
    reset() {
      this.form.firstName = "";
      this.form.lastName = "";
      this.form.middleName = "";
      this.form.address = "";
      this.form.departmentId = null;
      this.form.countryId = null;
      this.form.stateId = null;
      this.form.cityId = null;
      this.form.zip = "";
      this.form.birthDate = null;
      this.form.hiredDate = new Date();
    },
  },
  computed: {
    rows() {
      return this.employees.length;
    },
  },
  mounted: function () {
    this.$nextTick(this.get);
    this.$nextTick(this.getDepartments);
    this.$nextTick(this.getCountries);
  },
};
</script>

<style>
</style>