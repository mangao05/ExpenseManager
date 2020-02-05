<template>
    <div>
        <new-header  :labels="labels"></new-header>
		
        <div class="row">
           <div class="col-12">
            <div class="card">
              <!-- /.card-header -->
              	<div class="card-body table-responsive  p-0">
					<table class="table table-hover table-striped">
						<thead class="bg-secondary">
							<tr>
								<th>Expense Category</th>
								<th>Description</th>
								<th>Amount</th>
								<th>Created at</th>
							</tr>
						</thead>
						<tbody>
							<tr v-if="expenses.length < 1" >
								<td class="text-center font-weight-bold" colspan="4"><i>No Data...</i></td>
							</tr>
							<tr v-else 
								v-for="expense in expenses" 
								:key="expense.id" 
								@click="
									form.id=expense.id,
									form.amount=expense.amount,
									form.entry_date=expense.entry_date,
									form.category_id=expense.category_id,
									modalTitle='Update Expense'
									updateMode=true,
									form.clear()
								"
								data-toggle="modal" 
								data-target="#expense_modal"
							>
								<td>{{ expense.category.name }}</td>
								<td>${{ expense.amount }}</td>
								<td>{{ expense.entry_date | formatDate}}</td>
								<td>{{ expense.created_at | formatDate}}</td>
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
					data-target="#expense_modal" 
					class="btn btn-success" 
					@click="
						updateMode = false,
						form.clear(),
						form.reset(),
						modalTitle='Add Expense'
					"
				>
				Add Expenses 
			</button>
        </div>

		<!-- Modal -->
		<form @submit.prevent="updateMode ? updateExpenses() : saveExpenses()">
			<div class="modal fade" id="expense_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        <div class="form-group" :class="{ 'has-error': form.errors.has('category') }">
							<label>Select Category</label>
							<select class="form-control" style="height: 35px;" v-model="form.category_id">
								<option value="">Select Category</option>
								<option v-for="category in categories" :key="category.id" :value="category.id">{{ category.name }}</option>
								<has-error :form="form" field="category_id"></has-error>
							</select>
						</div>		
						<div class="form-group" :class="{ 'has-error': form.errors.has('amount') }">
							<label for="amount">Amount</label>
							<input type="number" v-model="form.amount" class="form-control" id="amount" placeholder="Amount" />
							<has-error :form="form" field="amount"></has-error>
						</div>
						<div class="form-group" :class="{ 'has-error': form.errors.has('email') }">
							<label for="email">Entry Date</label>
							<input type="date" v-model="form.entry_date" class="form-control" id="entry_date">
							<has-error :form="form" field="entry_date"></has-error>
						</div>
										
					</div>
					<div class="modal-footer">
                    	<button type="button" @click="deleteExpenses()" class="btn btn-danger mr-auto" v-show="updateMode">Delete</button>

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
</template>

<script>
	var user_id = document.querySelector("meta[name='user-id']").getAttribute("content");
    export default {
         data(){
            return {
				
                 labels : {
                    page : 'Expenses',
                    isChild : true,
                    parent : 'Expense Management'
                },
                categories : [],
                expenses : [],
                form : new Form({
                    id: '',
                    category_id : '',
                    amount : '',
                    entry_date: '',
					user_id: user_id
                }),
                updateMode : false,
				modalTitle : 'Add Expenses',
				alert_message: "User Successfully Created"
            }
        },
        methods: {
            initialize(){
                this.getAllCategories();
                this.getExpenses();
            },
            getAllCategories(){
                axios.get("/api/categories").then(({data}) => {
                    this.categories = data
                });
            },
            getExpenses(){
                axios.get('/api/expenses/'+user_id).then(({data})=>{
                    this.expenses = data;
                })
            },
            saveExpenses(){
                this.form.post('/api/expenses').then(({data}) => {
                    console.log(data);
                    this.initialize();
                    this.form.reset();
                    this.resetForm();
                })
            },
            updateExpenses(){
                this.form.put('/api/expenses/'+this.form.id).then(({data}) => {
                    this.initialize();
                })
            },
            deleteExpenses(){
                this.form.delete('/api/expenses/'+this.form.id).then(({data}) => {
                    this.initialize();
                    this.resetForm();
                    $("#expense_modal").modal('hide');
                })
            },
            resetForm(){
                this.form.id = '';
                this.form.category_id = '';
                this.form.amount = '';
                this.form.entry_date = '';
            }
        }, 
        created(){
            this.initialize();	
        }
    }
</script>
