import { Component,OnInit } from '@angular/core';
import { Routes,Router,RouterModule}  from '@angular/router';
import { Http, Headers, RequestOptions, Response } from '@angular/http';
import { AppSettings } from '../appSettings';
import { LoginService } from '../services/login.service';
import { CommonService } from '../services/common.service';
import Swal from 'sweetalert2'

declare var jquery:any;
declare var $ :any;
import { Injectable } from '@angular/core';

@Component({
  selector: 'app-chat',
  templateUrl: './chat.component.html',
  styleUrls: ['./style.css']
})



export class ChatComponent implements OnInit {
  currentUser:any;
  currentUserID:any;
  api_bases:any;
  Newgroupmodel: any = {}; 
  group_dt_model:Array<Object>;
  group_name:any;
  group_members_model:Array<Object>;
  group_msg_model:Array<Object>;
  group_det:Array<Object>;
  userdropdownList : Array<Object>;
  userdropdownSettings = {};
 
  constructor(private loginService: LoginService,private CommonService: CommonService,private router: Router,private http:Http) { 
      // document.body.className="theme-red";

  }

  ngOnInit() {
    this.api_bases = AppSettings.IMAGE_BASE_CHAT;
    this.group_dt_model=[];
    this.group_name=0;
    this.group_msg_model=[];
    this.group_members_model=[];
    this.Newgroupmodel.userselectedItems={};
    this.loginService.localStorageData();
    this.loginService.viewsActivate();
    this.Newgroupmodel.currentUserID=localStorage.getItem('currentUserID');
    this.Newgroupmodel.currentUser=localStorage.getItem('currentUser');
    this.getgrouplists();

    // this.selectedItems = [
    //   { Id: 3, username: 'Pune' },
    //   { Id: 4, username: 'Navsari' }
    // ];
    this.userdropdownSettings = {
      singleSelection: false,
      idField: 'Id',
      textField: 'username',
      selectAllText: 'Select All',
      unSelectAllText: 'UnSelect All',
      itemsShowLimit: 3,
      allowSearchFilter: true
    };
  }

  getgrouplists(){
    this.CommonService.getdata(AppSettings.getuserslist)
    .subscribe(det =>{
      
        if(det.result!=""){ this.userdropdownList=det.result;}
    });

    // this.CommonService.getdata(AppSettings.getgroups)
    this.CommonService.insertdata(AppSettings.getgroups,this.Newgroupmodel)
    .subscribe(det =>{      
        if(det.result!=""){ this.group_det=det.result;}
    });
  }

  generateMessageArea(g_id){
    this.Newgroupmodel.g_id=g_id;
    this.CommonService.insertdata(AppSettings.getgroupsdetails,this.Newgroupmodel)
        .subscribe(resultdata =>{   
          this.group_name=1;
          // console.log(resultdata.group_details);
          this.group_dt_model = resultdata.group_details[0];
          this.group_msg_model = resultdata.group_msg;
          this.group_members_model=resultdata.group_members; 
          $('.message-area').addClass('d-sm-flex');
        });
  }

  addgroup()
  {
    this.CommonService.insertdata(AppSettings.addgroup,this.Newgroupmodel)
    .subscribe(package_det =>{       
      
        this.Newgroupmodel='';
        this.getgrouplists();
        swal('','Group Created Successfully','success');  
        
    });
  }
  sendMessage(){
    this.CommonService.insertdata(AppSettings.sendmsg,this.Newgroupmodel)
    .subscribe(package_det =>{       
      
        this.Newgroupmodel.groupmsgtxt='';
        this.generateMessageArea(this.Newgroupmodel.g_id);
        // swal('','Message sent Successfully','success');  
        
    });
  }

 
}
