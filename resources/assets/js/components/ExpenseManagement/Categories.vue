<template>
    <div>
        <new-header  :labels="labels"></new-header>
		<div v-if="!loaded">
			<h1 class="text-center">UnAuthorized</h1>
		</div>
        <div class="row" v-else>
            <div class="col-12">
            <div class="card">
              <!-- /.card-header -->
              	<div class="card-body table-responsive  p-0">
					<table class="table table-hover table-striped">
						<thead class="bg-secondary">
							<tr>
								<th>Name</th>
								<th>Description</th>
								<th>Created_at</th>
							</tr>
						</thead>
						<tbody>
							<tr v-if="categories.length < 1" >
								<td class="text-center font-weight-bold" colspan="4"><i>No Data...</i></td>
							</tr>
							<tr v-else 
								v-for="category in categories" 
								:key="category.id" 
								@click="
									form.id=category.id,
									form.name=category.name,
									form.description=category.description
									modalTitle='Update Category'
									updateMode=true,
									form.clear()
								"
								data-toggle="modal" 
								data-target="#category_modal"
							>
								<td>{{ category.name }}</td>
								<td>{{ category.description }}</td>
								<td>{{ category.created_at | formatDate}}</td>
							</tr>
						</tbody>
					</table>
              	</div>
              <!-- /.card-body -->
			</div>
            <!-- /.card -->
          </div>
        </div>

         <div class="button-add float-right">
            <button type="button" 
					data-toggle="modal" 
					data-target="#category_modal" 
					class="btn btn-success" 
					@click="
						updateMode = false,
						form.clear(),
						form.reset(),
						modalTitle='Add Expense Category'
					"
				>
				Add Expense Category 
			</button>
        </div>

        <!-- Modal -->
		<form @submit.prevent="updateMode ? updateCategory() : saveCategory()">
			<div class="modal fade" id="category_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">{{ modalTitle }}</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<alert-success :form="form" :message="alert_message"></alert-success>
						<div class="form-group" :class="{ 'has-error': form.errors.has('name') }">
							<label for="name">Name</label>
							<input type="text" v-model="form.name" class="form-control" id="name" placeholder="admin" />
							<has-error :form="form" field="name"></has-error>
						</div>
						<div class="form-group" :class="{ 'has-error': form.errors.has('description') }">
							<label for="description">Description</label>
							<input type="text" v-model="form.description" class="form-control" id="description" placeholder="Enter description..."/>
							<has-error :form="form" field="description"></has-error>
						</div>					
					</div>
					<div class="modal-footer">
                    	<button type="button" @click="deleteCategory()" class="btn btn-danger mr-auto" v-show="updateMode">Delete</button>

						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary">
							{{ updateMode === true ? 'Update' : 'Save'}}
						</button>
					</div>
					</div>
				</div>
			</div>
		</form>
        </div>
    </div>
</template>

<script>
	var user_id = document.querySelector("meta[name='user-id']").getAttribute("content");

    export default {
         data(){
            return {
				loaded: false,
                 labels : {
                    page : 'Categories',
                    isChild : true,
                    parent : 'Expense Management'
                },
                categories : [],
                form : new Form({
                    id : '',
                    name : '',
                    description : ''
                }),
                updateMode: false,
                modalTitle : 'Add Expense Category',
                alert_message:"Expense Category has been created succesfully"
            }
        },
        methods : {
            initialize(){
                this.getAllCategories();
            },
            getAllCategories(){
                axios.get('/api/categories').then(({data}) => {
                    this.categories = data
                })
            },
            saveCategory(){
                this.form.post('/api/categories').then(({data}) => {
                    this.initialize()
                    this.resetForm();
                })
            },
            updateCategory(){
                this.form.put('/api/categories/'+this.form.id).then(({data}) => {
                    this.initialize();
                });
            },
            deleteCategory(){
                this.form.delete('/api/categories/'+this.form.id).then(({data}) => {
                    if(data == 1){
                        this.alert_message = 'This category has many expenses . Please delete all expenses firt before you can delete this.';
                    }else{
                        $("#category_modal").modal('hide');
                        this.initialize();
                        this.resetForm();
                    }
                })
            },
            resetForm(){
                this.form.name = '';
                this.form.description = '';
                this.form.id = '';
            }
        },
        created(){
            	axios.get('/api/user/getRole/'+user_id).then(({data}) => {
				if(data.role_id != 1){
					this.loaded = false;
					alert('Error 403: UnAuthorized');
					this.$router.push('/home');
				}else{
					this.initialize();
					this.loaded = true;
				}
			})
        }
    }
</script>
