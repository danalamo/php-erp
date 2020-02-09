import { Api, formatLocation, route, vueRoute } from "../../assets/data_helpers";

const UserList = {

  props: {
    store: Object,
  },
  
  async mounted() {
    const data = await Api.getUsersWithLocations()
    document.title = `${app.title} - ${data.page_title}`
    app.store = data
  },

  watch: {
    async ['$route.query'](value, previousValue) {
      if (previousValue !== value) {
        const data = await Api.getUsersWithLocations(location.search)
        document.title = `${app.title} - ${data.page_title}`
        app.store = data
      }
    },
    store(value, previousValue) {
      console.log('UserList.store',{ value, previousValue })
    }
  },

  render() {
    const data = this.store
    
    if (!data.index) {
      return null
    }
    
    return (
      <div class="table responsive">
        <table class="stripped">
          <thead>
          <tr>
            <th><router-link to={`/vue${data.qstring.active}`}>Active</router-link></th>
            <th><router-link to={`/vue${data.qstring.last_name}`}>Employee Name</router-link></th>
            <th><router-link to={`/vue${data.qstring.line1}`}>Location</router-link></th>
            <th>Actions</th>
          </tr>
          </thead>
          <tbody>
          {data.users.length === 0 && (
            <tr>
              <td colSpan="4" align="center">
                No Employees Found!
                Create one <router-link to={route('vue').userAdd}>here</router-link>
              </td>
            </tr>
          )}
          {data.users.map(user => (
            <tr
              key={user.id}
              class={user.active == true ? '' : 'user-inactive'}>
              <td>
                <input
                  type="checkbox"
                  name="active"
                  checked={user.active == true}
                  onClick={async () => {
                    user.active = user.active == true ? false : true
                    const data = await Api.updateUserById(user)
                    app.store = data
                  }}
                />
              </td>
              <td>{user.last_name}, {user.first_name}</td>
              <td>{formatLocation(user)}</td>
              <td>
                <router-link to={route('vue').userEdit(user.id)}>edit</router-link>&nbsp;|&nbsp;
                <a href={route('vue').userDelete(user.id)}
                   onClick={async (e) => {
                     e.preventDefault();
                     const data = await Api.deleteUserById(user.id)
                     app.store = data
                   }}>
                  delete
                </a>
              </td>
            </tr>
          ))}
          </tbody>
        </table>
        {window.erpDebug() && (
          <div>
            <h4>Index route props</h4>
            <pre>{vueRoute(this.$route)}</pre>
          </div>
        )}
      </div>
    )
    
  }
}

export default UserList

