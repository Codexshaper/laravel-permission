<template>
    <div class="users-container">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">
                    <a href="#" class="btn btn-success btn-icon-split" data-toggle="modal" data-target="#addUserModal">
                        <span class="icon text-white-50"><i class="fas fa-plus"></i></span>
                        <span class="text">Add User</span>
                    </a>
                </h6>
            </div>

             <div class="card-body">
              <div class="table-responsive">
                    <table class="table table-bordered dataTable" id="user_table" width="100%" cellspacing="0" role="grid" aria-describedby="dataTable_info" style="width: 100%;">
                    <thead>
                        <tr role="row">
                            <th>User Name</th>
                            <th>User Email</th>
                            <th>Updated At</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr  v-for="(user, index) in users" v-bind:key="user.id" role="row" v-bind:class=" ((index + 1) % 2 == 0) ? 'even' : 'odd'" :data-row="index" :id="'row_'+(user.id)">
                            <td>{{ user.name }}</td>
                            <td>{{ user.email }}</td>
                            <td>{{ user.updated_at }}</td>
                            <td>{{ user.created_at }}</td>
                            <td>
                                <a href="#" v-on:click="viewUser" class="view_user btn btn-warning" title="View" :data-id="user.id" data-toggle="modal" data-target="#viewUserModal">View</a>
                                <a href="#" v-on:click="editUser" class="edit_user btn btn-info" :data-id="user.id" title="Edit" data-toggle="modal" data-target="#editUserModal">Edit</a>
                                <a href="#" v-on:click="deleteUser" class="delete_user btn btn-danger" title="Delete" :data-id="user.id">Delete</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
              </div>
            </div>
          </div>
        <!-- User Modals -->
        <!-- Add User Modal -->
        <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="addUserLabel">Add New User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <form method="post" :action="addAction" id="add_user_form" v-on:submit.prevent="addUser">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="user_name">Name</label>
                        <input type="text" name="name" id="user_name" class="form-control" v-model="user.name" placeholder="Name">
                    </div>
                    <div class="form-group">
                        <label for="user_email">Email</label>
                        <input type="email" name="email" id="user_email" class="form-control" v-model="user.email" placeholder="Email">
                    </div>
                    <div class="form-group">
                        <label for="user_password">Password</label>
                        <input type="password" name="password" id="user_password" class="form-control" v-model="user.password" placeholder="Password">
                    </div>
                    <div class="form-group">
                        <label for="user_password_confirmation">Password Confirmation</label>
                        <input type="password" name="password_confirmation" id="user_password" class="form-control" v-model="user.password_confirmation" placeholder="Password Confirmation">
                    </div>
                    <div class="form-group">
                      <label>Roles</label>
                      <ul class="role-list" v-if="(roles.length > 0)">
                        <li v-for="role in roles" v-bind:key="role.id">
                          <input type="checkbox" name="checkedRoles[]" class="roles" :value="role.id" v-model="user.checkedRoles">
                          <label>{{ role.name }}</label>
                        </li>
                      </ul>
                    </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Add</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <!-- View User Modal -->
        <div class="modal fade" id="viewUserModal" tabindex="-1" role="dialog" aria-labelledby="viewUserLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="viewUserLabel">View User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
                <div class="modal-body">
                    <label>User name</label>
                    <p>{{ user.name }}</p>
                    <label>User Email</label>
                    <p>{{ user.email }}</p>
                    <label>Roles</label>
                    <ul v-if="(userRoles.length > 0)">
                        <li v-for="(userRole, index) in userRoles" v-bind:key="index">{{ userRole.name }}</li>
                    </ul>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
          </div>
        </div>
        <!-- Edit Role Modal -->
        <div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="editUserLabel">Edit User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <form method="post" :action="editAction" v-on:submit.prevent="updateUser" id="edit_user_form">
                <input type="hidden" name="user_id" id="user_id" v-model="user.id">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="user_name">Name</label>
                        <input type="text" name="name" id="user_name" class="form-control" v-model="user.name" placeholder="Name">
                    </div>
                    <div class="form-group">
                        <label for="user_email">Email</label>
                        <input type="email" name="email" id="user_email" class="form-control" v-model="user.email" placeholder="Email">
                    </div>
                    <div class="form-group">
                        <label for="user_password">Password</label>
                        <input type="password" name="password" id="user_password" class="form-control" v-model="user.password" placeholder="Password">
                    </div>
                    <div class="form-group">
                        <label for="user_password_confirmation">Password Confirmation</label>
                        <input type="password" name="password_confirmation" id="user_password" class="form-control" v-model="user.password_confirmation" placeholder="Password Confirmation">
                    </div>
                    <div class="form-group">
                      <label>Roles</label>
                      <ul class="role-list" v-if="(roles.length > 0)">
                        <li v-for="role in roles" v-bind:key="role.id">
                            <input type="checkbox" name="checkedRoles[]" v-bind:value="role.id" v-model="user.checkedRoles">
                            <label>{{ role.name }}</label>
                        </li>
                      </ul>
                    </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Update</button>
                </div>
              </form>
            </div>
          </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['addAction', 'editAction'],
        data(){
            return {
                users:[],
                user: {
                    id:'',
                    name:'',
                    email: '',
                    checkedRoles: []
                },
                userRoles: [],
                roles: [],
                isChecked: true
            };
        },
        created(){
            this.fetchUsers();
            this.fetchRoles();
        },
        methods: {
            fetchUsers() {
              let parent = this;
              fetch('/admin/users/all')
                .then(res => res.json())
                .then(res => {
                    this.destroyDataTables();
                    this.users = res.users;
                    this.initDataTables();
                })
                .catch(err => console.log(err));
            },
            fetchRoles: function(){
                fetch('/admin/roles/all')
                  .then(res => res.json())
                  .then(res => {
                      this.destroyDataTables();
                      this.roles = res.roles;
                      // console.log( this.roles );
                  })
                  .catch(err => console.log(err));
            },
            addUser: function(event){
                var self = this;
                axios({
                  method: 'post',
                  url: event.target.action,
                  data: this.user
                })
                .then(function(response){
                    // console.log( response.data );
                    self.resetForm();
                    self.fetchUsers();
                })
                .catch(function(err){
                    // console.log( err );
                });
            },
            editUser: function(event){
                var id = event.target.getAttribute('data-id');
                var self = this;
                axios({
                    method: 'get',
                    url: '/admin/user/edit/'+id,
                    responseType: 'json'
                }).then(function (response) {
                    // console.log( response.data );
                    self.user = response.data.user;
                    self.user.checkedRoles = response.data.userRoles;
                });
            },
            updateUser: function(event){
                event.preventDefault();
                var self = this;
                axios({
                  method: 'put',
                  url: event.target.action,
                  data: this.user
                })
                .then(function(response){
                    // console.log( response.data );
                    self.fetchUsers();
                })
                .catch(function(err){
                    // console.log( err );
                });
            },
            viewUser: function(event){
                var id = event.target.getAttribute('data-id');
                var parent = this;
                axios({
                    method: 'get',
                    url: '/admin/user/'+id,
                    responseType: 'json'
                }).then(function (response) {
                    // console.log( response.data );
                    parent.user = response.data.user;
                    parent.userRoles = response.data.userRoles;
                });
            },
            deleteUser: function(event){
                event.preventDefault();
                var id = event.target.getAttribute('data-id');
                var self = this;
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You will not be able to recover this Role',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, keep it'
                }).then((result) => {
                    if (result.value) {
                        axios({
                          method: 'delete',
                          url: '/admin/user/delete/'+id,
                        })
                        .then(function(response){
                            // console.log( response.data );
                            // self.resetForm();
                            self.fetchUsers();
                            Swal.fire(
                                'Deleted!',
                                'User Deleted Successfully',
                                'success'
                            );
                        })
                        .catch(function(err){
                            // console.log( err );
                        });
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        Swal.fire(
                            'Cancelled',
                            'Your imaginary file is safe :)',
                            'error'
                        )
                    }
                });
            },
            initDataTables: function(){
                $(document).ready(function(){
                    setTimeout(function() {
                        $("#user_table").DataTable({
                            order: [[2,'desc']]
                        });
                    }, 1000);
                });
            },
            destroyDataTables: function(){
                $('#user_table').dataTable().fnDestroy();
            },
            data: function( name ){
                return event.target.getAttribute('data-'+name);
            },
            attr: function( attribute ){
                return event.target.getAttribute(attribute);
            },
            resetForm: function(){
                this.user.id = '';
                this.user.name = '';
                this.user.email = '';
                this.user.password= '';
                this.user.password_confirmation = '';
                this.user.checkedRoles = [];
            },
        },
        mounted() {
            // console.log('Component mounted.')
        }
    }
</script>