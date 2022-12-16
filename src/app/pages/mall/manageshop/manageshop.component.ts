import { Component, OnInit } from '@angular/core';
import { Routes,Router,RouterModule}  from '@angular/router';
import { CommonService } from '../../../services/common.service';
import { AppSettings } from '../../../appSettings';

import { LoginService } from '../../../services/login.service';
declare var jquery:any;
declare var $ :any;
@Component({
  selector: 'app-manageshop',
  templateUrl: './manageshop.component.html',
  styleUrls: []
})
export class ManageshopComponent implements OnInit {
  getshoplistRestApiUrl:string = AppSettings.getshopDetail; 
  DeleteshopRestApiUrl:string = AppSettings.deleteshop; 
  getshopbyUserRestApiUrl:string = AppSettings.shopbyid; 
  shoplist:Array<Object>;
  model:any={};
  mallshopurl:any;
  mallshopordersurl:any;
  mallshopcategorysurl:any;
  malltypeid:any;
  shopid:any;
  constructor(private loginService: LoginService,private CommonService: CommonService,private router: Router) { }

  ngOnInit() {
    // this.loginService.malllocalStorageData();
    this.loginService.viewsActivate();

    this.mallshopurl=AppSettings.mallshopurl;
    this.mallshopordersurl="mall/manageshoporders/";
    this.mallshopcategorysurl="mall/manageshopcategory/";
    

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
    this.getshoplists();
    
  }
  getshoplists(){
    this.shoplist=[];
    // this.CommonService.getdata(this.getshoplistRestApiUrl)
    this.CommonService.insertdata(this.getshoplistRestApiUrl,this.model)
        .subscribe(det =>{
            if(det.result!="")
            { 
              
              if(this.shopid!="" && this.malltypeid==3 ){
                this.shoplist=det.result;
                this.shoplist = det.result.filter(
                  res => res.id === this.shopid);
              }else{
                this.shoplist=det.result;
              }
              console.log("shoplist--->",this.shoplist);
            } 
             
        });
  }
  navigateAddshop()
  {
    this.router.navigate(['/mall/addshop']);
  }

  viewCategory(viewshopid:any){
    this.router.navigate([this.mallshopcategorysurl,viewshopid]);
  }

  viewOrders(viewshopid:any)
  {
    this.router.navigate([this.mallshopordersurl,viewshopid]);
  }
  editshop(id:any)
  {
     this.router.navigate(['/mall/editshop', id]);
  }
  deleteshop(id:any)
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
           self.removeshop(idx);
          swal(
            'Deleted!',
            'shop Data has been deleted.',
            'success'
          )
         
        }
      },function(dismiss) {
    });
  }
 removeshop(idx:any)
 {
   this.CommonService.deletedata(this.DeleteshopRestApiUrl,idx)
        .subscribe(resultdata =>{
          this.getshoplists();
      });
 }

}
