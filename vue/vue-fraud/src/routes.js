import HomeComponent from './components/HomeComponent.vue'
import SignUp from './components/SignUp.vue'
import loginComponent from './components/loginComponent.vue'
import adminComponent from './components/adminComponent.vue'
import UserAccount from './components/UserAccount.vue'
import AboutUs from './components/AboutUs.vue'




import {createRouter, createWebHistory} from 'vue-router'

const routes = [
    {
        name:'Home',
        component: HomeComponent,
        path:'/',

    },
    {
        name:'AboutUs',
        component: AboutUs,
        path:'/about',

    },
    {
        name:'UserAccount',
        component: UserAccount,
        path:'/account',

    },
    {
        name:'adminComponent',
        component: adminComponent,
        path:'/admin',

    },
    
    {
        name:'SignUp',
        component: SignUp,
        path:'/signup',
    },
    {
        name:'loginComponent',
        component: loginComponent,
        path:'/login',

    }

]

const router=createRouter({
    history:createWebHistory(),
    routes

});

export default router