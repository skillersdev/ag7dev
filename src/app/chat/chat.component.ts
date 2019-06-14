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
  userdropdownList:any;
  userdropdownSettings:any={};
  interval: any;
  group_bases:any;
 
  constructor(private loginService: LoginService,private CommonService: CommonService,private router: Router,private http:Http) { 
      // document.body.className="theme-red";

  }

  ngOnInit() {
    this.api_bases = AppSettings.IMAGE_BASE_CHAT;
    this.group_bases = AppSettings.IMAGE_BASE;
    
    this.group_dt_model=[];
    this.userdropdownList=[];
    this.group_name=0;
    this.group_msg_model=[];
    this.group_members_model=[];
    this.Newgroupmodel.userselectedItems=[]; 
    this.loginService.localStorageData();
    this.loginService.viewsActivate();
    this.Newgroupmodel.currentUserID=localStorage.getItem('currentUserID');
    this.Newgroupmodel.currentUser=localStorage.getItem('currentUser');
    this.Newgroupmodel.userselectedItems =[{'Id':this.Newgroupmodel.currentUserID,'username':this.Newgroupmodel.currentUser}];
    this.userdropdownSettings = {
      singleSelection: false,
      idField: 'Id',
      textField: 'username',
      selectAllText: 'Select All',
      unSelectAllText: 'UnSelect All',
      itemsShowLimit: 3,
      allowSearchFilter: true
    };
    this.getgrouplists();
    this.getuserlists();
    this.Newgroupmodel.g_id=''; 
    
    // this.interval = setInterval(() => { 
    //   this.getgrouplists();
    // }, 15000);

    // this.selectedItems = [
    //   { Id: 3, username: 'Pune' },
    //   { Id: 4, username: 'Navsari' }
    // ];
    
  }
  refreshData(){
    this.interval = setInterval(() => { 
      this.generateMessageArea(this.Newgroupmodel.g_id);
    }, 10000);
  }
  getuserlists(){
    this.CommonService.getdata(AppSettings.getchatuserslist)
    .subscribe(det =>{
      
        if(det.result!=""){ this.userdropdownList=det.result;}
        
    });
  }
  getgrouplists(){    

    // this.CommonService.getdata(AppSettings.getgroups)
    this.CommonService.insertdata(AppSettings.getgroups,this.Newgroupmodel)
    .subscribe(det =>{      
        if(det.result!=""){ this.group_det=det.result;}
    });
  }

  generateMessageArea(g_id){
    this.Newgroupmodel.g_id=g_id;
    this.refreshData();
    this.CommonService.insertdata(AppSettings.getgroupsdetails,this.Newgroupmodel)
        .subscribe(resultdata =>{   
          this.group_name=1;
          this.group_dt_model = resultdata.group_details[0];
          this.Newgroupmodel.groupname = resultdata.group_details[0].group_name;
          this.Newgroupmodel.privatepublic = resultdata.group_details[0].private_public;
          this.Newgroupmodel.groupimagename = resultdata.group_details[0].imagename;
          
          // console.log(this.group_dt_model);
          this.group_msg_model = resultdata.group_msg;
          this.Newgroupmodel.userselectedItems=resultdata.select_group_members;
          this.group_members_model=this.Newgroupmodel.userselectedItems=resultdata.group_members; 
          $('.message-area').addClass('d-sm-flex');
        });
  }
  
  updategroup()
  {
    this.CommonService.insertdata(AppSettings.updategroup,this.Newgroupmodel)
    .subscribe(package_det =>{     
      this.generateMessageArea(this.Newgroupmodel.g_id);
        this.getgrouplists();
        swal('','Group Updated Successfully','success');  
        
    });
  }

  addgroup()
  {
    this.CommonService.insertdata(AppSettings.addgroup,this.Newgroupmodel)
    .subscribe(package_det =>{       
      this.Newgroupmodel.groupname='';
      this.Newgroupmodel.groupimagename='';
      this.Newgroupmodel.privatepublic='';       
      
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
   
  fileEvent($event) {
    const fileSelected: File = $event.target.files[0];
    this.Newgroupmodel.groupimagename =$event.target.files[0].name;
    this.CommonService.chatuploadFile(AppSettings.groupimage,fileSelected)
    .subscribe( (response) => {
       if(response.status=='success')
       {
         
        // this.Newgroupmodel.groupimagename = response.data;
        
       }
       
     })
  }

  msgfileEvent($event) {
    const fileSelected: File = $event.target.files[0];
    this.CommonService.chatuploadFile(AppSettings.msggroupimage,fileSelected)
    .subscribe( (response) => {
       if(response.status=='success')
       {
        console.log(response);
        
        // this.Newgroupmodel.groupimagename = response.data;
       }
       
     })
  }
  logout(){
    this.loginService.logout();
  } 
}
