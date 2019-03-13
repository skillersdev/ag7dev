import { Component,OnInit } from '@angular/core';
import { Routes,Router,RouterModule}  from '@angular/router';
import { AppComponent } from '../app.component';
import { TopnavComponent } from '../topnav/topnav.component';
import { SidemenuComponent } from '../sidemenu/sidemenu.component';
import { Http, Headers, RequestOptions, Response } from '@angular/http';
import { AppSettings } from '../appSettings';
import { LoginService } from '../services/login.service';
import { CommonService } from '../services/common.service';
declare var jquery:any;
declare var $ :any;
import { Injectable } from '@angular/core';

@Component({
  selector: 'app-dashboard',
  templateUrl: './dashboard.component.html',
  styleUrls: ['./dashboard.component.css']
})



export class DashboardComponent implements OnInit {
  currentUser:any;
  currentUserID:any;
  currentUsername:any;
  currentUsergroup:any;
  currentUserStatus:any;
  currentAllUsers:any;
  packagelist:Array<Object>;
  model: any = {};
  alldata: any = {};
  transferdata: any = {};
  getpackageinfodetApiUrl:string = AppSettings.getPackageInfo; 
  checkUserRestApiUrl:string = AppSettings.checkuserdetail; 
  checkpackageisactivated:string = AppSettings.packageisactivated; 
  checkUserCreditRestApiUrl:string = AppSettings.checkusercredit;
  inserttrasnfeprocessRestApiUrl:string = AppSettings.inserttransferprocess;
 
  constructor(private loginService: LoginService,private CommonService: CommonService,private router: Router,private http:Http) { 
      document.body.className="theme-red";

  }

  ngOnInit() {
    this.loginService.localStorageData();
    this.loginService.viewsActivate();
    let id=localStorage.getItem('currentUserID');
      this.CommonService.editdata(this.checkpackageisactivated,id).subscribe(data=>{
         if(data.exist==2)
          {
           
           this.router.navigate(['./packageinfo']); 
          }
      });
       let user_id = localStorage.getItem('currentUserID');
      this.CommonService.editdata(this.getpackageinfodetApiUrl,user_id)
          .subscribe(resultdata =>{   
            this.packagelist=resultdata.result; 
          });
    //  setTimeout(() => {
    //     this.router.navigate(['./packageinfo']);
    // }, 5000); 
  }

  logout(){
    this.loginService.logout();
  }

 checkmarketer(marketer_name:any)
 {
   this.model.username=marketer_name;
   this.CommonService.checkexistdata(this.checkUserRestApiUrl,this.model).subscribe(data=>{
      if(data.exist==0)
      {                
         swal('Oops...','Marketer doesnot exists', 'error');
         this.model.mname='';
      }       
    });
  }
  checkbalance()
  {
    this.alldata.user_id=localStorage.getItem('currentUserID');
    if((this.model.share_amt!='')&&(this.model.share_amt!=undefined))
      {
        this.alldata.share_amt=this.model.share_amt;
        this.CommonService.checkexistdata(this.checkUserCreditRestApiUrl,this.alldata).subscribe(data=>{
          if(data.total_amount<=50)
          {                
             swal('Oops...','Minimum Amount should be more than 50', 'error');
             this.model.share_amt='';
          }
          else{
            if(data.status==1)
            {
               swal('Oops...',data.message, 'error');
               this.model.share_amt=''; 
            }
          }
        });
      }
  }
  transferamount()
  {
    this.transferdata.transfer_to=this.model.username;
    this.transferdata.transfer_from=localStorage.getItem('currentUser');
    this.transferdata.amt=this.model.share_amt;
    this.CommonService.insertdata(this.inserttrasnfeprocessRestApiUrl,this.transferdata)
    .subscribe(package_det =>{       
         swal(
          package_det.status,
          package_det.message,
          package_det.status
        )
        this.router.navigate(['/dashboard']); 
    });
  }
   


}
