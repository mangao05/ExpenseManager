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
								<th>Email Address</th>
								<th>Role</th>
								<th>Created at</th>
							</tr>
						</thead>
						<tbody>
							<tr v-if="users.length < 1" >
								<td class="text-center font-weight-bold" colspan="4"><i>No Data...</i></td>
							</tr>
							<tr v-else 
								v-for="user in users" 
								:key="user.id" 
								@click="
									form.id=user.id,
									form.name=user.name,
									form.email=user.email,
									form.role=user.role_id,
									modalTitle='Update User'
									updateMode=true,
									form.clear()
								"
								data-toggle="modal" 
								data-target="#user_modal"
							>
								<td>{{ user.name }}</td>
								<td>{{ user.email }}</td>
								<td>{{ user.role.name }}</td>
								<td>{{ user.created_at | formatDate}}</td>
							</tr>
						</tbody>
					</table>
              	</div>
              <!-- /.card-body -->
			</div>
            <!-- /.card -->
          </div>
		 
 <div class="button-add ml-auto">
            <button type="button" 
					data-toggle="modal" 
					data-target="#user_modal" 
					class="btn btn-success" 
					@click="
						updateMode = false,
						form.clear(),
						form.reset(),
						modalTitle='Add User'
					"
				>
				Add User 
			</button>
        </div>
		<!-- Modal -->
		<form @submit.prevent="updateMode ? updateUser() : saveUser()">
			<div class="modal fade" id="user_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
							<input type="text" v-model="form.name" class="form-control" id="name" placeholder="John Doe" />
							<has-error :form="form" field="name"></has-error>
						</div>
						<div class="form-group" :class="{ 'has-error': form.errors.has('email') }">
							<label for="email">Email</label>
							<input type="email" v-model="form.email" class="form-control" id="email" placeholder="sample@sample.com"/>
							<has-error :form="form" field="email"></has-error>
						</div>
						<div class="form-group" v-show="updateMode" :class="{ 'has-error': form.errors.has('password') }">
							<label for="password">Password</label>
							<input type="password" class="form-control" v-model="form.password" id="password" placeholder="Enter password"/>
							<has-error :form="form" field="password"></has-error>
						</div>
						<div class="form-group" :class="{ 'has-error': form.errors.has('role') }">
							<label>Select Role</label>
							<select class="form-control" style="height: 35px;" v-model="form.role">
								<option value="">Select Role</option>
								<option v-for="role in roles" :key="role.id" :value="role.id">{{ role.name }}</option>
								<has-error :form="form" field="role"></has-error>
							</select>
						</div>						
					</div>
					<div class="modal-footer">
                    	<button type="button" @click="deleteUser()" class="btn btn-danger mr-auto" v-show="updateMode">Delete</button>

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
                    page : 'User',
                    isChild : true,
                    parent : 'User Management'
                },
				updateMode : false,
				modalTitle : 'Add User',
				users: [],
				roles: [],
				form: new Form({
					id: '',
					role : '',
					name : '',
					password: '',
					email : ''
				}),
				alert_message: "User Successfully Created"
            }
        },
		methods : {
			initialize(){
				this.getAllUsers();
				this.getRoles();
			},
			getAllUsers(){
				axios.get('/api/user').then(({data}) => {
					this.users = data
				});
			},
			getRoles(){
				axios.get('/api/roles').then(({data}) => {
					this.roles = data
				});
			},
			saveUser(){
				this.form.post('/api/user').then(({data}) => {
					this.alert_message = "User Successfully Created";
					this.resetForm();
					this.getAllUsers();
				})
			},
			updateUser(){
				this.form.put('/api/user/'+this.form.id).then(({data}) => {
					this.alert_message = "User Successfully Updated";
					this.getAllUsers();
				});
			},
			deleteUser(){
				this.form.delete('/api/user/'+this.form.id).then(({data}) => {
					if(data == 1){
						this.alert_message = "Cant Delete User with Admin Role";
					}else{
						$("#user_modal").modal('hide');
						this.getAllUsers();
					}
			
				})
			},
			resetForm(){
				this.form.name = "";
				this.form.role = "";
				this.form.password = "";
				this.form.email = "";
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
