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
import { ManagegalleryComponent } from './pages/managegallery/managegallery.component';
import { AddgalleryComponent } from './pages/managegallery/addgallery.component';
import { EditgalleryComponent } from './pages/managegallery/editgallery.component';
import { AddalbumphotsComponent } from './pages/managegallery/addalbumphots.component';

import { ManagemallComponent } from './pages/mall/managemall/managemall.component';
import { AddmallComponent } from './pages/mall/managemall/addmall.component';
import { EditmallComponent } from './pages/mall/managemall/editmall.component';

import { ManagefloorComponent } from './pages/mall/managefloor/managefloor.component';
import { AddfloorComponent } from './pages/mall/managefloor/addfloor.component';
import { EditfloorComponent } from './pages/mall/managefloor/editfloor.component';

import { ManageshopComponent } from './pages/mall/manageshop/manageshop.component';
import { AddshopComponent } from './pages/mall/manageshop/addshop.component';
import { EditshopComponent } from './pages/mall/manageshop/editshop.component';
import { ManageshopordersComponent } from './pages/mall/manageshop/manageshoporders.component';
import { ManageshopCategoryComponent } from "./pages/mall/manageshop/manageshopcategory.component";

import { ManagemallproductComponent } from './pages/mall/managemallproduct/managemallproduct.component';
import { AddmallproductComponent } from './pages/mall/managemallproduct/addmallproduct.component';
import { EditmallproductComponent } from './pages/mall/managemallproduct/editmallproduct.component';
import { MallloginComponent } from './pages/mall/malllogin/malllogin.component';
import { ManagevideoComponent } from './pages/managevideos/managevideo.component';
import { AddvideoComponent } from './pages/managevideos/addvideo.component';
import { EditvideoComponent } from './pages/managevideos/editvideo.component';

import { MalldashboardComponent } from './malldashboard/malldashboard.component';
import { ManagesectionComponent } from './pages/managesection/managesection.component';
import { AddsectionComponent } from './pages/managesection/addsection/addsection.component';
import { EditsectionComponent } from './pages/managesection/editsection/editsection.component';
import { ReordersectionComponent } from './pages/managesection/reordersection/reordersection.component';
import { ManagesectionitemComponent } from './pages/managesectionitem/managesectionitem.component';
import { AddsectionitemComponent } from './pages/managesectionitem/addsectionitem/addsectionitem.component';
import { EditsectionitemComponent } from './pages/managesectionitem/editsectionitem/editsectionitem.component';
import { ManagechatgrouprequestComponent } from './managechatgrouprequest/managechatgrouprequest.component';
import { ManagechannelsComponent } from './managechannels/managechannels.component';
import { AddchannelComponent } from './managechannels/addchannel/addchannel.component';
import { EditchannelComponent } from './managechannels/editchannel/editchannel.component';
import { PremiumpackageComponent } from './pages/premiumpackage/premiumpackage.component';
import { AddpremiumpackageComponent } from './pages/premiumpackage/addpremiumpackage/addpremiumpackage.component';
import { EditpremiumpackageComponent } from './pages/premiumpackage/editpremiumpackage/editpremiumpackage.component';
import { PremiumrequestvideosComponent } from './premiumrequestvideos/premiumrequestvideos.component';
import { PremiumtransactionComponent } from './pages/premiumtransaction/premiumtransaction.component';
import { NearbyComponent } from './pages/nearby/nearby.component';
import { ManageenquiryComponent } from './pages/manageenquiry/manageenquiry.component';
import { ManageproductenquiryComponent } from './pages/manageproductenquiry/manageproductenquiry.component';
import { ReorderitemComponent } from './pages/managesectionitem/reorderitem/reorderitem.component';
import { ReorderalbumComponent } from './pages/managegallery/reorderalbum/reorderalbum.component';

import { WebsitesettingsComponent } from './pages/websitesettings/websitesettings.component';
import { WebsitesettingsreorderComponent } from './pages/websitesettingsreorder/websitesettingsreorder.component';
const routes: Routes = [
  {
	  path: '',
	  component: LandingpageComponent
  },
  {
    path: 'managegallery',
    component: ManagegalleryComponent
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
  }, {
	  path: 'malldashboard',
	  component: MalldashboardComponent
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
  {
     path:'addalbum',
    component:AddgalleryComponent
    
  },
   {
     path:'editalbum/:id',
    component:EditgalleryComponent
    
  },
   {
     path:'addalbumphotos/:id',
    component:AddalbumphotsComponent
    
  },
  {
    path:'mall/managemall',
   component:ManagemallComponent
   
 },
 {
  path:'mall/addmall',
 component:AddmallComponent
 
},{
  path:'mall/editmall/:id',
 component:EditmallComponent
 
},
{
  path:'mall/managefloor',
 component:ManagefloorComponent
 
},
{
path:'mall/addfloor',
component:AddfloorComponent
},{
path:'mall/editfloor/:id',
component:EditfloorComponent

},
{
  path:'mall/manageshop',
 component:ManageshopComponent
 
},
{
  path:'mall/manageshoporders/:id',
 component:ManageshopordersComponent
 
},
{
path:'mall/addshop',
component:AddshopComponent

},{
path:'mall/editshop/:id',
component:EditshopComponent

},
{
  path:'mall/manageshopcategory/:id',
  component:ManageshopCategoryComponent
},
{
  path:'mall/managemallproduct',
 component:ManagemallproductComponent
 
},
{
path:'mall/addmallproduct',
component:AddmallproductComponent

},{
path:'mall/editmallproduct/:id',
component:EditmallproductComponent

}
,{
  path:'mall/login',
  component:MallloginComponent
  
  },
  
  {
  path:'managevideos', 
  component:ManagevideoComponent
  
  },
  {
  path:'addvideos',
  component:AddvideoComponent  
  },
  {
  path:'editvideos/:id',
  component:EditvideoComponent  
  },
  {
  path:'managesection',
  component:ManagesectionComponent  
  },
   {
    path:'addsection',
    component:AddsectionComponent
  },
  {
    path:'editsection/:id',
    component:EditsectionComponent
  },
  {
    path:'reordersection',
    component:ReordersectionComponent
  },
  {
    path:'reordersectionitem',
    component:ReorderitemComponent
  },
  
   {
  path:'managesectionitem',
  component:ManagesectionitemComponent  
  },
  {
    path:'reorderalbumitem',
    component:ReorderalbumComponent  
    },
  
   {
    path:'addsectionitem',
    component:AddsectionitemComponent
  },
  {
    path:'editsectionitem/:id',
    component:EditsectionitemComponent
  },
  {
    path:'managegrouprequest',
    component:ManagechatgrouprequestComponent
  },
  {
    path:'managechannels',
    component:ManagechannelsComponent
  },
  {
    path:'addchannel',
    component:AddchannelComponent
  },
  {
    path:'editchannel/:id',
    component:EditchannelComponent
  },{
    path:'premiumsettings',
    component:PremiumpackageComponent
  },{
    path:'addpremium',
    component:AddpremiumpackageComponent
  }
  ,{
    path:'editpremium/:id',
    component:EditpremiumpackageComponent
  }
  ,{
    path:'premiumrequestvideos',
    component:PremiumrequestvideosComponent
  },{
    path:'premiumtransactiondetails',
    component:PremiumtransactionComponent
  },{
    path:'nearby',
    component:NearbyComponent
  },{
    path:'manageenquiry',
    component:ManageenquiryComponent
  },{
    path:'manageproductenquiry',
    component:ManageproductenquiryComponent
  },
  {
    path:'websitesettings',
    component:WebsitesettingsComponent
  },{
    path:'websitesettingsreorder',
    component:WebsitesettingsreorderComponent
  },
  

];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
