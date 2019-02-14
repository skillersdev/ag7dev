import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { LoginComponent } from './login/login.component';
import { SignupComponent } from './signup/signup.component';
import { DashboardComponent } from './dashboard/dashboard.component';
import { ManageuserComponent } from './pages/manageuser/manageuser.component';
import { TopnavComponent } from './topnav/topnav.component';
import { SidemenuComponent } from './sidemenu/sidemenu.component';
import { ManagepackagesComponent } from './pages/managepackages/managepackages.component';
import { ManagepaymentsComponent } from './pages/managepayments/managepayments.component';
import { ProfileComponent } from './profile/profile.component';
import {AdduserComponent} from './pages/manageuser/adduser.component';
import {AddpackageComponent} from './pages/managepackages/addpackages.component';
import { AdmindashboardComponent } from './admindashboard/admindashboard.component';

const routes: Routes = [
  {
	  path: '',
	  component: LoginComponent
  },
  {
	  path: 'signup',
	  component: SignupComponent
  },
  {
	  path: 'dashboard',
	  component: DashboardComponent
  },
  {
	  path: 'manageuser',
	  component: ManageuserComponent
  },
  {
	  path: 'dashboard2',
	  component: DashboardComponent
  },
  {
	  path: 'managepackages',
	  component: ManagepackagesComponent
  },
  {
	  path: 'managepayments',
	  component: ManagepaymentsComponent
  },

  {
	  path: 'profile',
	  component: ProfileComponent
  },
  {
    path:'adduser',
    component:AdduserComponent
  },
  {
    path:'addpackage',
    component:AddpackageComponent
  },
  {
    path:'admindashboard',
    component:AdmindashboardComponent
  }

];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
