
<template>
    <div class="container mt-3">
        <div class="row">
            <div class="col-md-12 col-lg-12">
              <div class="card"><!--card-->
                <div class="card-header p-2">
                    <ul class="nav nav-pills">
                        <li class="nav-item">
                            <a href="#settings" data-toggle="tab" class="nav-link active show"> <i class="fas fa-store-alt"></i>&nbsp;All in Store</a>
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
                                     <h3 class="card-title">Material in Stock</h3>

                                     <div class="card-tools">
                                         <button type="button" class="btn btn-success" @click="addNewItemToStore"> Add to<i class="fas fa-cart-plus"></i></button>
                                     </div>
                                 </div>

                                 <div class="card-body table-responsive p-0">
                                     <table class="table table-hover">
                                          <tbody>
                                              <tr>
                                                <th>ቁጥር</th>
                                                <th>የእቃው ዓይነት</th>
                                                <th>መለያ ቁጥር</th>
                                                <th>መለክያ</th>
                                                <th>ብዛት</th>
                                                <th>ያንዱ ዋጋ</th>
                                                <th>ጠቅላላ ዋጋ</th>
                                                <th>ስቶር የገባበት ቀን</th>
                                                <th v-if="$gate.isSuperAdminOrPropertyAdmin()">ያስተካክሉ</th>
                                             </tr>

                                             <tr v-for="material in materials.data" :key="material.id">
                                                <td>{{material.id}}</td>
                                                <td>{{material.description}}</td>
                                                <td>{{material.code}}</td>
                                                <td>{{material.unit_measure}}</td>
                                                <td>{{material.quantity}}</td>
                                                <td>{{material.unit_price}}</td>
                                                <td>{{material.total_value}}</td>
                                                <td>{{material.created_at | myDate}}</td>
                                                <td>
                                                    <a href="#" @click="editItem(material)" v-if="$gate.isSuperAdminOrPropertyAdmin()">
                                                        <i class="fas fa-edit text-orang" ></i>
                                                    </a>
                                                    <a href="#" v-if="$gate.isSuperAdminOrPropertyAdmin()">
                                                        <i class="fas fa-eye green"></i>
                                                    </a>
                                                    <a href="#" @click="deleteItem(material.id)" v-if="$gate.isSuperAdmin()">
                                                        <i class="fas fa-trash-alt red"></i>
                                                    </a>
                                                </td>
                                               </tr>
                                          </tbody>

                                     </table>
                                 </div>
                                 <div class="card-footer">
                                     <pagination :data="materials" @pagination-change-page="getResults"></pagination>
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
                <h5 v-show="!editMode" class="modal-title" id="exampleModalLabel">Add Item to Stock</h5>
                <h5 v-show="editMode" class="modal-title" id="exampleModalLabel">Edit Stock Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form @submit.prevent="editMode ? updateItem() : addMaterials()" @keydown="form.onKeydown($event)">
            <div class="modal-body">
                    <div class="form-group">
                      <input v-model="form.description" type="text" name="description" placeholder="የእቃው ዓይነት"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('description') }">
                      <has-error :form="form" field="description"></has-error>
                    </div>
                    <div class="form-group">
                      <input v-model="form.code" type="text" name="email" placeholder="መለያ ቁጥር"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('code') }">
                      <has-error :form="form" field="code"></has-error>
                    </div>
                    <div class="form-group">
                      <input v-model="form.unit_measure" type="text" name="unit_measure" placeholder="መለክያ"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('unit_measure') }">
                      <has-error :form="form" field="unit_measure"></has-error>
                    </div>
                    <div class="form-group">
                      <input v-model="form.quantity" type="number" name="quantity" placeholder="ብዛት"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('quantity') }">
                      <has-error :form="form" field="quantity"></has-error>
                    </div>
                    <div class="form-group">
                      <input v-model="form.unit_price" type="number" name="unit_price" placeholder="ያንዱ ዋጋ"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('unit_price') }">
                      <has-error :form="form" field="unit_price"></has-error>
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
               materials: {},
               form: new Form({
                   id: '',
                   description: '',
                   code: '',
                   unit_measure: '',
                   quantity: '',
                   unit_price: '',
                   total_value: ''
               })
           }
        },
        methods: {
         updateItem(){
             this.form.put('api/material/' + this.form.id)
             .then(() => {
                 this.$Progress.start();
                 $('#addNew').modal('hide');
                 Fire.$emit('refresh');
                 toast({
                     type: 'success',
                     title: 'Material on store edited Successfully.'
                 });
                 this.$$Progress.finish();

             })
             .catch( ()=>{
                 this.$Progress.fail();
             });
         },
         editItem(material){
             this.editMode = true;
             this.form.reset();
             $('#addNew').modal('show');
             this.form.fill(material);
         },
         addNewItemToStore(){
                this.editMode = false;
                this.form.reset();
                $('#addNew').modal('show');
            },
          addMaterials(){
            this.$Progress.start();
            this.form.post('api/material')
            .then(() => {
              Fire.$emit('refresh');
              $('#addNew').modal('hide');
              toast({
                  type: 'success',
                  title: 'Material Added to Store Successfully'
              });
            })
            .catch((error) => {
                 console.log(error);
            });
            this.$Progress.finish();
          },
          loadMaterials(){
             axios.get('api/material').then(({data}) => {
                 this.materials = data;
             })
          },
          deleteItem(id){
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
                    this.form.delete('api/material/' + id)
                    .then(()=>{
                        swal(
                            'Deleted!',
                             'Item has been deleted.',
                             'success'
                        );
                       Fire.$emit('refresh');
                    }).catch( ()=> {
                        swal('Faid', 'There was something wrong.', 'warning');
                    })
                }
            });
          },
          getResults(page = 1) {
			axios.get('api/material?page=' + page)
				.then(response => {
					this.materials = response.data;
				});
		}
        },
        created() {
           this.loadMaterials();
           Fire.$on('refresh', ()=>{
               this.loadMaterials();
           })
        }
    }
</script>
