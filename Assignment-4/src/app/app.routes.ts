import { Routes } from '@angular/router';
import {LoginComponent} from './login/login.component'
import {RegistrationComponent} from './registration/registration.component'

export const routes: Routes = [{path : "registration" , component:RegistrationComponent},{path:"login",component:LoginComponent},{path:"",redirectTo:"login",pathMatch:"full"}];
