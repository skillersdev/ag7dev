import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { AddsectionitemComponent } from './addsectionitem.component';

describe('AddsectionitemComponent', () => {
  let component: AddsectionitemComponent;
  let fixture: ComponentFixture<AddsectionitemComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ AddsectionitemComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(AddsectionitemComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
