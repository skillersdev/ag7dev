import { Component, OnInit } from '@angular/core';
import { Routes,Router,RouterModule}  from '@angular/router';

@Component({
  selector: 'app-managecategory',
  templateUrl: './managecategory.component.html',
  styleUrls: ['./managecategory.component.css']
})
export class ManagecategoryComponent implements OnInit {

  constructor(private router: Router) { }

  ngOnInit() {
  }
  navigateAddcategory()
  {
    this.router.navigate(['/addcategory']);
  }

}
