import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { LoginComponent } from './login/login.component';
import { SignupComponent } from './signup/signup.component';
import { DashboardComponent } from './dashboard/dashboard.component';
import { ChatComponent } from './chat/chat.component';
import { PublicchatComponent } from './chat/publicchat.component';
import { MychatComponent } from './chat/mychat.component'; 
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
import { EditproductComponent } from './pages/manageproducts/editproduct/editproduct.component';
import { ManageserviceComponent } from './pages/manageservice/manageservice.component';
import { ManagecontactsComponent } from './pages/managecontacts/managecontacts.component';
import { AddserviceComponent } from './pages/manageservice/addservice.component';
import { AddcontactComponent } from './pages/managecontacts/addcontact.component';
import { ManagetransferComponent } from './pages/managetransfer/managetransfer.component';
import { PackageinfoComponent } from './pages/packageinfo/packageinfo.component';
import { EdituserComponent } from './pages/manageuser/edituser.component';
import { ForgotpasswordComponent } from './forgotpassword/forgotpassword.component';

import { ManageearningsComponent } from './pages/manageearnings/manageearnings.component';
import { AddearningsComponent } from './pages/manageearnings/addearnings.component';
import { EditearningsComponent } from './pages/manageearnings/editearnings.component';
import {EditcategoryComponent} from './pages/managecategory/editcategory.component';
import {EditsubcategoryComponent} from './pages/managesubcategory/editsubcategory.component';
import {EditserviceComponent} from './pages/manageservice/editservice.component';
import {ManageadvertisementComponent} from './pages/manageadvertisement/manageadvertisement.component';
import {AddadvertisementComponent} from './pages/manageadvertisement/addadvertisement.component';
import {EditadvertisementComponent} from './pages/manageadvertisement/editadvertisement.component';
import { EditcontactComponent } from './pages/managecontacts/editcontact.component';

import { LandingpageComponent } from './landingpage/landingpage.component';
import { ManagetemplateComponent } from './pages/managetemplates/managetemplate.component';
import { AddtemplateComponent } from './pages/managetemplates/addtemplate.component';
import { EdittemplateComponent} from './pages/managetemplates/edittemplate.component';
import { ChatgroupComponent } from './pages/chatgroup/chatgroup.component';
import { ManagegroupchannelComponent } from './pages/managegroupchannel/managegroupchannel.component';
import { ViewchatComponent } from './pages/managegroupchannel/viewchat.component';

import { ViewsubscribersComponent } from './pages/managegroupchannel/viewsubscribers.component';

const routes: Routes = [
  {
	  path: '',
	  component: LandingpageComponent
  },
  {
	  path: 'login',
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
	  path: 'chat',
	  component: ChatComponent
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
  {
    path:'manageearnings',
    component:ManageearningsComponent
  },
  {
    path:'addearnings',
    component:AddearningsComponent
  },
  {
    path:'editearnings/:id',
    component:EditearningsComponent
  },
  {
    path:'editcategory/:id',
    component:EditcategoryComponent
  },
  {
    path:'editsubcategory/:id',
    component:EditsubcategoryComponent
  },
  {
    path:'editproduct/:id',
    component:EditproductComponent
  },
  {
     path:'editservice/:id',
    component:EditserviceComponent
    
  },
  {
     path:'editad/:id',
    component:EditadvertisementComponent
    
  },
  
  {
     path:'manageads',
      component:ManageadvertisementComponent    
  },
  {
     path:'addads',
     component:AddadvertisementComponent    
  },
   {
     path:'editcontact/:id',
    component:EditcontactComponent
    
  },
  {
    path:'managetemplates',
    component:ManagetemplateComponent
  },
  {
    path:'addtemplate',
    component:AddtemplateComponent
  },
  {
     path:'edittemplate/:id',
    component:EdittemplateComponent
    
  },
  {
     path:'chat/join/:code',
    component:ChatgroupComponent
    
  },
   {
    path:'managegroupchannel',
    component:ManagegroupchannelComponent
  },
  {
     path:'viewchat/:id',
    component:ViewchatComponent
    
  },
  {
     path:'viewsubscribers/:id',
    component:ViewsubscribersComponent
    
  },
  {
     path:'chat/public/:code',
    component:PublicchatComponent
    
  },{
     path:'mychat',
    component:MychatComponent
    
  },

];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
