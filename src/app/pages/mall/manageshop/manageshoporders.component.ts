import { Component, OnInit } from '@angular/core';
import { Routes,Router,RouterModule,ActivatedRoute}  from '@angular/router';
import { CommonService } from '../../../services/common.service';
import { AppSettings } from '../../../appSettings';

import { LoginService } from '../../../services/login.service';
declare var jquery:any;
declare var $ :any;
@Component({
  selector: 'app-manageshop',
  templateUrl: './manageshoporders.component.html',
  styleUrls: []
})
export class ManageshopordersComponent implements OnInit {
  getshoporderlistRestApiUrl:string = AppSettings.getshopOrderDetail; 
  private sub: any;

  DeleteshopRestApiUrl:string = AppSettings.deleteshop; 
  getshopbyUserRestApiUrl:string = AppSettings.shopbyid; 
  shoporderlist:Array<Object>;
  model:any={};
  vieworderInfo:any={};
  mallshopurl:any;
  malltypeid:any;
  constructor(private loginService: LoginService,private CommonService: CommonService,private route: ActivatedRoute,private router: Router) { }

  ngOnInit() {
    // this.loginService.malllocalStorageData();
    this.loginService.viewsActivate();

    this.mallshopurl=AppSettings.mallshopurl;

    this.malltypeid = localStorage.getItem('malltypeid');  
    if(this.malltypeid==null){
      this.model.created_by=localStorage.getItem('currentUserID');
    } else{
      
      this.model.mall_id = localStorage.getItem('mallid'); 
     this.model.floor_id = localStorage.getItem('currentFloorid'); 
     this.loginService.malllocalStorageData();        
     this.model.created_by = localStorage.getItem('mallcurrentUser'); 
    }
     this.model.imagePath = AppSettings.API_BASE;
    this.model.usergroup=localStorage.getItem('currentUsergroup');

    this.sub = this.route.params.subscribe(params => {
      this.model.shopname = params['id']; // (+) converts string 'id' to a number     
     
      this.getshoporderlists();
      });
    
    
  }
  getshoporderlists(){
    this.shoporderlist=[];
    // this.CommonService.getdata(this.getshoplistRestApiUrl)
    this.CommonService.insertdata(this.getshoporderlistRestApiUrl,this.model)
        .subscribe(det =>{
            if(det.result!="")
            { 
              this.shoporderlist=det.result;
              console.log("getshoporderlists-->",this.shoporderlist);
            } 
             
        });
  }
  vieworder(orderInfo:any){
    this.vieworderInfo=orderInfo;
    console.log(this.vieworderInfo);
   
  }
 
  
  
}
