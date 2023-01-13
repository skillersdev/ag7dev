import { Component, OnInit } from '@angular/core';
import { Routes,Router,RouterModule}  from '@angular/router';
import { CommonService } from '../../../services/common.service';
import { AppSettings } from '../../../appSettings';

import { LoginService } from '../../../services/login.service';
declare var jquery:any;
declare var $ :any;
@Component({
  selector: 'app-managemall',
  templateUrl: './managemall.component.html',
  styleUrls: []
})
export class ManagemallComponent implements OnInit {
  getmalllistRestApiUrl:string = AppSettings.getmallDetail; 
  DeletemallRestApiUrl:string = AppSettings.deletemall; 
  getmallbyUserRestApiUrl:string = AppSettings.mallbyid; 
  Paythrough:Array<object>=[{'id':1,'name':'Enterpreneur'},{'id':2,'name':'Malluser'}];
  malllist:Array<Object>;
  model:any={};
  malltypeid:any;
  select:any;
  constructor(private loginService: LoginService,private CommonService: CommonService,private router: Router) { }

  ngOnInit() {
    // this.loginService.malllocalStorageData();
    this.loginService.viewsActivate();

    this.malltypeid = localStorage.getItem('malltypeid'); 
    this.model.usergroup=localStorage.getItem('currentUsergroup');
    if(this.malltypeid==null){
      this.model.created_by=localStorage.getItem('currentUserID');
    } else{
      this.loginService.malllocalStorageData();  
     //this.model.created_by = localStorage.getItem('mallcurrentUser'); //comment by sridhar
     this.model.created_by = localStorage.getItem('currentUserID');
     this.model.username = localStorage.getItem('mallcurrentUser'); 
    }
    
    // this.malltypeid = localStorage.getItem('malltypeid');
    // let user_id = localStorage.getItem('currentUserID');
    //  this.model.imagePath = AppSettings.API_BASE;
    // this.model.usergroup=localStorage.getItem('currentUsergroup');
    this.getmalllists();
    
  }
  getmalllists(){
    // this.CommonService.getdata(this.getmalllistRestApiUrl)
    this.CommonService.insertdata(this.getmalllistRestApiUrl,this.model)
        .subscribe(det =>{
            if(det.result!="")
            { 
              this.malllist=det.result;
            } 
             
        });
  }
  navigateAddmall()
  {
    this.router.navigate(['/mall/addmall']);
  }
  editmall(id:any)
  {
     this.router.navigate(['/mall/editmall', id]);
  }
  deletemall(id:any)
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
           self.removemall(idx);
          swal(
            'Deleted!',
            'Mall Data has been deleted.',
            'success'
          )
        }
      },function(dismiss) {
    });
  }
 removemall(idx:any)
 {
   this.CommonService.deletedata(this.DeletemallRestApiUrl,idx)
        .subscribe(resultdata =>{
          this.getmalllists();
      });
 }
 onGoToPage2(packprice,mall_id,pack_id){
  this.model.pack_price = packprice;
  this.model.current_mallId = mall_id;
  this.model.package_id = pack_id;
 }

 pay_via_voucher_renew(){
  this.model.type = '6';
  this.CommonService.insertdata(AppSettings.renewPackVoucher,this.model)
    .subscribe(det =>{  
      swal(
        det.status,
        det.message,
        det.status
      )   
      $('#renewModal1').modal('hide');
      if( det.status=='Success'){
        this.getmalllists();
      }
      
    });
 
 }

}
