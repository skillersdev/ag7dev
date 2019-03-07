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
import {EditpackageComponent} from './pages/managepackages/editpackages.component';
import { AdmindashboardComponent } from './admindashboard/admindashboard.component';
import { MarketmanagersComponent } from './pages/marketmanagers/marketmanagers.component';
import { AccountinfoComponent } from './pages/accountinfo/accountinfo.component';
import { ManagecategoryComponent } from './pages/managecategory/managecategory.component';
import { ManagesubcategoryComponent } from './pages/managesubcategory/managesubcategory.component';
import { ManageproductsComponent } from './pages/manageproducts/manageproducts.component';
import { AddcategoryComponent } from './pages/managecategory/addcategory.component';
import { AddsubcategoryComponent } from './pages/managesubcategory/addsubcategory.component';
import { AddproductComponent } from './pages/manageproducts/addproduct.component';
import { ManageserviceComponent } from './pages/manageservice/manageservice.component';
import { ManagecontactsComponent } from './pages/managecontacts/managecontacts.component';
import { AddserviceComponent } from './pages/manageservice/addservice.component';
import { AddcontactComponent } from './pages/managecontacts/addcontact.component';
import { ManagetransferComponent } from './pages/managetransfer/managetransfer.component';
import { PackageinfoComponent } from './pages/packageinfo/packageinfo.component';
import { EdituserComponent } from './pages/manageuser/edituser.component';
import { ForgotpasswordComponent } from './forgotpassword/forgotpassword.component';

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
    path:'edituser/:id',
    component:EdituserComponent
  },
  {
    path:'addpackage',
    component:AddpackageComponent
  },
  {
    path:'editpackage/:id',
    component:EditpackageComponent
  },
  
  {
    path:'admindashboard',
    component:AdmindashboardComponent
  },
 {
    path:'managemarketers',
    component:MarketmanagersComponent
  },
  {
    path:'accountinfo',
    component:AccountinfoComponent
  },
  {
    path:'managecategory',
    component:ManagecategoryComponent
  },
  {
    path:'managesubcategory',
    component:ManagesubcategoryComponent
  },
  {
    path:'manageproducts',
    component:ManageproductsComponent
  },
  {
    path:'addcategory',
    component:AddcategoryComponent
  },
  {
    path:'addsubcategory',
    component:AddsubcategoryComponent
  },
  {
    path:'addproduct',
    component:AddproductComponent
  },
  {
    path:'manageservices',
    component:ManageserviceComponent
  },
  {
    path:'managecontacts',
    component:ManagecontactsComponent
  },
  {
    path:'addcontact',
    component:AddcontactComponent
  },
  {
    path:'addservice',
    component:AddserviceComponent
  },
  {
    path:'transferinfo',
    component:ManagetransferComponent
  },
  {
    path:'packageinfo',
    component:PackageinfoComponent
  },
  {
    path:'forgotpassword',
    component:ForgotpasswordComponent
  },
  
  

];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
