import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { ManagepackagesComponent } from './managepackages.component';

describe('ManagepackagesComponent', () => {
  let component: ManagepackagesComponent;
  let fixture: ComponentFixture<ManagepackagesComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ ManagepackagesComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(ManagepackagesComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
