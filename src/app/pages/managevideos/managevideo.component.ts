import { Component, OnInit } from '@angular/core';
import { Routes,Router,RouterModule}  from '@angular/router';

import { AppComponent } from '../../app.component';

import { TopnavComponent } from '../../topnav/topnav.component';
import { SidemenuComponent } from '../../sidemenu/sidemenu.component';
import { Http, Headers, RequestOptions, Response } from '@angular/http';
import { AppSettings } from '../../appSettings';
import { LoginService } from '../../services/login.service';
import { CommonService} from '../../services/common.service';
import Swal from 'sweetalert2'
declare var jquery:any;
declare var $ :any;
import { Injectable } from '@angular/core';

@Component({
  selector: 'app-manageuser',
  templateUrl: './managevideo.component.html',
  //styleUrls: ['./manageuser.component.css']
})
export class ManagevideoComponent implements OnInit {
 websiteurl:string=AppSettings.API_BASE;
  currentUser:any;
  currentUserID:any;
  currentUsername:any;
  currentUsergroup:any;
  currentUserStatus:any;
  currentAllUsers:any;
  model: any = {};
  premiumModal:any={};
  alldata: any = {};
  videolist:Array<Object>;
  premiumdays:Array<Object>;
  datalist:Array<Object>;
  getuserlistRestApiUrl:string=AppSettings.getuserslist;
  DeleteuserRestApiUrl:string = AppSettings.deleteuser; 
  constructor(
    private loginService: LoginService,
    private CommonService:CommonService,
    private router: Router,
    private http:Http) { 
      document.body.className="theme-red";

  }

  ngOnInit() {
      this.loginService.localStorageData();
    this.loginService.viewsActivate();
    this.premiumdays=[];
    this.videolist=[];
    this.model.showpremiumamount =false;
    this.premiumModal.IsshowPremiumButton =true;
    this.premiumModal.premdays='select';
    let user_id = localStorage.getItem('currentUserID');
    
     this.model.usergroup=localStorage.getItem('currentUsergroup');
        if(this.model.usergroup==2)
        {
          this.model.userid = localStorage.getItem('currentUserID');
          this.CommonService.insertdata(AppSettings.getvideolistbywebsiteApiUrl,this.model)
            .subscribe(resultdata =>{   
             if(resultdata.result!='')
             { 
               this.videolist=resultdata.result;
               
               // this.categoryDet=resultdata.category_name;
               this.loginService.viewCommontdataTable('videosdataTable','videosdataTable');
            }
          });
        }

        this.CommonService.insertdata(AppSettings.getpremiumpackagesettings,this.model)
        .subscribe(data =>{
          if(data.status="success")  
          { 
            this.premiumdays= data.result;
          }       
        });
       
  }
  
  logout(){
    this.loginService.logout();
  }

  navigateAddvideo()
  {
    this.router.navigate(['/addvideos']);
  }
  editvideo(id:any)
  {
    console.log(id);
    this.router.navigate(['/editvideos', id]);
  }
  deletevideo(id:any)
 {
   let idx = id;
      let self = this;
      swal({
        title: 'Are you sure?',
         buttons: {
            cancel: true,
            confirm: true,
          },
        text: "You won't be able to revert this!",
      }).then(function (result) {
        if(result)
        {
          self.removeuser(idx);
          swal(
            'Deleted!',
            'User Data has been deleted.',
            'success'
          );
        }
      },function(dismiss) {
  // dismiss can be "cancel" | "close" | "outside"
});
 }
 removeuser(idx:any)
 {
   this.CommonService.deletedata(AppSettings.Deletevideosection,idx)
        .subscribe(resultdata =>{
          this.ngOnInit();
      });
 }
 showAmount(amount:any)
 { 
    if(amount)
    {
      this.premiumModal.showpremiumamount =true;
      this.premiumModal.premiumamount = amount;
      this.premiumModal.selectedPremiumdays = $("#pdays option:selected").text();
    }
 }
 checkUserexist(username:any)
 {
  $('.preloader').show();
  this.CommonService.insertdata(AppSettings.checkpremiumuserandbalanceexist,this.premiumModal)
  .subscribe(data =>{
    if(data.status=="success")  
    { 
      this.premiumModal.IsshowPremiumButton = false;
      $('.preloader').hide();
    }else{   
      swal('',data.message,'error');
      this.premiumModal.IsshowPremiumButton = false;
    }       
  });
 }
 getVideodet(videoId:any)
 {
  this.premiumModal.videoId = videoId;
 }
 savepremiumpck()
 {
  this.premiumModal.current_userid = localStorage.getItem('currentUserID');
    this.CommonService.insertdata(AppSettings.savepremiumdata,this.premiumModal)
    .subscribe(data =>{
      if(data.status=="success")  
      {         
        $('.preloader').hide();
        swal('',data.message,'success');
        $('#premiummodal').modal('hide');
        this.CommonService.insertdata(AppSettings.getvideolistbywebsiteApiUrl,this.model)
            .subscribe(resultdata =>{   
             if(resultdata.result!='')
             { 
               this.videolist=resultdata.result;
               this.loginService.viewCommontdataTable('videosdataTable','videosdataTable');
            }
          });
      } else{
        swal('','Errow while on upgrading premium','error');
      }      
    });
 }
}
