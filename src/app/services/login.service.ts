import { Injectable } from '@angular/core';
import {Response,  RequestOptions, URLSearchParams, Headers } from '@angular/http';
import { Router } from '@angular/router';
import { HttpClient} from  '@angular/common/http';

declare var $ :any;


@Injectable()
export class LoginService {
  windowHeight:any;
  constructor(private _http: HttpClient,private router: Router) { }

  //check user login from API
  checkUsers(apiUrl:any,model:any) {
    return this._http.post(apiUrl, model);
  }
  //check Authentication for valid User stores in Local Storage
  localStorageData(){

    if(localStorage.getItem('currentUser')==null)
    {
      this.router.navigate(['./']);
    }
      
  }

  malllocalStorageData(){

    if(localStorage.getItem('mallcurrentUser')==null)
    {
      this.router.navigate(['./']);
    }
      
  }

  
  //clear all local storage and navigate to login 
  logout(){
      localStorage.removeItem('currentUser');
      localStorage.removeItem('currentUserID');
      localStorage.removeItem('currentUsername');
      localStorage.removeItem('currentUsergroup');
      localStorage.removeItem('currentUserStatus');
      localStorage.removeItem('chatcode');
      localStorage.clear();
      this.router.navigate(['./login']);
  }  
  
  logout2(){
    localStorage.removeItem('currentUser');
    localStorage.removeItem('currentUserID');
    localStorage.removeItem('currentUsername');
    localStorage.removeItem('currentUsergroup');
    localStorage.removeItem('currentUserStatus');
    localStorage.removeItem('chatcode');
    localStorage.clear();
    this.router.navigate(['./mall/login']);
} 

  sidemenuActive(){
    $.AdminBSB.browser.activate();
    $.AdminBSB.leftSideBar.activate();
    $.AdminBSB.rightSideBar.activate();
    $.AdminBSB.navbar.activate();
  }

  viewsActivate() {
    $.AdminBSB.browser.activate();
    // $.AdminBSB.leftSideBar.activate();
    // $.AdminBSB.rightSideBar.activate();
    // $.AdminBSB.navbar.activate();
    $.AdminBSB.dropdownMenu.activate();
    $.AdminBSB.input.activate();
    $.AdminBSB.select.activate(); 
    $.AdminBSB.search.activate();
    setTimeout(function () { $('.page-loader-wrapper').fadeOut(); }, 50);
    // this.sidemenuActive();

    $(function () {
        $('.js-basic-example').DataTable({
            responsive: true
        });

        //Exportable table
        $('.js-exportable').DataTable({
            dom: 'Bfrtip',
            responsive: true,
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
    });


  }

  viewsManageUserActivate() {

    
  }

  viewCommontdataTable(divid,classname){
    setTimeout(function () {
      $('#'+divid).DataTable().destroy();
      $('.'+classname).DataTable({
        dom: 'Bfrtip',
        "pageLength": 50,
        responsive: true,
        buttons: [//'copy', 'csv', 'excel', 'pdf', 'print'
        ]
      });

      // $.AdminBSB.dropdownMenu.activate();
      $.AdminBSB.select.activate();  
    }, 200);   

  }


  viewsUploadoption(){
    $('#my-button').click(function(){
      alert("test here");
      $('#my-file').click();
    });
  }

  loadmsgscreenadjustable(){
    $(document).ready(function() {
         
      
      $(window).resize(function() {
        this.windowHeight = $(window).innerHeight();
        $('#messages').css('min-height', this.windowHeight);
      });
      
     
       
    });
  }


}
