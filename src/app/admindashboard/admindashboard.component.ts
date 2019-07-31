import { Component,OnInit } from '@angular/core';
import { Routes,Router,RouterModule}  from '@angular/router';
import { AppComponent } from '../app.component';
import { TopnavComponent } from '../topnav/topnav.component';
import { SidemenuComponent } from '../sidemenu/sidemenu.component';
import { Http, Headers, RequestOptions, Response } from '@angular/http';
import { AppSettings } from '../appSettings';
import { LoginService } from '../services/login.service';
import { CommonService} from '../services/common.service';
import Swal from 'sweetalert2'
declare var jquery:any;
declare var $ :any;
import { Injectable } from '@angular/core';
@Component({
  selector: 'app-admindashboard',
  templateUrl: './admindashboard.component.html',
  styleUrls: ['./admindashboard.component.css']
})
export class AdmindashboardComponent implements OnInit {
  currentUser:any;
  currentUserID:any;
  currentUsername:any;
  currentUsergroup:any;
  currentUserStatus:any;
  currentAllUsers:any;
  transferdata: any = {};
  userlist:Array<Object>;
  model: any = {};
  data: any = {};
  getuserlistRestApiUrl:string=AppSettings.getuserslist;
  checkUserRestApiUrl:string = AppSettings.checkuserdetail; 
 inserttrasnfeprocessRestApiUrl:string = AppSettings.inserttransferprocess;
  constructor(private loginService: LoginService,private CommonService: CommonService,private router: Router,private http:Http) { 
    document.body.className="theme-red";

}

ngOnInit() {
  this.loginService.localStorageData();
  this.loginService.viewsActivate();
  this.CommonService.getdata(this.getuserlistRestApiUrl)
    .subscribe(userdet =>{
        if(userdet.result!="")
        { 
          this.userlist= userdet.result;
          this.model.tot_users = Object.values(userdet.result).length;
          this.model.total_web_count=userdet.result['total_web_count'];
          this.model.total_active_web_count=userdet.result['total_active_web_count'];
          this.model.total_yet_to_active = userdet.result['total_yet_to_active'];
          console.log(this.model);
        } 
         
    });
    this.data.usertype = localStorage.getItem('currentUsergroup');
}

logout() {
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
          this.model.mname = '';
         this.model.share_amt = '';
        this.router.navigate(['/dashboard']); 
    });
  }
}
