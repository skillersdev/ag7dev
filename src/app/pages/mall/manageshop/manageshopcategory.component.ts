import { Component, OnInit } from '@angular/core';
import { Routes,Router,RouterModule,ActivatedRoute}  from '@angular/router';
import { CommonService } from '../../../services/common.service';
import { AppSettings } from '../../../appSettings';

import { LoginService } from '../../../services/login.service';
declare var jquery:any;
declare var $ :any;
@Component({
  selector: 'app-manageshopcategory',
  templateUrl: './manageshopcategory.component.html',
  styleUrls: []
})
export class ManageshopCategoryComponent implements OnInit {
  getshoplistRestApiUrl:string = AppSettings.getshopDetail; 
  DeleteshopRestApiUrl:string = AppSettings.deleteshop; 
  getshopbyUserRestApiUrl:string = AppSettings.shopbyid; 
  getshopcategorylistRestApiUrl:string = AppSettings.getshopCategoryDetail;
  DeleteshopCategoryRestApiUrl:string = AppSettings.deleteshopcategory; 
  addCategoryRestApiUrl:string=AppSettings.createcategory;
  shopcategorylist:Array<Object>;
  model:any={};
  addmodel:any={};
  mallshopurl:any;
  mallshopordersurl:any;
  malltypeid:any;
  shopid:any;
  sub:any;
  constructor(private loginService: LoginService,private CommonService: CommonService,private route: ActivatedRoute,private router: Router) { }

  ngOnInit() {
    // this.loginService.malllocalStorageData();
    this.loginService.viewsActivate();

    this.mallshopurl=AppSettings.mallshopurl;
    this.mallshopordersurl="mall/manageshoporders/";

    this.malltypeid = localStorage.getItem('malltypeid'); 
    this.shopid=localStorage.getItem('shopid');  
    if(this.malltypeid==null){
      this.model.created_by=localStorage.getItem('currentUserID');
    } else{
      
      this.model.mall_id = localStorage.getItem('mallid'); 
     this.model.floor_id = localStorage.getItem('floorid'); 
     this.loginService.malllocalStorageData();        
     this.model.created_by = localStorage.getItem('mallcurrentUser'); 
    }
     this.model.imagePath = AppSettings.API_BASE;
    this.model.usergroup=localStorage.getItem('currentUsergroup');

    this.sub = this.route.params.subscribe(params => {
      this.model.shop_id = params['id']; // (+) converts string 'id' to a number     
     this.addmodel.shop_id=params['id']; 
      this.getshopcategorylists();
      });

    
  }
  getshopcategorylists(){
    this.shopcategorylist=[];
    // this.CommonService.getdata(this.getshoplistRestApiUrl)
    this.CommonService.insertdata(this.getshopcategorylistRestApiUrl,this.model)
        .subscribe(det =>{
            if(det.result!="")
            { 
              
              this.shopcategorylist=det.result;
            } 
             
        });
  }
 

  addcategory()
  {
    
    // console.log(this.model);

    this.CommonService.insertdata(this.addCategoryRestApiUrl,this.addmodel)
    .subscribe(package_det =>{       
         swal(
          package_det.status,
          package_det.message,
          package_det.status
        );

        this.getshopcategorylists();
        
    });
  }



  deleteshopcategory(id:any)
  {
    let idx = id;
      let self = this;
      swal({
        title: 'Are you sure?',
         buttons: {
            cancel: true,
            confirm: true,
          },
        text: "You won't be able to revert this!",
      }).then(function (result) 
      {
        if(result)
        {
           self.removeshopcategory(idx);
          swal(
            'Deleted!',
            'Category Data has been deleted.',
            'success'
          )
         
        }
      },function(dismiss) {
    });
  }
  removeshopcategory(idx:any)
 {
   this.CommonService.deletedata(this.DeleteshopCategoryRestApiUrl,idx)
        .subscribe(resultdata =>{
          this.getshopcategorylists();
      });
 }

}
