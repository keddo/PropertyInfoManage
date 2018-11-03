
<template>
    <div class="container mt-3">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-widget widget-user">
              <!-- Add the bg color to the header using any of the bg-* classes -->
              <div class="widget-user-header bg-info-active">
                <h3 class="widget-user-username" >{{this.form.name}}</h3>
                <h5 class="widget-user-desc">Web Designer &amp; Ass. Lecturer</h5>
              </div>
              <div class="widget-user-image">
                <img class="img-circle elevation-2" :src="getProfile()" alt="User Avatar">
              </div>
              <div class="card-footer">
                <div class="row">
                  <div class="col-sm-4 border-right">
                    <div class="description-block">
                      <h5 class="description-header">3,200</h5>
                      <span class="description-text">SALES</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-4 border-right">
                    <div class="description-block">
                      <h5 class="description-header">13,000</h5>
                      <span class="description-text">FOLLOWERS</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-4">
                    <div class="description-block">
                      <h5 class="description-header">35</h5>
                      <span class="description-text">PRODUCTS</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
              </div>
            </div>
            </div>

            <div class="col-md-8">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link active show" href="#settings" data-toggle="tab"> <i class="fas fa-cog"></i> Setting</a></li>
                  <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Check</a></li>
                  <li class="nav-item"><a class="nav-link" href="#activity" data-toggle="tab">Comming soon</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="tab-pane" id="activity">
                    

                  
                  </div>
                  <!-- /.tab-pane -->
                  <div class="tab-pane" id="timeline">
                    
                  </div>
                  <!-- /.tab-pane -->

                  <div class="tab-pane active show" id="settings">
                    <form class="form-horizontal">
                      <div class="form-group">
                        <label for="name"  class="col-sm-2 control-label">Name</label>

                        <div class="col-sm-10">
                          <input type="email" :class="{ 'is-invalid': form.errors.has('name') }" v-model="form.name" class="form-control" name="name" id="name" placeholder="Name">
                        <has-error :form="form" field="name"></has-error>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="email" class="col-sm-2 control-label">Email</label>

                        <div class="col-sm-10">
                          <input type="email" :class="{ 'is-invalid': form.errors.has('email') }" v-model="form.email" class="form-control"  name="email" id="email" placeholder="Email">
                           <has-error :form="form" field="email"></has-error>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="skills" class="col-sm-2 control-label">Experience</label>

                        <div class="col-sm-10">
                          <textarea v-model="form.skills" :class="{ 'is-invalid': form.errors.has('skills') }" rows="8" class="form-control" name="skills" id="experience" placeholder="Experience"></textarea>
                           <has-error :form="form" field="skills"></has-error>
                        </div>
                      </div>
                      
                      <div class="form-group">
                        <label for="profile_pic" class="col-sm-2 control-label">Profile</label>

                        <div class="col-sm-10">
                          <input type="file"  @change="updateProfile" class="form-control" id="profile" name="profile_pic">
                        </div>
                      </div>

                       <div class="form-group">
                        <label for="password" class="col-sm-2 control-label">Password</label>

                        <div class="col-sm-10">
                          <input type="password" :class="{ 'is-invalid': form.errors.has('password') }" v-model="form.password" class="form-control" name="password" id="password" placeholder="Password">
                           <has-error :form="form" field="password"></has-error>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                          <button type="submit" @click.prevent="updateProfileInfo" class="btn btn-success">Update</button>
                        </div>
                      </div>
                    </form>
                  </div>
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.nav-tabs-custom -->
          </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
           return {
              form: new Form({
                    id: '',
                    name: '',
                    email: '',
                    password: '',
                    type: '',
                    skills: '',
                    profile_pic: ''
            })
           }
        },
        methods:{
         getProfile(){
           let photo = (this.form.profile_pic.length > 100)? this.form.profile_pic:'img/profiles/'+ this.form.profile_pic;
           return photo;
         },
         updateProfileInfo(){
             this.$Progress.start();
              this.form.put('api/profile')
              .then(()=>{
                Fire.$emit('profilechanged');
                this.$Progress.finish();
              }).catch(()=>{
                   this.$Progress.fail();
              })
         },
         updateProfile(e){
           let file = e.target.files[0];
           let reader = new FileReader();
          if(file['size']<2111775){
           reader.onloadend = (file)=>{
               //console.log('RESULT', reader.result);
               this.form.profile_pic = reader.result;
           }
           reader.readAsDataURL(file);
          }else{
              swal({
                  type: 'error',
                  title: 'Oops....',
                  text: 'You are uploading a large file.'
              });
          }
         }
        },
        created() {
           axios.get('api/profile').
           then(({data})=>{
              this.form.fill(data);
           })

           Fire.$on('profilechanged', ()=>{
             return this.getProfile();
           })
        }
    }
</script>