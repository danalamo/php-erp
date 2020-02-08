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
          <Link to={route('react').index}>HOME</Link> |
          <span>
            Employees: 
            <Link to={route('react').userAdd}>ADD</Link>
          </span>
        </div>
        <h1 className="page-title">{data.page_title}</h1>
        <div className="page-body">
          <Switch>
            <Route path={route('react').index} exact>
              <UserList data={data} />
            </Route>
            <Route path={route('react').userAdd} exact>
              <UserAddEdit data={data} />
            </Route>
            <Route path={route('react').userEdit(':user_id')}>
              <UserAddEdit data={data} />
            </Route>
          </Switch>
        </div>
        {window.erpDebug() && (
          <>
            <h4>App route props</h4>
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
