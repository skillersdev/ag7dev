import { Component, OnInit } from '@angular/core';
import { Routes,Router,RouterModule}  from '@angular/router';
import { CommonService } from '../../../services/common.service';
import { AppSettings } from '../../../appSettings';

import { LoginService } from '../../../services/login.service';
declare var jquery:any;
declare var $ :any;
@Component({
  selector: 'app-managefloor',
  templateUrl: './managefloor.component.html',
  styleUrls: []
})
export class ManagefloorComponent implements OnInit {
  getfloorlistRestApiUrl:string = AppSettings.getadminfloor; 
  DeletefloorRestApiUrl:string = AppSettings.deletefloor; 
  getfloorbyUserRestApiUrl:string = AppSettings.floorbyid; 
  Paythrough:Array<object>=[{'id':1,'name':'Enterpreneur'},{'id':2,'name':'Flooruser'}];
  floorlist:Array<Object>;
  malltypeid:any;
  floorid:any;
  model:any={};
  
  constructor(private loginService: LoginService,private CommonService: CommonService,private router: Router) { }

  ngOnInit() {
    // this.loginService.malllocalStorageData();
    this.loginService.viewsActivate();

    this.malltypeid = localStorage.getItem('malltypeid');
    this.floorid=localStorage.getItem('floorid');  
    this.model.usergroup=localStorage.getItem('currentUsergroup');
    if(this.malltypeid==null){
      this.model.created_by=localStorage.getItem('currentUserID');     
    } else{      
      this.loginService.malllocalStorageData();  
     this.model.mall_id = localStorage.getItem('mallid'); 
     this.model.created_by = localStorage.getItem('mallcurrentUser');
    }

    // let user_id = localStorage.getItem('currentUserID');
    // this.malltypeid = localStorage.getItem('malltypeid');  
    //  this.model.imagePath = AppSettings.API_BASE;
    // this.model.usergroup=localStorage.getItem('currentUsergroup');
    this.getfloorlists();
    
  }
  getfloorlists(){
    // this.CommonService.getdata(this.getfloorlistRestApiUrl)
    this.CommonService.insertdata(this.getfloorlistRestApiUrl,this.model)
        .subscribe(det =>{
            if(det.result!="")
            { 
              this.floorlist=det.result;
            } 
             
        });
  }
  navigateAddfloor()
  {
    this.router.navigate(['/mall/addfloor']);
  }
  editfloor(id:any)
  {
     this.router.navigate(['/mall/editfloor', id]);
  }
  deletefloor(id:any)
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
           self.removefloor(idx);
          swal(
            'Deleted!',
            'floor Data has been deleted.',
            'success'
          )
        }
      },function(dismiss) {
    });
  }
 removefloor(idx:any)
 {
   this.CommonService.deletedata(this.DeletefloorRestApiUrl,idx)
        .subscribe(resultdata =>{
          this.getfloorlists();
      });
 }

 onGoToPage2(packprice,floor_id,pack_id){
  this.model.pack_price = packprice;
  this.model.current_floorId = floor_id;
  this.model.package_id = pack_id;
 }

 pay_via_voucher_renew(){
  this.model.type = '7';
  this.CommonService.insertdata(AppSettings.renewPackVoucher,this.model)
    .subscribe(det =>{  
      swal(
        det.status,
        det.message,
        det.status
      )   
      $('#renewModal1').modal('hide');
      if( det.status=='Success'){
        this.getfloorlists();
      }
      
    });
 
 }

}
