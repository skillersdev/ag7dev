import { Component, OnInit } from '@angular/core';
import { LoginService } from '../../services/login.service';
import { Routes,Router,RouterModule}  from '@angular/router';
@Component({
  selector: 'app-managetransfer',
  templateUrl: './managetransfer.component.html',
  styleUrls: ['./managetransfer.component.css']
})
export class ManagetransferComponent implements OnInit {

  constructor(private loginService: LoginService,private router: Router) { }

  ngOnInit() {
    this.loginService.localStorageData();
     this.loginService.viewsActivate();
  }

}
