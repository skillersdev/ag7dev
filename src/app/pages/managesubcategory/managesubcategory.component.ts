import { Component, OnInit } from '@angular/core';
import { Routes,Router,RouterModule}  from '@angular/router';
import { LoginService } from '../../services/login.service';

@Component({
  selector: 'app-managesubcategory',
  templateUrl: './managesubcategory.component.html',
  styleUrls: ['./managesubcategory.component.css']
})
export class ManagesubcategoryComponent implements OnInit {

  constructor(private loginService: LoginService,private router: Router) { }

  ngOnInit() {
    this.loginService.localStorageData();
     this.loginService.viewsActivate();
  }
  navigateAddsubcategory()
  {
    this.router.navigate(['/addsubcategory']);
  }
}
