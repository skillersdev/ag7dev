import { Component, OnInit } from '@angular/core';
import { Routes,Router,RouterModule}  from '@angular/router';
import { CommonService } from '../../services/common.service';
import { AppSettings } from '../../appSettings';

import { LoginService } from '../../services/login.service';

@Component({
  selector: 'app-manageproductenquiry',
  templateUrl: './manageproductenquiry.component.html',
  styleUrls: ['./manageproductenquiry.component.css']
})
export class ManageproductenquiryComponent implements OnInit {

 
  getproductenquirylistRestApiUrl:string = AppSettings.getproductenquirylist; 
  getproductenquirybyUserRestApiUrl:string = AppSettings.enquiryproductbyid; 
  enquirylist:Array<Object>;
  model:any={};
  constructor(private loginService: LoginService,private CommonService: CommonService,private router: Router) { }

  ngOnInit() {
    this.loginService.localStorageData();
    this.loginService.viewsActivate();

    let user_id = localStorage.getItem('currentUserID');
     this.model.imagePath = AppSettings.API_BASE;
    this.model.usergroup=localStorage.getItem('currentUsergroup');
    if(this.model.usergroup==2)
    {

      this.CommonService.editdata(this.getproductenquirybyUserRestApiUrl,user_id)
        .subscribe(resultdata =>{   
          this.enquirylist=resultdata.result; 
          this.loginService.viewCommontdataTable('category_table','category_table');
        });
    
      }
      else{
        this.CommonService.getdata(this.getproductenquirylistRestApiUrl)
        .subscribe(det =>{
            if(det.result!="")
            { 
              this.enquirylist=det.result;
              this.loginService.viewCommontdataTable('category_table','category_table');
            } 
             
        });
      }      
  }



}
