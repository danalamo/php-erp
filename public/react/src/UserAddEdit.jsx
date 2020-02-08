import React, { Component } from 'react'
import { BrowserRouter, Route, Switch, withRouter } from "react-router-dom";
import { Api, formatLocation, route } from "../../assets/data_helpers";

class UserAddEdit extends Component {
  constructor(props) {
    super(props)
    
    const { user_id } = props.match.params
    
    this.state = {
      errors: {},
    }
    this.handleChange = this.handleChange.bind(this)
    this.onFormSubmit = this.onFormSubmit.bind(this)
    this.loadData = this.loadData.bind(this)
  }
  
  componentDidMount() {
    const { user_id } = this.props.match.params
    this.loadData(user_id)
  }
  
  componentDidUpdate(prevProps, prevState, snapshot) {
    const { user_id } = this.props.match.params
    if (prevProps.match.params.user_id !== user_id) {
      this.loadData(user_id)
    }
  }

  async loadData(user_id) {
    if (user_id) {
      const data = await Api.getUserById(user_id)
      document.title = `${app.state.title} - ${data.page_title}`
      console.log('res', data);
      app.setState({ data })
      this.setState({
        ...this.state,
        ...data
      })
      return;
    }

    const data = await Api.getCreateUser()
    document.title = `${app.state.title} - ${data.page_title}`
    console.log('res', data);
    app.setState({ data })
    this.setState({
      ...this.state,
      ...data
    })
    return;
  }
  
  async onFormSubmit(e) {
    e.preventDefault()
    
    const { user } = this.state
    const apiCall = user.id ? Api.updateUserById : Api.createUser
    const data = await apiCall(user)
    app.setState({ data })
    this.props.history.push(route('react').index)
  }

  handleChange({ target }) {
    let state = this.state;
    state.user[target.name] = target.value
    if (target.type === 'checkbox') {
      state.user[target.name] = target.checked
    }
    this.setState(state)
    
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
  }
  
  render() {
    const { 
      user, 
      locations, 
      page_title,
      errors,
    } = this.state
    
    if (!(user && locations)) {
      return null;
    }
    
    return (
      <div>
        <form id="user-form" method="POST" onSubmit={this.onFormSubmit}>
          <div className="input-group">
            <label htmlFor="first_name">First Name</label>
            <input
              id="first_name"
              type="text"
              name="first_name"
              className="validate"
              value={user.first_name}
              onChange={this.handleChange}
            />
          </div>
          <div className="input-group">
            <label htmlFor="last_name">Last Name</label>
            <input
              id="last_name"
              type="text"
              name="last_name"
              className="validate"
              value={user.last_name}
              onChange={this.handleChange}
            />
          </div>
          <div className="input-group">
            <label htmlFor="location_id">Location</label>
            <select 
              id="location_id" 
              name="location_id"
              className="validate"
              defaultValue={user.location_id}
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
          </div>
          <div className="input-group">
            <label htmlFor="active">Active
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
          <div className="input-group">
            <input 
              id="save" 
              type="submit" 
              value={page_title}
            />
          </div>
          {window.erpDebug() && (
            <>
              <h4>User data</h4>
              <pre>{JSON.stringify({user, errors}, null, 2)}</pre>
              <h4>POST data</h4>
              <pre>{JSON.stringify({post:''}, null, 2)}</pre>
            </>
          )}
        </form>
        {window.erpDebug() && (
          <>
            <h4>UserAddEdit route props</h4>
            <pre>{
              JSON.stringify({
                location: this.props.location,
                match: this.props.match,
              }, null, 2)
            }</pre>
          </>
        )}
      </div>
    );
  }
}

export default withRouter(UserAddEdit)