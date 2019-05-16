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
  api_bases=AppSettings.STYLE_BASE;
  Newgroupmodel: any = {}; 
  group_det:Array<Object>;
 
  constructor(private loginService: LoginService,private CommonService: CommonService,private router: Router,private http:Http) { 
      // document.body.className="theme-red";

  }

  ngOnInit() {
    
    
    this.loginService.localStorageData();
    this.loginService.viewsActivate();
    this.Newgroupmodel.currentUserID=localStorage.getItem('currentUserID');
    this.getgrouplists();
  }

  getgrouplists(){
    this.CommonService.getdata(AppSettings.getgroups)
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
