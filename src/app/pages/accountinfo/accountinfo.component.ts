import { Component, OnInit } from '@angular/core';
import { Routes,Router,RouterModule}  from '@angular/router';

import { LoginService } from '../../services/login.service';

@Component({
  selector: 'app-accountinfo',
  templateUrl: './accountinfo.component.html',
  styleUrls: ['./accountinfo.component.css']
})
export class AccountinfoComponent implements OnInit {

  constructor(private loginService: LoginService,private router: Router) { }

  ngOnInit() {
    this.loginService.localStorageData();
     this.loginService.viewsActivate();
  }

}
