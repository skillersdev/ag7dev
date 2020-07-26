import { Component, OnInit } from '@angular/core';
import { Routes,Router,RouterModule,ActivatedRoute}  from '@angular/router';
import { AppComponent } from '../../../app.component';
import { TopnavComponent } from '../../../topnav/topnav.component';
import { SidemenuComponent } from '../../../sidemenu/sidemenu.component';
import { Http, Headers, RequestOptions, Response } from '@angular/http';
import { AppSettings } from '../../../appSettings';
import { LoginService } from '../../../services/login.service';
import { CommonService } from '../../../services/common.service';
declare var jquery:any;
declare var $ :any;
import { Injectable } from '@angular/core';
import { ImageCroppedEvent } from 'ngx-image-cropper';

@Component({
  selector: 'app-editsectionitem',
  templateUrl: './editsectionitem.component.html',
  styleUrls: ['./editsectionitem.component.css']
})
export class EditsectionitemComponent implements OnInit {

  
  constructor(private loginService: LoginService,private CommonService: CommonService,
    private route: ActivatedRoute,private router: Router,private http:Http) { }
  websitelist:Array<Object>;
  sectionlist:Array<Object>;
  private sub: any;
  model: any = {};
  alldata:any={};
  select:any;
  getwebsiteRestApiUrl:string = AppSettings.getwebsitelist; 
  id:any;
  ServicePreviewimageChangedEvent:any={};
  serviceimageChangedEvent:any={};
  previewcroppedImage:any='';
  sectioncroppedImage:any='';
  uploadVideofile:any={};
  image_url = AppSettings.IMAGE_BASE;

  ngOnInit() {
  	this.alldata.usertype=localStorage.getItem('currentUsergroup');
    this.alldata.userid=localStorage.getItem('currentUserID');
    this.model.usergroup=localStorage.getItem('currentUsergroup');
    this.model.user_id=localStorage.getItem('currentUserID');
     this.CommonService.insertdata(this.getwebsiteRestApiUrl,this.alldata)
    .subscribe(package_det =>{       
      if(package_det.result!=""){ this.websitelist=package_det.result;}
    }); 
    this.CommonService.insertdata(AppSettings.GetsectionsList,this.model)
    .subscribe(resultdata =>{   
      this.sectionlist=resultdata.result; 
    });
  	this.sub = this.route.params.subscribe(params => {
        this.id = +params['id']; // (+) converts string 'id' to a number
        this.editsection(this.id);        
    });
  }
  editsection(id:any)
  {
    this.CommonService.editdata(AppSettings.FetchSectionItemData,id)
    .subscribe(resultdata =>{   
      this.model = resultdata.result; 
      this.getsection(this.model.website);
      this.model.Issection_show = (this.model.Issection_show==1)?true:false;      
    });
  }
  getsection(website:any){
    this.model.websiteSelected = website;
    this.CommonService.insertdata(AppSettings.GetsectionsList,this.model)
    .subscribe(resultdata =>{   
      this.sectionlist=resultdata.result; 
    });
  }
  updatesectionitem()
  {
  	if(this.model.media_type==1)
      {
        this.CommonService.insertdata(AppSettings.uploadcropserviceimage,this.model)
        .subscribe( (response) => {
            this.model.file_name = (response.data)?response.data:this.model.file_name;
            this.CommonService.insertdata(AppSettings.updatesectionItem,this.model)
            .subscribe(package_det =>{  
              $('.preloader').hide();     
                 swal(
                  package_det.status,
                  package_det.message,
                  package_det.status
                )
                this.router.navigate(['/managesectionitem']); 
            });
        });
      }
      /**********End*****/

      /*******Video Section Upload*******/
      /*****For video and pdf and doc and  audio file upload*******/
      if(this.model.media_type==2 || this.model.media_type==5 || this.model.media_type==4 || this.model.media_type==3)
      {
        /******Api for preview image upload********/
        
        this.CommonService.insertdata(AppSettings.uploadcropserviceimage,this.model)
        .subscribe( (response) => {
       
          this.model.preview_file =(response.data)?response.data:this.model.preview_file;
          
          /******Api for doc/video/ upload********/
          this.CommonService.uploadFile(AppSettings.sectionItemVideoupload,this.uploadVideofile)
          .subscribe( (response) => {
           
              this.model.file_name = (response.status=='fail')?this.model.file_name:response.data;
             
                this.CommonService.insertdata(AppSettings.updatesectionItem,this.model)
                .subscribe( (response) => {
                  if(response.status=='success')
                  {
                    $('.preloader').hide();  
                      swal(response.status,response.message, response.status)
                      this.router.navigate(['/managesectionitem']); 
                    }
                  else{
                    swal('',response.data,'Oops!');
                  }
                });
           
         });
         //}
        });
       
      }      
      /*******/
  }
  back()
	{
	  	 this.router.navigate(['/managesectionitem']);
  }
  /*Preview File section*/
  getservicePreviewImage(event: any): void {        
    this.ServicePreviewimageChangedEvent = event;
    this.model.IspreviewImage= true;
}
PreviewimageCropped(event: ImageCroppedEvent) {
    this.previewcroppedImage = event.base64;
    this.model.file_name = event.base64;
}
/**/
/*Service Image uplad section*/
getserviceImage(event: any): void {
  this.serviceimageChangedEvent = event;
  this.model.IspreviewImage= true;
}
serviceimageCropped(event: ImageCroppedEvent) {
  this.previewcroppedImage = event.base64;
  this.model.file_name = event.base64;
}
/**/
/*Audio file section upload*/
getAudiodet($event) {
this.uploadVideofile = $event.target.files[0];
//this.alldata.IspreviewImage= true;
}
/**/

/*Video file section*/
getVideodet($event) {
this.uploadVideofile = $event.target.files[0];
}
/**/

/*Doc/Pdf*/
getDocOrPdf($event)
{
this.uploadVideofile = $event.target.files[0];
}

}
