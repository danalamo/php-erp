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
    this.loadData = this.loadData.bind(this)
  }
  
  componentDidMount() {
    const { user_id } = this.props.match.params
    this.loadData(user_id)
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
  }
  
  handleChange({ target }) {
    let state = this.state;
    state.user[target.name] = target.value
    if (target.type === 'checkbox') {
      state.user[target.name] = target.checked
    }
    this.setState(state)
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
            <input 
              id="save" 
              type="submit" 
              value={page_title}
            />
          </div>
        </form>
      </div>
    );
  }
}

export default withRouter(UserAddEdit)