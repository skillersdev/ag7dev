import { Component, OnInit } from '@angular/core';
import { Routes,Router,RouterModule}  from '@angular/router';

@Component({
  selector: 'app-manageproducts',
  templateUrl: './manageproducts.component.html',
  styleUrls: ['./manageproducts.component.css']
})
export class ManageproductsComponent implements OnInit {

  constructor(private router: Router) { }

  ngOnInit() {
  }
  navigateAddproduct()
  {
    this.router.navigate(['/addproduct']);
  }

}
