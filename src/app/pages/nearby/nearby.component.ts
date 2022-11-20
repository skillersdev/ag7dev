import { Component, OnInit } from '@angular/core';
import {GMapModule} from 'primeng/gmap';
declare var google: any;

@Component({
  selector: 'app-nearby',
  templateUrl: './nearby.component.html',
  styleUrls: ['./nearby.component.css']
})
export class NearbyComponent implements OnInit {
  options: any;

    overlays: any[];
    infoWindow: any;

  constructor() { }

  ngOnInit() {
    this.options = {
      center: {lat: 36.890257, lng: 30.707417},
      zoom: 12
    };
    this.infoWindow = new google.maps.InfoWindow();
  }

}
