import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { ManageenquiryComponent } from './manageenquiry.component';

describe('ManageenquiryComponent', () => {
  let component: ManageenquiryComponent;
  let fixture: ComponentFixture<ManageenquiryComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ ManageenquiryComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(ManageenquiryComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
