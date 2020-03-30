<template>
    <form method="POST" :action="(route.login || '#')" id="loginForm">
        <input type="hidden" name="_token" :value="csrf">
            <nav class="nav nav-tabs w-100 p-1" id="loginMenu" style="margin: -4px 0; border-bottom: none; !important">
                <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-selected="true" @click="setLogin()">Log in</a>
                <a class="nav-item nav-link" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-selected="true" @click="setRegister()">Register</a>
            </nav>

            <div class="p-2" style="border: 1px solid #dee2e6; boder-top: none;">
                    <div class="form-group d-none" id="formRegisterName">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" value="" name="name" id="formInputName" placeholder="your name">
                    </div>                        
                    <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" class="form-control" value="" name="email" required placeholder="name@example.com">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" required name="password">
                    </div>                        
                    <div class="form-group d-none" id="formRegisterPasswordConfirm">
                        <label for="password">Confirm Password</label>
                        <input type="password" class="form-control" name="password_confirmation" id="formInputPasswordConfirm">
                    </div>         

                    <input type="hidden" name="redirect" :value="redirect" v-if="redirect" />

                    <button type="submit" class="btn btn-primary d-flex ml-auto" id="formLoginButton">Entry</button>
            </div>
        </v-modal>
    </form>
</template>

<script>
    export default {
        props: ['route', 'data', 'redirect'],
        data: () => ({
            csrf: config.csrf
        }),
        methods:{
            setLogin(){
                formRegisterName.classList.add('d-none');
                formInputName.required = false;
                formRegisterPasswordConfirm.classList.add('d-none');                
                formInputPasswordConfirm.required = false;

                formLoginButton.innerHTML = 'Entry';
                loginForm.action = (this.route.login || '#');
                
            },            
            setRegister(){
                formRegisterName.classList.remove('d-none');
                formInputName.required = true;
                formRegisterPasswordConfirm.classList.remove('d-none');
                formInputPasswordConfirm.required = true;

                formLoginButton.innerHTML = 'Create';
                loginForm.action = (this.route.register || '#');
                
            }
        },
        mounted() {
        }
    }
</script>
