import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { ManageproductenquiryComponent } from './manageproductenquiry.component';

describe('ManageproductenquiryComponent', () => {
  let component: ManageproductenquiryComponent;
  let fixture: ComponentFixture<ManageproductenquiryComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ ManageproductenquiryComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(ManageproductenquiryComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
