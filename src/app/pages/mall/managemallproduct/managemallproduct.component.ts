import { Component, OnInit } from '@angular/core';
import { Routes,Router,RouterModule}  from '@angular/router';
import { CommonService } from '../../../services/common.service';
import { AppSettings } from '../../../appSettings';

import { LoginService } from '../../../services/login.service';
declare var jquery:any;
declare var $ :any;
@Component({
  selector: 'app-managemallproduct',
  templateUrl: './managemallproduct.component.html',
  styleUrls: []
})
export class ManagemallproductComponent implements OnInit {
  getproductlistRestApiUrl:string = AppSettings.getmallproductDetail; 
  DeleteproductRestApiUrl:string = AppSettings.deletemallproduct; 
  getproductbyUserRestApiUrl:string = AppSettings.mallproductbyid; 
  productlist:Array<Object>;
  model:any={};
  malltypeid:any;
  shopid:any;
  constructor(private loginService: LoginService,private CommonService: CommonService,private router: Router) { }

  ngOnInit() {
    // this.loginService.malllocalStorageData();
    // this.malltypeid = localStorage.getItem('malltypeid');  
    this.loginService.viewsActivate();

    this.malltypeid = localStorage.getItem('malltypeid');  
    this.shopid =localStorage.getItem('shopid'); 
    this.model.usergroup=localStorage.getItem('currentUsergroup');
    if(this.malltypeid==null){
      this.model.created_by=localStorage.getItem('currentUserID');
    } else{
      
      this.model.mall_id = localStorage.getItem('mallid'); 
      this.model.floor_id = localStorage.getItem('floorid'); 
      this.model.shop_id = localStorage.getItem('shopid'); 
      this.model.created_by = localStorage.getItem('mallcurrentUser'); 
      this.loginService.malllocalStorageData();     
    }

    // let user_id = localStorage.getItem('currentUserID');
    //  this.model.imagePath = AppSettings.API_BASE;
    // this.model.usergroup=localStorage.getItem('currentUsergroup');
    this.getproductlists();
    
  }
  getproductlists(){
    this.productlist=[];
    // this.CommonService.getdata(this.getproductlistRestApiUrl)
    this.CommonService.insertdata(this.getproductlistRestApiUrl,this.model)
        .subscribe(det =>{
            if(det.result!="")
            { 
              if(this.shopid!="" && this.malltypeid==3 ){
                this.productlist=det.result;
                this.productlist = det.result.filter(
                  res => res.shop_id == this.shopid);
              }else{
                this.productlist=det.result;
              }


            } 
             
        });
  }
  navigateAddproduct()
  {
    this.router.navigate(['/mall/addmallproduct']);
  }
  editproduct(id:any)
  {
     this.router.navigate(['/mall/editmallproduct', id]);
  }
  deleteproduct(id:any)
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
           self.removeproduct(idx);
          swal(
            'Deleted!',
            'product Data has been deleted.',
            'success'
          )
         
        }
      },function(dismiss) {
    });
  }
 removeproduct(idx:any)
 {
   this.CommonService.deletedata(this.DeleteproductRestApiUrl,idx)
        .subscribe(resultdata =>{
          this.getproductlists();
      });
 }

}
