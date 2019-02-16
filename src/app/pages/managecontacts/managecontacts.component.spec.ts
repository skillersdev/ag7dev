import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { ManagecontactsComponent } from './managecontacts.component';

describe('ManagecontactsComponent', () => {
  let component: ManagecontactsComponent;
  let fixture: ComponentFixture<ManagecontactsComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ ManagecontactsComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(ManagecontactsComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
