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
  styleUrls: []
})



export class ChatComponent implements OnInit {
  currentUser:any;
  currentUserID:any;
  // api_bases=AppSettings.STYLE_BASE;
  Newgroupmodel: any = {}; 
  group_det:Array<Object>;
  userdropdownList : Array<Object>;
  userdropdownSettings = {};
 
  constructor(private loginService: LoginService,private CommonService: CommonService,private router: Router,private http:Http) { 
      // document.body.className="theme-red";

  }

  ngOnInit() {
    
    this.Newgroupmodel.userselectedItems={};
    this.loginService.localStorageData();
    this.loginService.viewsActivate();
    this.Newgroupmodel.currentUserID=localStorage.getItem('currentUserID');
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

  addgroup()
  {
    this.CommonService.insertdata(AppSettings.addgroup,this.Newgroupmodel)
    .subscribe(package_det =>{       
      
        this.Newgroupmodel='';
        this.getgrouplists();
        swal('','Group Created Successfully','success');  
        
    });
  }
 

 
}
