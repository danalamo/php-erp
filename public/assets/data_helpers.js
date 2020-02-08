
export const request = async (url, options = {}) => {
  const defaultOpts = {
    headers: {
      accept: 'text/json',
      "content-type": 'text/json',
    }
  }
  if (options.body && typeof options.body === "object") {
    options.body = JSON.stringify(options.body);
  }
  
  return await fetch(url, {...defaultOpts, ...options})
    .then((res) => {
      try {
        return res.json()
      } catch (e) {
        return res.text()
      }
    })
}

export const route = (base) => ({
  index: `/${base}`,
  userAdd: `/${base}/employee/add`,
  userEdit: (id) => `/${base}/employee/${id}/edit`,
  userDelete: (id) => `/${base}/employee/${id}/delete`,
})

export const Api = {
  getUsersWithLocations: async (query = '') => {
    return await request(`/${query}`)
  },
  getCreateUser: async () => {
    return await request('/employees/add.php')
  },
  createUser: async (payload) => {
    return await request('/employees/add.php', { 
      method: 'POST', 
      body: payload, 
    })
  },
  getUserById: async (user_id) => {
    return await request(`/employees/edit.php?user_id=${user_id}`)
  },
  updateUserById: async ({ id, ...payload }) => {
    return await request(`/employees/edit.php?user_id=${id}`, {
      method: 'POST',
      body: payload,
    })
  },
  deleteUserById: async (user_id) => {
    return await request(`/employees/delete.php?user_id=${user_id}`)
  },
}

export const formatLocation = (loc) => {
  return `
    ${loc.line1}, 
    ${loc.city}, 
    ${loc.state}
    ${loc.zip}
  `
}