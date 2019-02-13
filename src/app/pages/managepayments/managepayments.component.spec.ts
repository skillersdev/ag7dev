import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { ManagepaymentsComponent } from './managepayments.component';

describe('ManagepaymentsComponent', () => {
  let component: ManagepaymentsComponent;
  let fixture: ComponentFixture<ManagepaymentsComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ ManagepaymentsComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(ManagepaymentsComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
