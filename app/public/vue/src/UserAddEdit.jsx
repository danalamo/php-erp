import { Api, formatLocation, route, vueRoute } from "../../assets/data_helpers";

const UserAddEdit = {
  
  props: {
    store: Object,
  },
  
  data: () => ({
    errors: {
      first_name: null,
      last_name: null,
      location_id: null,
    },
  }),
  
  mounted() {
    const { user_id } = this.$route.params
    this.loadData(user_id)
  },

  watch: {
    async ['$route.params.user_id'](value, previousValue) {
      if (previousValue !== value) {
        this.loadData(user_id)
      }
    },
    store(value, previousValue) {
      console.log('UserAddEdit.store',{ value, previousValue })
    }
  },
  
  componentDidUpdate(prevProps, prevState, snapshot) {
    const { user_id } = this.$route.params
    if (prevProps.$route.params.user_id !== user_id) {
      this.loadData(user_id)
    }
  },

  methods: {
    async loadData(user_id) {
      let data;
      if (user_id) {
        data = await Api.getUserById(user_id)
      } else {
        data = await Api.getCreateUser()
      }
      document.title = `${app.title} - ${data.page_title}`
      console.log('res', data);
      app.store = data
    },

    async onFormSubmit(e) {
      e.preventDefault()
      const inputs = e.target.getElementsByClassName('validate')
      let errors = 0;
      for (let target of inputs) {
        errors += this.validate(target)
      }
      if (errors > 0) {
        return;
      }
      
      const { user } = this.store
      const apiCall = user.id ? Api.updateUserById : Api.createUser
      const data = await apiCall(user)
      app.store = data
      this.$router.push(route('vue').index)
    },

    handleChange({ target }) {
      let store = this.store;
      store.user[target.name] = target.value
      if (target.type === 'checkbox') {
        store.user[target.name] = target.checked
      }
      app.store = store

      this.validate(target)

      if (window.erpDebug()) {
        console.log('target', {
          type: target.type,
          name: target.name,
          value: target.value,
          checked: target.checked,
          size: target.size,
          disabled: target.disabled,
        })
      }
    },

    validate(target, setState = true) {
      switch (target.name) {
        case 'active':
          break;
        default:
          let errors = this.errors
          if (errors[target.name]) {
            delete errors[target.name]
          }
          if (target.value.length < 1) {
            errors[target.name] = "This field is required"
          }
          if (setState) {
            this.errors = errors
          }
          const len = Object.keys(errors).filter(key => errors[key]).length
          console.log('len', len)
          return len
      }
    },
  },
  
  render() {
    const { 
      user, 
      locations, 
      page_title,
    } = this.store
    
    const errors = this.errors
    
    if (!(user && locations)) {
      return null;
    }
    
    return (
      <div class="vue-user-form-container">
        <form id="user-form" method="POST" onSubmit={this.onFormSubmit}>
          <div class="input-group">
            <label for="first_name">First Name</label>
            <input
              id="first_name"
              type="text"
              name="first_name"
              class="validate"
              value={user.first_name}
              onInput={this.handleChange}
            />
            {errors.first_name && 
              <label for="first" class="error">{errors.first_name}</label>}
          </div>
          <div class="input-group">
            <label for="last_name">Last Name</label>
            <input
              id="last_name"
              type="text"
              name="last_name"
              class="validate"
              value={user.last_name}
              onInput={this.handleChange}
            />
            {errors.last_name &&
              <label for="first" class="error">{errors.last_name}</label>}
          </div>
          <div class="input-group">
            <label for="location_id">Location</label>
            <select 
              id="location_id" 
              name="location_id"
              class="validate"
              value={user.location_id}
              onChange={this.handleChange}
            >
              <option value="">Select a Location</option>
              {locations && locations.map(loc => (
                <option
                  key={loc.id}
                  value={loc.id}>
                  { formatLocation(loc) }
                </option>
              ))}
            </select>
            {errors.location_id &&
              <label for="first" class="error">{errors.location_id}</label>}
          </div>
          <div class="input-group">
            <label for="active">Active
              <input
                id="active"
                type="checkbox"
                name="active"
                checked={user.active == false ? false : true}
                onChange={this.handleChange}
              />
            </label>
            <br/><br/>
          </div>
          <div class="input-group">
            <input 
              id="save" 
              type="submit" 
              value={page_title}
            />
          </div>
          {window.erpDebug() && (
            <div>
              <h4>User data</h4>
              <pre>{JSON.stringify({user, errors}, null, 2)}</pre>
              <h4>POST data</h4>
              <pre>{JSON.stringify({post:''}, null, 2)}</pre>
            </div>
          )}
        </form>
        {window.erpDebug() && (
          <div>
            <h4>UserAddEdit route props</h4>
            <pre>{vueRoute(this.$route)}</pre>
          </div>
        )}
      </div>
    );
  },
}

export default UserAddEdit