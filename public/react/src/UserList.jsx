import React, { Component } from 'react'
import { BrowserRouter, Route, Switch, withRouter, Link } from "react-router-dom";
import { render } from 'react-dom'
import { Api, formatLocation, route } from "../../assets/data_helpers";


class UserList extends Component {

  async componentDidMount() {
    const data = await Api.getUsersWithLocations()
    document.title = `${app.state.title} - ${data.page_title}`
    app.setState({ data })
  }

  async componentDidUpdate(prevProps, prevState, snapshot) {
    const { search } = this.props.location
    
    if (prevProps.location.search !== search) {
      const data = await Api.getUsersWithLocations(search)
      document.title = `${app.state.title} - ${data.page_title}`
      app.setState({ data })
    }
  }
  
  render() {
    const { 
      data, 
      history, 
      location: {
        search
      } 
    } = this.props
    
    if (!data.index) {
      return null
    }
    
    return (
      <div className="table responsive">
        <table className="stripped">
          <thead>
          <tr>
            <th><Link to={`/react${data.qstring.active}`}>Active</Link></th>
            <th><Link to={`/react${data.qstring.last_name}`}>Employee Name</Link></th>
            <th><Link to={`/react${data.qstring.line1}`}>Location</Link></th>
            <th>Actions</th>
          </tr>
          </thead>
          <tbody>
          {data.users.length === 0 && (
            <tr>
              <td colSpan="4" align="center">
                No Employees Found!
                Create one <Link to={route('react').userAdd}>here</Link>
              </td>
            </tr>
          )}
          {data.users.map(user => (
            <tr
              key={user.id}
              className={user.active == true ? '' : 'user-inactive'}>
              <td>
                <input
                  type="checkbox"
                  name="active"
                  defaultChecked={user.active == true}
                  onClick={async () => {
                    user.active = user.active == true ? false : true 
                    const data = await Api.updateUserById(user)
                    app.setState({ data })
                  }}
                />
              </td>
              <td>{user.last_name}, {user.first_name}</td>
              <td>{formatLocation(user)}</td>
              <td>
                <Link to={route('react').userEdit(user.id)}>edit</Link>&nbsp;|&nbsp;
                <a href={route('react').userDelete(user.id)}
                   onClick={async (e) => {
                     e.preventDefault();
                     const data = await Api.deleteUserById(user.id)
                     app.setState({ data })
                   }}>
                  delete
                </a>
              </td>
            </tr>
          ))}
          </tbody>
        </table>
        {window.erpDebug() && (
          <>
            <h4>Index route props</h4>
            <pre>{
              JSON.stringify({
                location: this.props.location,
                match: this.props.match,
              }, null, 2)
            }</pre>
          </>
        )}
      </div>
    )
  }
}

export default withRouter(UserList)

