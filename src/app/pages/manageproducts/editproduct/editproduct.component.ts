import { Component, OnInit } from '@angular/core';
import { Routes,Router,RouterModule,ActivatedRoute}  from '@angular/router';

import { AppComponent } from '../../../app.component';

import { TopnavComponent } from '../../../topnav/topnav.component';
import { SidemenuComponent } from '../../../sidemenu/sidemenu.component';
import { Http, Headers, RequestOptions, Response } from '@angular/http';
import { AppSettings } from '../../../appSettings';
import { LoginService } from '../../../services/login.service';
import { CommonService } from '../../../services/common.service';
import { ImageCroppedEvent } from 'ngx-image-cropper';
declare var jquery:any;
declare var $ :any;
import { Injectable } from '@angular/core';

@Component({
  selector: 'app-editproduct',
  templateUrl: './editproduct.component.html',
  styleUrls: ['./editproduct.component.css']
})
export class EditproductComponent implements OnInit {

  currentUser:any;
  currentUserID:any;
  currentUsername:any;
  currentUsergroup:any;
  currentUserStatus:any;
  currentAllUsers:any;
  select: any;
  getcategorylistRestApiUrl:string = AppSettings.getcategoryDetail; 
  getsubcategorylistRestApiUrl:string = AppSettings.getsubcategoryDetail; 
  getwebsiteRestApiUrl:string = AppSettings.getwebsitelist; 
  uploaduserProfileApi:string=AppSettings.uploadserviceimage;
  uploaduserAdvApi:string=AppSettings.uploadcropimage;
  getsubcategoryRestApiUrl:string = AppSettings.getsubcategorybyid;
  insertproductRestApiUrl :string = AppSettings.addproduct;
  FetchproductRestApiUrl:string = AppSettings.editproduct;
  updateproductRestApiUrl:string = AppSettings.updateproduct;
  getcategorybyUserRestApiUrl:string = AppSettings.categorybyid; 
  image_url = AppSettings.IMAGE_BASE;
  categorylist:Array<Object>;
  subcategorylist:Array<Object>;
  websitelist:Array<Object>;
  product_det:Array<Object>;
  imageChangedEvent: any = '';
    croppedImage: any = '';
   private sub: any;
   IsshowSku:boolean=false;
   attribute_list:Array<Object>=[];
   variation_list:Array<Object>=[];
   product_setting_model:any={};
   id:number;
  model: any = {};
  model1:any={};
  alldata: any = {};
  localdata:any={};
  constructor(private loginService: LoginService,private CommonService: CommonService,private route: ActivatedRoute,private router: Router,private http:Http) { 
      document.body.className="theme-red";

  }

  ngOnInit() {
  	 this.loginService.localStorageData();
      this.loginService.viewsActivate();
      /*category list*/
     let user_id = localStorage.getItem('currentUserID');
     this.localdata.imagePath = AppSettings.API_BASE;
    this.localdata.usergroup=localStorage.getItem('currentUsergroup');
    if(this.localdata.usergroup==2)
    {

      this.CommonService.editdata(this.getcategorybyUserRestApiUrl,user_id)
        .subscribe(resultdata =>{   
          this.categorylist=resultdata.result; 
        });
    
      }
      else{
        this.CommonService.getdata(this.getcategorylistRestApiUrl)
        .subscribe(det =>{
            if(det.result!="")
            { 
              this.categorylist=det.result;
            } 
             
        });
      } 

        this.alldata.usertype=localStorage.getItem('currentUsergroup');
        this.alldata.userid=localStorage.getItem('currentUserID');
      
         this.CommonService.insertdata(this.getwebsiteRestApiUrl,this.alldata)
        .subscribe(package_det =>{       
          if(package_det.result!=""){ this.websitelist=package_det.result;}
        }); 
         this.sub = this.route.params.subscribe(params => {
        this.id = +params['id']; // (+) converts string 'id' to a number
        this.editproduct(this.id);        
        });
  }

  editproduct(id:any)
  {
  	this.CommonService.editdata(this.FetchproductRestApiUrl,id)
        .subscribe(resultdata =>{   
          this.model = resultdata.result;  
          this.IsshowSku = (this.model.sku=='')?true:false;
          this.attribute_list =  resultdata.attribute_response;  
          this.variation_list=  resultdata.variations_response;  
           this.CommonService.editdata(this.getsubcategoryRestApiUrl,this.model.category_id)
              .subscribe(resultdata =>{   
                this.subcategorylist=resultdata.result; 
           });        
        });

       
  }
  updateproduct()
  {    

    if(this.attribute_list.length>0){
      this.model.attribute_list = this.attribute_list;
    }
    if(this.variation_list.length>0){
      this.model.variation_list = this.variation_list;
    }
    if(this.IsshowSku){
      this.model.sku = this.model.website+'-'+this.model.sku;
    }    

  	this.CommonService.updatedata(this.updateproductRestApiUrl,this.model)
    .subscribe(package_det =>{       
         swal(package_det.status,package_det.message,package_det.status) 
         this.router.navigate(['/manageproducts']);
    });
  }
  fileEvent($event) {
    const fileSelected: File = $event.target.files[0];
    
    this.CommonService.uploadFile(this.uploaduserProfileApi,fileSelected)
    .subscribe( (response) => {
       if(response.status=='success')
       {
        this.model.product_image = response.data;
       }
        else{
          swal('',"Error while on upload photo",'Oops!');
        }
     })
   }
  back(){
    this.router.navigate(['/manageproducts']);
  }
  getsubcategory(cat_id:any)
  {
     this.CommonService.editdata(this.getsubcategoryRestApiUrl,cat_id)
        .subscribe(resultdata =>{   
          this.subcategorylist=resultdata.result; 
        });
  }

  fileChangeEvent(event: any): void {
        this.imageChangedEvent = event;
    }
  imageCropped(event: ImageCroppedEvent) {
        this.croppedImage = event.base64;
        this.model1.Imagefile = event.base64;
        this.CommonService.insertdata(this.uploaduserAdvApi,this.model1)
      .subscribe( (response) => {
         if(response.status=='success')
         {
          this.model.product_image = response.data;
        }
     })


    }
    updateAttribute(){
      this.attribute_list.push({'name':this.product_setting_model.attribute_name,'value':this.product_setting_model.attribute_value});
      $('#AttributeModal').modal('hide');
      this.product_setting_model.attribute_name=this.product_setting_model.attribute_value='';
    }
    updateVariation(){
      this.variation_list.push({'name':this.product_setting_model.variation_name,'value':this.product_setting_model.variation_value});
      $('#VariationModal').modal('hide');
      this.product_setting_model.variation_name=this.product_setting_model.variation_value='';
    }
    deleteAttribute(index:any){
      this.attribute_list.splice(index,1);
    }
    deleteVariation(index:any){
      this.variation_list.splice(index,1);
    }


}
