import { Component, Injectable, OnInit} from '@angular/core';
import { Http, Headers, RequestOptions, Response } from '@angular/http';
import { Router } from '@angular/router';
import { AppSettings } from '../appSettings';
import { LoginService } from '../services/login.service';
import { CommonService} from '../services/common.service';
declare let swal: any;
declare var jquery:any;
declare var $ :any;

@Component({
  selector: 'app-signup',
  templateUrl: './signup.component.html',
  styleUrls: ['./signup.component.css']
})
export class SignupComponent implements OnInit {

  model: any = {};
  data:any={};
  entered:any;
  users :any= []; //storing the data from the API
  userRestApiUrl: string = AppSettings.Userlogin; //API common URL
  getpackagelistRestApiUrl:string = AppSettings.getPackageDetail; 
  checkUserRestApiUrl:string = AppSettings.checkuserdetail; 
  AddUserRestApiUrl:string = AppSettings.Adduser; 
  packagelist:Array<Object>;
  

 constructor(private loginService: LoginService,private CommonService: CommonService,private router: Router,private http:Http) {

    document.body.className="signup-page";

   }


  ngOnInit() {
     this.entered = 0;
     this.model.passwordmatch=false;
      this.CommonService.getdata(this.getpackagelistRestApiUrl)
        .subscribe(packagedet =>{
            if(packagedet.result!="")
            { 
              this.packagelist= packagedet.result;
            } 
        });
  }
   passwordMatch()
   {
     this.model.passwordmatch=false;
     if((this.model.password!='')&&(this.model.confirmp!=''))
     {
        console.log(this.model);
       if(this.model.password!=this.model.confirmp)
       {
         this.model.passwordmatch = true;

       }
     }
   }
  adduser()
  {
    delete this.model.passwordmatch;
    delete this.model.confirmp;
    this.CommonService.insertdata(this.AddUserRestApiUrl,this.model)
    .subscribe(user_det =>{       
         swal(
          user_det.status,
          "Registered Successfully",
          user_det.status
        )
        this.router.navigate(['/']); 
    });
  }
  checkUserexist(event:any)
  {
    //console.log(event.target.value);
    this.model.username=event.target.value;
    this.CommonService.checkexistdata(this.checkUserRestApiUrl,this.model)
    .subscribe(package_det =>{
      if(package_det.exist==1)
      {
        swal('',package_det.message,'error')
        this.model.username='';
      }  
    });
  }

}
