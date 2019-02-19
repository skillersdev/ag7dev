import { Component, OnInit } from '@angular/core';
import { LoginService } from '../../services/login.service';
import { Routes,Router,RouterModule}  from '@angular/router';

@Component({
  selector: 'app-packageinfo',
  templateUrl: './packageinfo.component.html',
  styleUrls: ['./packageinfo.component.css']
})
export class PackageinfoComponent implements OnInit {

  constructor(private loginService: LoginService,private router: Router) { }

  ngOnInit() {
    this.loginService.localStorageData();
     this.loginService.viewsActivate();
  }

}
