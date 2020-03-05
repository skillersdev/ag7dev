import { Component,OnInit } from '@angular/core';
import { Routes,Router,RouterModule}  from '@angular/router';

import { NgNavigatorShareService } from 'ng-navigator-share';


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
  date_array_model:Array<Object>;
  group_profile_log_model:Array<Object>;
  group_det:Array<Object>;
  userdropdownList:any;
  userdropdownSettings:any={};
  interval: any;
  group_bases:any;
  slideIndex:any;
  grouplink:any;


 private ngNavigatorShareService: NgNavigatorShareService;

  constructor(private loginService: LoginService,private CommonService: CommonService,private router: Router,private http:Http,ngNavigatorShareService: NgNavigatorShareService) { 
      // document.body.className="theme-red";
      this.ngNavigatorShareService = ngNavigatorShareService;

  }

  ngOnInit() {
    this.api_bases = AppSettings.IMAGE_BASE_CHAT;
    this.group_bases = AppSettings.IMAGE_BASE;
    this.slideIndex = 1; 
    this.Newgroupmodel.channelgroup=2;
    this.Newgroupmodel.privatepublic=2;
    this.Newgroupmodel.showinwebsite=0;
    this.showSlides(this.slideIndex);
    this.group_dt_model=[];
    this.userdropdownList=[];
    this.Newgroupmodel.groupimagename = '';
    this.Newgroupmodel.search_group_name = '';
   
    this.group_name=0;
    this.group_msg_model=[];
    this.date_array_model=[];
    this.group_members_model=[];
    // this.Newgroupmodel.groupcode='';

    this.Newgroupmodel.userselectedItems=[]; 
    this.Newgroupmodel.groupmemlists=[]; 
    
    this.loginService.localStorageData();
    this.loginService.viewsActivate();
    this.loginService.viewsUploadoption();
    this.Newgroupmodel.currentUserID=localStorage.getItem('currentUserID');
    this.Newgroupmodel.currentUser=localStorage.getItem('currentUser');
    this.Newgroupmodel.userselectedItems=[{'Id':this.Newgroupmodel.currentUserID,'username':this.Newgroupmodel.currentUser}];
    this.userdropdownSettings = {
      singleSelection: false,
      idField: 'Id',
      textField: 'username',
      selectAllText: 'Select All',
      unSelectAllText: 'UnSelect All',
      itemsShowLimit: 3,
      allowSearchFilter: true
    };

    //this.getparamas = this.route.params.subscribe(params => {
     //this.Newgroupmodel.groupcode = params['id']; // (+) converts string 'id' to a number
    //}); 
    
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

  share() {
  this.grouplink = AppSettings.chatshare+this.Newgroupmodel.groupcode;
  
    this.ngNavigatorShareService.share({
      title: 'My Awesome app',
      text: 'Click to Join this group',
      url: this.grouplink
    }).then( (response) => {
      console.log(response);
    })
    .catch( (error) => {
      console.log(error);
    });
  }
  

  ngOnDestroy() {
  if (this.interval) {
    clearInterval(this.interval);
  }
}

  refreshData(){
  if(this.router.url!="/chat"){

  this.Newgroupmodel.g_id='';
    clearInterval(this.interval);
  }
  else if(this.Newgroupmodel.g_id!='' && this.router.url=="/chat"){
   this.interval = setInterval(() => {

   if(this.router.url!="/chat" || this.Newgroupmodel.g_id==''){
    
    this.Newgroupmodel.g_id='';
      clearInterval(this.interval);
    } else {
      this.generateMessageArea(this.Newgroupmodel.g_id);
    }
   
     // this.generateMessageArea(this.Newgroupmodel.g_id);
    }, 20000);
  }  else {
    clearInterval(this.interval);
  }
    
  }
  getuserlists(){
    this.CommonService.insertdata(AppSettings.getchatuserslist,{'currentUsername':this.Newgroupmodel.currentUser})
    // this.CommonService.getdata(AppSettings.getchatuserslist)
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

  generateMessageArea1(id,p_p,g_code){
    if(p_p==4){
    //alert(g_code);
      this.router.navigate(['./chat/public/',g_code]); 
    }else {
      this.generateMessageArea(id);
    }
  }
  groupsearch(){
     this.CommonService.insertdata(AppSettings.getgroups,this.Newgroupmodel)
    .subscribe(det =>{      
        if(det.result!=""){ this.group_det=det.result;}
    });
  }

  hideshow(){
  this.Newgroupmodel.g_id = '';
  $('.mainmenu_navbar').removeClass('dhana');
     $('.chat-list').removeClass('d-none');
    $('.message-area').removeClass('d-flex');
    $('.chat-list').addClass('d-flex');
    $('.message-area').addClass('d-none');
    
  } 
  generateMessageArea(g_id){
  
  if($(window).width() > 450){
  
    $('.mainmenu_navbar').removeClass('dhana');
  $('.chat-list').removeClass('d-none');
    $('.message-area').removeClass('d-flex');
    $('.chat-list').addClass('d-flex');
    $('.message-area').addClass('d-none');
  } else {
  
    $('.mainmenu_navbar').addClass('dhana');
    $('.chat-list').removeClass('d-flex');
    $('.message-area').removeClass('d-none');
    $('.chat-list').addClass('d-none');
    $('.message-area').addClass('d-flex');
  }

   
    this.Newgroupmodel.g_id=g_id;
    this.refreshData();
    this.CommonService.insertdata(AppSettings.getgroupsdetails,this.Newgroupmodel)
        .subscribe(resultdata =>{   
          this.group_name=1;
          if(resultdata.check_user==0){
            this.router.navigate(['./chat/join/',resultdata.group_details[0].group_code]); 
          } else{
            this.group_dt_model = resultdata.group_details[0];
          
            this.Newgroupmodel.groupname = resultdata.group_details[0].group_name;
            this.Newgroupmodel.groupcode = resultdata.group_details[0].group_code;
            this.Newgroupmodel.privatepublic = resultdata.group_details[0].private_public;
            this.Newgroupmodel.groupimagename = resultdata.group_details[0].imagename;
            this.Newgroupmodel.created_by = resultdata.group_details[0].created_by;
            
            this.group_msg_model = resultdata.group_msg;
            // console.log(this.group_msg_model); 
            this.date_array_model = resultdata.date_array;
            this.Newgroupmodel.userselectedItems=resultdata.select_group_members;
            this.Newgroupmodel.groupmemlists=resultdata.select_group_members;
            this.group_members_model=resultdata.group_members;
            this.group_profile_log_model=resultdata.group_profile_details; 
            this.Newgroupmodel.admin_normal=resultdata.admin_normal;
            this.Newgroupmodel.showinwebsite=resultdata.group_details[0].showinwebsite;
            
            
            $('.message-area').addClass('d-sm-flex');
          }
          
        });
  }
  msgdeletefun(id:any){
    this.CommonService.insertdata(AppSettings.chatmsgdelete,{'id':id})
    .subscribe(package_det =>{     
     
        this.CommonService.insertdata(AppSettings.getgroupsdetails,this.Newgroupmodel)
        .subscribe(resultdata =>{   
          this.group_name=1;
          if(resultdata.check_user==0){
            this.router.navigate(['./chat/join/',resultdata.group_details[0].group_code]); 
          } else{
            this.group_dt_model = resultdata.group_details[0];
          
            this.Newgroupmodel.groupname = resultdata.group_details[0].group_name;
            this.Newgroupmodel.groupcode = resultdata.group_details[0].group_code;
            this.Newgroupmodel.privatepublic = resultdata.group_details[0].private_public;
            this.Newgroupmodel.groupimagename = resultdata.group_details[0].imagename;
            this.Newgroupmodel.created_by = resultdata.group_details[0].created_by;
            
            this.group_msg_model = resultdata.group_msg;
            // console.log(this.group_msg_model); 
            this.date_array_model = resultdata.date_array;
            this.Newgroupmodel.userselectedItems=resultdata.select_group_members;
            this.Newgroupmodel.groupmemlists=resultdata.select_group_members;
            this.group_members_model=resultdata.group_members;
            this.group_profile_log_model=resultdata.group_profile_details; 
            this.Newgroupmodel.admin_normal=resultdata.admin_normal;
            this.Newgroupmodel.showinwebsite=resultdata.group_details[0].showinwebsite;
            
            $('.message-area').addClass('d-sm-flex');
          }
          
        });

    });
  }

  msgeditfun(id:any){
    this.CommonService.insertdata(AppSettings.chatmsgedit,{'id':id})
    .subscribe(response =>{    
      this.Newgroupmodel.msgid=response.msg[0].id;
      this.Newgroupmodel.msgupdate=response.msg[0].message;
    });
  }
  msgupdatefun(){

    this.CommonService.insertdata(AppSettings.chatmsgupdate,{'id':this.Newgroupmodel.msgid,'msgupdate':this.Newgroupmodel.msgupdate})
    .subscribe(package_det =>{     
     
        this.CommonService.insertdata(AppSettings.getgroupsdetails,this.Newgroupmodel)
        .subscribe(resultdata =>{   
          this.group_name=1;
          if(resultdata.check_user==0){
            this.router.navigate(['./chat/join/',resultdata.group_details[0].group_code]); 
          } else{
            this.group_dt_model = resultdata.group_details[0];
          
            this.Newgroupmodel.groupname = resultdata.group_details[0].group_name;
            this.Newgroupmodel.groupcode = resultdata.group_details[0].group_code;
            this.Newgroupmodel.privatepublic = resultdata.group_details[0].private_public;
            this.Newgroupmodel.groupimagename = resultdata.group_details[0].imagename;
            this.Newgroupmodel.created_by = resultdata.group_details[0].created_by;
            
            this.group_msg_model = resultdata.group_msg;
            // console.log(this.group_msg_model); 
            this.date_array_model = resultdata.date_array;
            this.Newgroupmodel.userselectedItems=resultdata.select_group_members;
            this.Newgroupmodel.groupmemlists=resultdata.select_group_members;
            this.group_members_model=resultdata.group_members;
            this.group_profile_log_model=resultdata.group_profile_details; 
            this.Newgroupmodel.admin_normal=resultdata.admin_normal;
            this.Newgroupmodel.showinwebsite=resultdata.group_details[0].showinwebsite;
            
            $('.message-area').addClass('d-sm-flex');
          }
          
        });

    });

  }
  updategroup()
  {
    this.Newgroupmodel.userselectedItems.push({'Id':this.Newgroupmodel.currentUserID,'username':this.Newgroupmodel.currentUser});
    this.CommonService.insertdata(AppSettings.updategroup,this.Newgroupmodel)
    .subscribe(package_det =>{     
      this.generateMessageArea(this.Newgroupmodel.g_id);
        this.getgrouplists();
        swal('','Group Updated Successfully','success');  
        
    });
  }

  
  deletegroup()
  {
    this.CommonService.insertdata(AppSettings.deletegroup,this.Newgroupmodel)
    .subscribe(package_det =>{    
    this.group_name=0;
    this.Newgroupmodel.g_id=''; 
    this.getgrouplists();
    this.ngOnInit();
      // this.router.navigate(['./chat']); 
        swal('','Group Deleted Successfully','success');  
        
    });
  }

  exitgroup()
  {
    this.CommonService.insertdata(AppSettings.exitgroup,this.Newgroupmodel)
    .subscribe(package_det =>{    
    this.group_name=0;
    this.Newgroupmodel.g_id=''; 
    this.getgrouplists();
    this.ngOnInit();
      this.router.navigate(['./chat']); 
        swal('','Exit Group Successfully','success');  
        
    });
  }

  addgroup()
  {
  this.Newgroupmodel.g_id='';
  this.Newgroupmodel.userselectedItems.push({'Id':this.Newgroupmodel.currentUserID,'username':this.Newgroupmodel.currentUser});
    this.CommonService.insertdata(AppSettings.addgroup,this.Newgroupmodel)
    .subscribe(package_det =>{       
      this.Newgroupmodel.groupname='';
      this.Newgroupmodel.groupimagename='';
      this.Newgroupmodel.privatepublic=2;       
      
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
  plusSlides(n,m){
  this.showSlides(this.slideIndex += n);
  }

  currentSlide(n) {
  this.showSlides(this.slideIndex = n);
}

  showSlides(n) {
    var i;
    var slides = document.getElementsByClassName("mySlides");
    var dots = document.getElementsByClassName("dot");
    if (n > slides.length) {this.slideIndex = 1}    
    if (n < 1) {this.slideIndex = slides.length}
    for (i = 0; i < slides.length; i++) {
       // slides[i].style.display = "none";  
        $('.pimage'+i).css('display','none'); 
    }
    for (i = 0; i < dots.length; i++) {
       // dots[i].className = dots[i].className.replace(" active", "");
    }
    //slides[this.slideIndex-1].style.display = "block"; 
    var all_val = this.slideIndex-1; 
    $('.pimage'+all_val).css('display','block');
    //dots[this.slideIndex-1].className += " active";
  }

  msgfileEvent($event) {
    const fileSelected: File = $event.target.files[0];

    this.CommonService.chatuploadFile(AppSettings.msggroupimage,fileSelected)
    .subscribe( (response) => {
       if(response.status=='success')
       {
        // console.log(response);
        
         this.Newgroupmodel.groupimagename = response.data;
          this.Newgroupmodel.groupmsgtxt='';
          this.sendMessage(); 
       }
       
     })
  }
  logout(){
    this.loginService.logout();
  } 
  chatimageclick(){
    $('#chatimage').click();
  }
  admintoadd(id:any,group_id:any){
    this.CommonService.insertdata(AppSettings.makegroupadmin,{'id':id,'group_id':group_id,'val':1})
    .subscribe(package_det =>{     
      this.Newgroupmodel.groupmemlists= package_det.groupmemlists;
        
    });
  }
  admintoremove(id:any,group_id:any){
    this.CommonService.insertdata(AppSettings.makegroupadmin,{'id':id,'group_id':group_id,'val':0})
    .subscribe(package_det =>{     
      this.Newgroupmodel.groupmemlists= package_det.groupmemlists;
        
    });
  }
}
