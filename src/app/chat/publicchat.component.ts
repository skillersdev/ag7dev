import { Component,OnInit } from '@angular/core';
import { Routes,Router,RouterModule,ActivatedRoute}  from '@angular/router';

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
  selector: 'app-publicchat',
  templateUrl: './publicchat.component.html',
  styleUrls: ['./style.css']
})

export class PublicchatComponent implements OnInit {
  currentUser:any;
  currentUserID:any;
  api_bases:any;
  getparamas:any;
  Newgroupmodel: any = {}; 
  group_dt_model:Array<Object>;
  group_name:any;
  group_members_model:Array<Object>;
  group_msg_model:Array<Object>;
  date_array_model:Array<Object>;
  group_profile_log_model:Array<Object>;
  group_det:Array<Object>;
  marketerdropdownlist:Array<Object>;
  userdropdownList:any;
  sharedropdownSettings:any={};
  userdropdownSettings:any={};
  interval: any;
  group_bases:any;
  slideIndex:any;
  grouplink:any;
  sendreqestmodel:any={};
  windowHeight:any;
  imageuploadmsg:any;

 private ngNavigatorShareService: NgNavigatorShareService;

  constructor(private loginService: LoginService,private route:ActivatedRoute,private CommonService: CommonService,private router: Router,private http:Http,ngNavigatorShareService: NgNavigatorShareService) { 
      // document.body.className="theme-red";
      this.ngNavigatorShareService = ngNavigatorShareService;

  }

  ngOnInit() {
    this.api_bases = AppSettings.IMAGE_BASE_CHAT;
    this.group_bases = AppSettings.IMAGE_BASE;
    this.slideIndex = 1; 
    
    this.showSlides(this.slideIndex);
    this.group_dt_model=[];
    this.userdropdownList=[];
    this.Newgroupmodel.groupimagename = '';
    this.Newgroupmodel.search_group_name = '';
    this.Newgroupmodel.groupcode='';
    this.group_name=1;
    this.group_msg_model=[];
    this.date_array_model=[];
    this.group_members_model=[];
    this.Newgroupmodel.userselectedItems=[]; 
    this.Newgroupmodel.groupmemlists=[]; 
    this.sendreqestmodel.Isloading=false;
    //this.loginService.localStorageData();
    this.loginService.viewsActivate();
    this.loginService.viewsUploadoption();
    this.loginService.loadmsgscreenadjustable();
    this.Newgroupmodel.currentUserID=localStorage.getItem('currentUserID');
    this.Newgroupmodel.currentUser=localStorage.getItem('currentUser');
    this.imageuploadmsg=0;
    
    //code added for auto height
    var rehigh=107;
     this.windowHeight = ($(window).innerHeight()-rehigh);
     
        $('#messages').css('height', this.windowHeight);
        $("#messages").stop().animate({ scrollTop: $("#messages")[0].scrollHeight}, 1000);
    //code ends here

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
    this.sharedropdownSettings={
       singleSelection: false,
      idField: 'Id',
      textField: 'username',
      enableCheckAll:false,
      selectAllText: 'Select All',
      unSelectAllText: 'UnSelect All',
      itemsShowLimit: 3,
      allowSearchFilter: true
    }
    this.getparamas = this.route.params.subscribe(params => {
       this.Newgroupmodel.groupcode = params['code']; // (+) converts string 'id' to a number
    }); 
    //console.log(this.Newgroupmodel.groupcode);
    //this.getgrouplists();
    this.getuserlists();
    this.getmarketerslist();
    this.Newgroupmodel.g_id=1; 
    
    this.Codetogroup();
    this.refreshData();
    this.getwebsitelist();
   
  }
  copyMessage(val: string){
    const selBox = document.createElement('textarea');
    selBox.style.position = 'fixed';
    selBox.style.left = '0';
    selBox.style.top = '0';
    selBox.style.opacity = '0';
    selBox.value = val;
    document.body.appendChild(selBox);
    selBox.focus();
    selBox.select();
    document.execCommand('copy');
    document.body.removeChild(selBox);
  }

  share() {
  this.grouplink = AppSettings.share_link+this.Newgroupmodel.groupcode;
  
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
    
  Codetogroup(){
    console.log(this.Newgroupmodel,'this.Newgroupmodel');
    this.CommonService.insertdata(AppSettings.codetogroup,this.Newgroupmodel)
    .subscribe(package_det =>{  
    
    if(package_det){
      this.Newgroupmodel.g_id = package_det.group_details[0].id;
        
         this.Newgroupmodel.groupname = package_det.group_details[0].group_name;
         this.Newgroupmodel.channelgroup = package_det.group_details[0].channelgroup;
         
            this.Newgroupmodel.groupcode = package_det.group_details[0].group_code;
            this.Newgroupmodel.privatepublic = package_det.group_details[0].private_public;
            this.Newgroupmodel.groupimagename = package_det.group_details[0].imagename;
            this.Newgroupmodel.created_by = package_det.group_details[0].created_by;

        this.generateMessageArea(package_det.group_details[0].id);
    }   
        console.log(package_det.group_details[0].id);
    });
  }

  ngOnDestroy() {
  if (this.interval) {
    clearInterval(this.interval);
  }
}

  refreshData(){
  if(this.Newgroupmodel.g_id!=''){
   this.interval = setInterval(() => {

    this.generateMessageArea(this.Newgroupmodel.g_id);
   
     
    }, 35000);
  }  else {
    clearInterval(this.interval);
  }
    
  }
  getuserlists(){
    // this.CommonService.getdata(AppSettings.getchatuserslist)
    this.CommonService.insertdata(AppSettings.getchatuserslist,{'currentUsername':this.Newgroupmodel.currentUser})
    .subscribe(det =>{
      
        if(det.result!=""){ this.userdropdownList=det.result;}
        
    });
  }
   getmarketerslist()
  {
    this.CommonService.insertdata(AppSettings.getallmarketers,{'currentUsername':this.Newgroupmodel.currentUser})
    // this.CommonService.getdata(AppSettings.getchatuserslist)
    .subscribe(det =>{
      
        if(det!=""){ this.marketerdropdownlist=det;}
        
    });
    
  }
  groupdetails(){
   
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
  usertoremove(id:any,group_id:any){
    this.CommonService.insertdata(AppSettings.groupuseraddreove,{'id':id,'group_id':group_id,'val':1})
    .subscribe(package_det =>{     
      this.Newgroupmodel.groupmemlists= package_det.groupmemlists;
        
    });
  }
  usertoadd(id:any,group_id:any){
    this.CommonService.insertdata(AppSettings.groupuseraddreove,{'id':id,'group_id':group_id,'val':0})
    .subscribe(package_det =>{     
      this.Newgroupmodel.groupmemlists= package_det.groupmemlists;
        
    });
  }

  
  hideshow(){
  this.router.navigate(['./chat']); 
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
    // this.refreshData();
    this.CommonService.insertdata(AppSettings.getgroupsdetailspublic,this.Newgroupmodel)
        .subscribe(resultdata =>{   
          this.group_name=1;
         // if(resultdata.check_user==0){
            //this.router.navigate(['./chat/join/',resultdata.group_details[0].group_code]); 
          //} else{
            //this.group_dt_model = resultdata.group_details[0];
          
            this.sendreqestmodel.groupId=resultdata.group_details[0].id;
            this.group_msg_model = resultdata.group_msg;
            this.date_array_model = resultdata.date_array;
            this.grouplink = AppSettings.share_link+this.Newgroupmodel.groupcode;
            this.Newgroupmodel.userselectedItems=resultdata.select_group_members;
            this.group_members_model=resultdata.group_members;
            this.Newgroupmodel.admin_normal=resultdata.admin_normal;
            this.group_profile_log_model=resultdata.group_profile_details; 
            this.Newgroupmodel.groupmemlists=resultdata.select_group_members;
            
            $('.message-area').addClass('d-sm-flex');
            $("#messages").stop().animate({ scrollTop: $("#messages")[0].scrollHeight}, 1000);
         // }
          
        });
  }
  
  updategroup()
  {
    this.CommonService.insertdata(AppSettings.updategroup,this.Newgroupmodel)
    .subscribe(package_det =>{     
      this.generateMessageArea(this.Newgroupmodel.g_id);
        //this.getgrouplists();
        // swal('','Group Updated Successfully','success');  
        if(this.Newgroupmodel.channelgroup==2 || this.Newgroupmodel.channelgroup=="2"){
          swal('','Group Created Successfully','success');
        }else if(this.Newgroupmodel.channelgroup==1 || this.Newgroupmodel.channelgroup=="1"){
          swal('','Channel Created Successfully','success');
        }
           
        //this.router.navigate(['./chat']); 
        
    });
  }

  deletegroup()
  {
    this.CommonService.insertdata(AppSettings.deletegroup,this.Newgroupmodel)
    .subscribe(package_det =>{    
    this.group_name=0;
      
    //this.getgrouplists();
    //this.ngOnInit();
    swal('','Group Deleted Successfully','success');  
     this.router.navigate(['./chat']); 
        
        
    });
  }

  exitgroup()
  {
    this.CommonService.insertdata(AppSettings.exitgroup,this.Newgroupmodel)
    .subscribe(package_det =>{    
    this.group_name=0;
      
    //this.getgrouplists();
    //this.ngOnInit();
     swal('','Exit Group Successfully','success');  
    this.router.navigate(['./chat']); 
       
        
    });
  }

  sendMessage(){
  if(this.Newgroupmodel.currentUser==null){
  this.Newgroupmodel.currentUserID=0;
      Swal.fire({
        title: 'Enter your name',
        type: 'info',
        html:
          '<input type="text" name="currentUser" type="text" id="currentUser" placeholder="Enter your name" class="flex-grow-1 border-0 px-3 py-2 my-3 rounded shadow-sm currentUser"><button type="button"  class="btn btn-success" (click)="setname()" >Save</button>',
          showCancelButton: false, 
          showConfirmButton: false
      })
  } else {
    // this.CommonService.insertdata(AppSettings.sendmsg,this.Newgroupmodel)
    // .subscribe(package_det =>{       
      
    //     this.Newgroupmodel.groupmsgtxt='';
    //     this.generateMessageArea(this.Newgroupmodel.g_id);
    //     // swal('','Message sent Successfully','success');  
        
    // });
    
    if(this.Newgroupmodel.groupmsgtxt!='' && this.Newgroupmodel.groupmsgtxt!=undefined || this.imageuploadmsg==1){
      this.CommonService.insertdata(AppSettings.sendmsg,this.Newgroupmodel)
      .subscribe(package_det =>{       
        
          this.Newgroupmodel.groupmsgtxt='';
          this.imageuploadmsg=0;
          this.generateMessageArea(this.Newgroupmodel.g_id);
          // swal('','Message sent Successfully','success');  
          
      }); 
    }
    else {
      swal('','message is required','error');  
    }

  }
    
  }
  setname(){
  
      this.Newgroupmodel.currentUser=$('.currentUser').val();
      localStorage.setItem('currentUser', this.Newgroupmodel.currentUser);
      localStorage.setItem('currentUserID', '0');
      
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
    $('.loader').css('display','block');
    const fileSelected: File = $event.target.files[0];

    this.CommonService.chatuploadFile(AppSettings.msggroupimage,fileSelected)
    .subscribe( (response) => {
       if(response.status=='success')
       {
        $('.loader').css('display','none');
        // console.log(response);
        
         this.Newgroupmodel.groupimagename = response.data;
         this.imageuploadmsg=1;
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
    /*Request send code by mani*/
  sendrequest()
  {
    this.sendreqestmodel.requeststatus=1;
    //this.Newgroupmodel.userselectedItems.push({'Id':this.Newgroupmodel.currentUserID,'username':this.Newgroupmodel.currentUser});
    this.CommonService.insertdata(AppSettings.sendrequestforgroup,this.sendreqestmodel)
    .subscribe(package_det =>{     
      // this.generateMessageArea(this.Newgroupmodel.g_id);
      //   this.getgrouplists();
        swal('','Request sent successfully','success');  
        
    });
  }
  findmarketer()
  {
    
     this.CommonService.insertdata(AppSettings.findmarketers,this.sendreqestmodel)
    .subscribe(det =>{      
        if(det.status=='error')
        {
          this.group_det=[];

          swal('','Marketer doesnot exists','error'); 
        }
        else
          { 
            this.sendreqestmodel.Isloading= true;
            this.group_det=det.result;
            this.sendreqestmodel.selectedmarketeritems=det;
          }
    });
  }

  msgdeletefun(id:any){
    this.CommonService.insertdata(AppSettings.chatmsgdelete,{'id':id})
    .subscribe(package_det =>{  
      this.generateMessageArea(this.Newgroupmodel.g_id);
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
     
      this.generateMessageArea(this.Newgroupmodel.g_id);

    });

  }

  videomyModalfun(val:any,type:any){
    this.Newgroupmodel.videopopupval = val;
    this.Newgroupmodel.video_type = type;
    
  }

  addcaptionfun(){
    this.Newgroupmodel.groupmsgtxt=this.Newgroupmodel.addcaption;
    this.sendMessage();
  }

  
  otheruseroverviewModal(id:any){
    this.CommonService.insertdata(AppSettings.chatwebsiteflag,{'userid':id,'usertype':2}).subscribe(det =>{
      if(det.result){
        this.Newgroupmodel.otherprofilewebsitelists = det.result;
        this.Newgroupmodel.otherusername = det.username;
        this.Newgroupmodel.websitelock = det.websitelock;
        this.Newgroupmodel.otherpimage = det.pimage;
        
      }
  });
  }

  getwebsitelist(){
   
    this.CommonService.insertdata(AppSettings.chatwebsiteflag,{'userid':this.Newgroupmodel.currentUserID,'usertype':2}).subscribe(det =>{
      if(det.result){
        this.Newgroupmodel.profilewebsitelists = det.result;
        this.Newgroupmodel.username = det.username;
        this.Newgroupmodel.aliasname = det.username;
        this.Newgroupmodel.otherpimage = det.pimage;
        
      }
  });
    
  }

}
