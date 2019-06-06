import { Component, OnInit } from '@angular/core';
import { Routes,Router,RouterModule}  from '@angular/router';
import { AppSettings } from '../../appSettings';
import { LoginService } from '../../services/login.service';
import { CommonService } from '../../services/common.service';

@Component({
  selector: 'app-manageproducts',
  templateUrl: './manageproducts.component.html',
  styleUrls: ['./manageproducts.component.css']
})
export class ManageproductsComponent implements OnInit {
  getproductlistRestApiUrl:string = AppSettings.productlist;
  DeleteproductRestApiUrl:string = AppSettings.deleteproduct;
  getpackageinfodetApiUrl:string = AppSettings.getPackageInfo; 
  getproductbywebsiteApiUrl:string= AppSettings.productlistbyweb;
  product_det:Array<Object>;
  packagelist:Array<Object>;
  websitelist:Array<Object>;
  model:any={};
  productmodel:any={};
  constructor(private loginService: LoginService,private CommonService: CommonService,private router: Router) { }

  ngOnInit() {
    this.loginService.localStorageData();
    this.loginService.viewsActivate();
    let user_id = localStorage.getItem('currentUserID');
    this.websitelist=[];
     this.CommonService.editdata(this.getpackageinfodetApiUrl,user_id)
          .subscribe(resultdata =>{   
            this.packagelist=resultdata.result;
            this.packagelist.filter((resultexpgem:any) =>{
              this.websitelist.push(resultexpgem.website);

            });
             
            this.productmodel.weblist = this.websitelist;

            this.model.usergroup=localStorage.getItem('currentUsergroup');
              if(this.model.usergroup==2)
              {
                this.productmodel.userid = user_id;
                this.CommonService.insertdata(this.getproductbywebsiteApiUrl,this.productmodel)
                  .subscribe(resultdata =>{   
                   if(resultdata.result!=""){ this.product_det=resultdata.result;}
                });
              }
              else{
                console.log("eeeeeeeeee");
                this.CommonService.getdata(this.getproductlistRestApiUrl)
                .subscribe(det =>{
                    if(det.result!=""){ this.product_det=det.result;}
                });   
              }
                    console.log(this.productmodel);

      });
      
       
    
            

  }

  navigateAddproduct()
  {
    this.router.navigate(['/addproduct']);
  }
  editproduct(id:any)
  {  
     this.router.navigate(['/editproduct',id]);
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
      }).then(function (result) {
        if(result)
        {
           self.removeproduct(idx);
          swal(
            'Deleted!',
            'Product Data has been deleted.',
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
         this.CommonService.getdata(this.getproductlistRestApiUrl)
        .subscribe(det =>{
            if(det.result!=""){ this.product_det=det.result;}
        });
      });
 }

}
