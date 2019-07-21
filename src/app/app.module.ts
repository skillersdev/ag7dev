import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { HttpClientModule } from  '@angular/common/http';

import { NgMultiSelectDropDownModule } from 'ng-multiselect-dropdown';

import { HttpModule } from '@angular/http';
import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { TopnavComponent } from './topnav/topnav.component';
import { SidemenuComponent } from './sidemenu/sidemenu.component';
import { DashboardComponent } from './dashboard/dashboard.component';
import { ChatComponent } from './chat/chat.component';
import { PublicchatComponent } from './chat/publicchat.component';
import { MychatComponent } from './chat/mychat.component';
import { LoginComponent } from './login/login.component';
import { LoginService } from './services/login.service';
import { CommonService } from './services/common.service';
import { ManageuserComponent } from './pages/manageuser/manageuser.component';
import { SignupComponent } from './signup/signup.component';
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
import { EditcontactComponent } from './pages/managecontacts/editcontact.component';
import { ManagetransferComponent } from './pages/managetransfer/managetransfer.component';
import { PackageinfoComponent } from './pages/packageinfo/packageinfo.component';
import { EdituserComponent } from './pages/manageuser/edituser.component';
import { ForgotpasswordComponent } from './forgotpassword/forgotpassword.component';
import { ManageearningsComponent } from './pages/manageearnings/manageearnings.component';
import { AddearningsComponent } from './pages/manageearnings/addearnings.component';
import { EditearningsComponent } from './pages/manageearnings/editearnings.component';
import { EditcategoryComponent } from './pages/managecategory/editcategory.component';
import { EditsubcategoryComponent } from './pages/managesubcategory/editsubcategory.component';
import { EditserviceComponent } from './pages/manageservice/editservice.component';
import { ManageadvertisementComponent } from './pages/manageadvertisement/manageadvertisement.component';

import {AddadvertisementComponent} from './pages/manageadvertisement/addadvertisement.component';
import {EditadvertisementComponent} from './pages/manageadvertisement/editadvertisement.component';
import { LandingpageComponent } from './landingpage/landingpage.component';


import { ManagetemplateComponent } from './pages/managetemplates/managetemplate.component';
import { AddtemplateComponent } from './pages/managetemplates/addtemplate.component';
import { EdittemplateComponent } from './pages/managetemplates/edittemplate.component';
import { ChatgroupComponent } from './pages/chatgroup/chatgroup.component';
import { ManagegroupchannelComponent } from './pages/managegroupchannel/managegroupchannel.component';
import { ViewchatComponent } from './pages/managegroupchannel/viewchat.component';
import { ViewsubscribersComponent } from './pages/managegroupchannel/viewsubscribers.component';
import { ImageCropperModule } from 'ngx-image-cropper';
//import {ImageCropperComponent, CropperSettings} from 'ng2-img-cropper';

@NgModule({
  declarations: [
    AppComponent,
    TopnavComponent,
    SidemenuComponent,
    DashboardComponent,
    ChatComponent,
    LoginComponent,
    ManageuserComponent,
    AddserviceComponent,
    AddcontactComponent,
    SignupComponent,
    ManagepackagesComponent,
    ManagepaymentsComponent,
    ProfileComponent,
    AdduserComponent,
    AddpackageComponent,
    EditpackageComponent,
    AdmindashboardComponent,
    MarketmanagersComponent,
    AccountinfoComponent,
    ManagecategoryComponent,
    ManagesubcategoryComponent,
    ManageproductsComponent,
    AddcategoryComponent,
    AddsubcategoryComponent,
    AddproductComponent,
    ManageserviceComponent,
    ManagecontactsComponent,
    ManagetransferComponent,
    PackageinfoComponent,
    EdituserComponent,
    ForgotpasswordComponent,
    ManageearningsComponent,
    AddearningsComponent,
    EditearningsComponent,
    EditcategoryComponent,
    EditsubcategoryComponent,
    EditproductComponent,
    EditserviceComponent,
    ManageadvertisementComponent,
    AddadvertisementComponent,
    EditadvertisementComponent,
    EditcontactComponent,
    LandingpageComponent,
    ManagetemplateComponent,
    AddtemplateComponent,
    EdittemplateComponent,
    ChatgroupComponent,
    ManagegroupchannelComponent,
    ViewchatComponent,
    ViewsubscribersComponent,
    PublicchatComponent,
    MychatComponent,
	//ImageCropperComponent
  ],
  imports: [
    BrowserModule,                          
    AppRoutingModule,
    FormsModule,
    HttpClientModule,
    NgMultiSelectDropDownModule.forRoot(),
    HttpModule,
    ImageCropperModule
  ],
  providers: [LoginService,CommonService],
  bootstrap: [AppComponent]
})
export class AppModule { }
