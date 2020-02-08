import React, { Component } from 'react'
import { BrowserRouter, Route, Switch, withRouter, Link } from "react-router-dom";
import { render } from 'react-dom'
import { Api, formatLocation, route } from "../../assets/data_helpers";
import UserList from "./UserList";
import UserAddEdit from "./UserAddEdit";

class App extends Component {
  constructor(props) {
    super(props)
    
    this.state = {
      title: document.title,
      data: {}
    }
    window.app = this
  }
  
  render() {
    const { data } = this.state
    return (
      <div>
        <div className="menu-links">
          <span>
            Employees:
          </span>
        </div>
        <h1 className="page-title">{data.page_title}</h1>
        <div className="page-body"></div>
      </div>
    );
  }
}
const RoutedApp = withRouter(App)

render(
  <BrowserRouter>
    <Route path={route('react').index}>
      <RoutedApp />
    </Route>
  </BrowserRouter>,
  document.getElementById('react-app')
)

// window.errors = []
// window.swal && swal.fire(
//   "😧 Something's Wrong",
//   window.errors.join('\n'),
//   'warning'
// )
