<template>
    <div>
        <new-header  :labels="labels"></new-header>
        <div class="row justify-content-center">
            <div class="col-6">
                
                <form @submit.prevent="changePassword()">
                    <div class="form-group" :class="{ 'has-error': form.errors.has('old_password') }">
                        <label for="old_password">Old Password</label>
                        <input :type="typeInput" v-model="form.old_password" class="form-control" />
                        <has-error :form="form" field="old_password"></has-error>
                    </div>
                    <div class="form-group" :class="{ 'has-error': form.errors.has('password') }">
                        <label for="password">Password</label>
                        <input :type="typeInput" v-model="form.password" class="form-control" />
                        <has-error :form="form" field="password"></has-error>

                        
                    </div>
                    <div class="form-group"  :class="{ 'has-error': form.errors.has('password_confirmation') }">
                        <label for="old_password">Retype Password</label>
                        <input :type="typeInput" v-model="form.password_confirmation" class="form-control"/>
                        <has-error :form="form" field="password_confirmation"></has-error>
                    </div>
                    <a href="#" @click="showPassword()">Show password</a><br>
                    <input type="submit" value="Submit" class="btn btn-success"/>
                </form>
            </div>
        </div>
    </div>
</template>
<script>
var user_id = document.querySelector("meta[name='user-id']").getAttribute("content");
export default {
    data(){
        return {
            id: user_id,
            labels : {
                page : 'Change Password',
                isChild : false,
                parent : 'none'
            },
            typeInput: 'password',
            form : new Form({
                id: user_id,
                old_password: '',
                password: '',
                password_confirmation : ''
            })
        }
    },
    methods : {
        changePassword(){
            this.form.post('/api/changepassword/').then(({data}) => {
                if(data == 1){
                    alert("Old Password does not match to our record!");
                }else{
                    alert("Succesful");
                    this.form.clear();
                    this.form.reset();
                }
            })
        },
        showPassword(){
           
            this.typeInput == 'password' ? this.typeInput = 'text' : this.typeInput = 'password';
        }
    },
    
}
</script>