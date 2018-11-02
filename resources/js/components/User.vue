<template>
    <div class="container mt-3">
        <div class="row">
            <div class="col-md-12 col-lg-12">
              <div class="card"><!--card-->
                <div class="card-header p-2">
                    <ul class="nav nav-pills">
                        <li class="nav-item">
                            <a href="#settings" data-toggle="tab" class="nav-link active show"> <i class="fas fa-users"></i>&nbsp;List</a>
                        </li>
                        <li class="nav-item">
                            <a href="#timeline" data-toggle="tab" class="nav-link">Check</a>
                        </li>
                        <li class="nav-item">
                            <a href="#activity" data-toggle="tab" class="nav-link"> Comming Soon</a>
                        </li>
                    </ul>

                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div id="settings" class="tab-pane active show">
                             <div class="card">
                                 <div class="card-header">
                                     <h3 class="card-title">Employee List</h3>

                                     <div class="card-tools">
                                         <button type="button" class="btn btn-success" @click="addNewEmployee"> Add &nbsp;<i class="fas fa-user-plus"></i></button>
                                     </div>
                                 </div>

                                 <div class="card-body table-responsive p-0">
                                     <table class="table table-hover">
                                          <tbody>
                                              <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Type</th>
                                                <th>Created</th>
                                                <th>Modify</th>
                                             </tr>

                                             <tr v-for="user in users.data" :key="user.id">
                                                <td>{{user.id}}</td>
                                                <td>{{user.name}}</td>
                                                <td>{{user.email}}</td>
                                                <td>{{user.type}}</td>
                                                <td>{{user.created_at | myDate}}</td>
                                                <td>
                                                    <a href="#" >
                                                        <i class="fas fa-edit text-orang" @click="editEmployee(user)"></i>
                                                    </a>
                                                    <a href="#">
                                                        <i class="fas fa-eye green"></i>
                                                    </a>
                                                    <a href="#" @click="deleteEmployee(user.id)">
                                                        <i class="fas fa-trash-alt red"></i>
                                                    </a>
                                                </td>
                                               </tr>
                                          </tbody>

                                     </table>
                                 </div>
                             </div>

                        </div>
                        <!-- Timeline -->
                        <div id="timeline" class="tab-pane">

                        </div>
                        <div id="activity" class="tab-pane">

                        </div>

                    </div>
                </div>
               

              </div>
            </div>
        </div>

     <!-- Modal -->
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 v-show="!editMode" class="modal-title" id="exampleModalLabel">Add New Employeek</h5>
                <h5 v-show="editMode" class="modal-title" id="exampleModalLabel">Edit an Employee</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form @submit.prevent="editMode ? updateEmployee() : addEmployee()" @keydown="form.onKeydown($event)">
            <div class="modal-body">
                    <div class="form-group">
                      <input v-model="form.name" type="text" name="name" placeholder="Name"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                      <has-error :form="form" field="name"></has-error>
                    </div>
                    <div class="form-group">
                      <input v-model="form.email" type="email" name="email" placeholder="Email"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                      <has-error :form="form" field="email"></has-error>
                    </div>
                    <div class="form-group">
                      <textarea v-model="form.skills" rows="10" name="skills" placeholder="Experience"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('skills') }"></textarea>
                      <has-error :form="form" field="skills"></has-error>
                    </div>
                    <div class="form-group">
                      <select v-model="form.type" name="type"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('type') }">
                        <option value="">Select User Role</option>
                        <option value="Super Admin">Super Admin</option>
                        <option value="Admin">Admin</option>
                        <option value="Head">Head</option>
                        <option value="Teacher">Teacher</option>
                        <option value="Assistant">Assistant</option>
                      </select>
                      <has-error :form="form" field="type"></has-error>
                    </div>
                    <div class="form-group">
                      <input v-model="form.password" type="password" name="password" placeholder="Password"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                      <has-error :form="form" field="password"></has-error>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button v-show="!editMode" type="submit" class="btn btn-primary">Save</button>
                <button v-show="editMode" type="submit" class="btn btn-primary">Save changes</button>
            </div>
            </form>
            </div>
        </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
           return{
               editMode: true,
               users: {},
               form: new Form({
                   id: '',
                   name: '',
                   email: '',
                   type: '',
                   skills: '',
                   password: '',
                   profile_pic: ''
               })
           }
        },
        methods: {
         deleteEmployee(id){
            swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                ConfirmButtonText: 'Yes, Delete it!'
            }).then((result)=>{
                if(result.value){
                    this.form.delete('api/user/' + id)
                    .then(()=>{
                        swal(
                            'Deleted!',
                             'User has been deleted.',
                             'success'
                        );
                       Fire.$emit('refresh');
                    }).catch( ()=> {
                        swal('Faid', 'There was something wrong.', 'warning');
                    })
                }
            });
         },
         updateEmployee(){
             this.form.put('api/user/' + this.form.id)
             .then(() => {
                 this.$Progress.start();
                 $('#addNew').modal('hide');
                 Fire.$emit('refresh');
                 toast({
                     type: 'success',
                     title: 'Employee on store edited Successfully.'
                 });
                 this.$$Progress.finish();

             })
             .catch( ()=>{
                 this.$Progress.fail();
             });
         },
         editEmployee(user){
             this.editMode = true;
             this.form.reset();
             $('#addNew').modal('show');
             this.form.fill(user);
         },
         addNewEmployee(){
                this.editMode = false;
                this.form.reset();
                $('#addNew').modal('show');
            },
          addEmployee(){
            this.$Progress.start();
            this.form.post('user')
            .then(() => {
              Fire.$emit('refresh');
              $('#addNew').modal('hide');
              toast({
                  type: 'success',
                  title: 'Employee Added to Store Successfully'
              });
            })
            .catch((error) => {
                 console.log(error);
            });
            this.$Progress.finish();
          },
          loadEmployees(){
             axios.get('api/user').then(({data}) => {
                 this.users = data;
             })
          },
        },
        created() {
           this.loadEmployees();
           Fire.$on('refresh', ()=>{
               this.loadEmployees();
           })
        }
    }
</script>

