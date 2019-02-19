import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { PackageinfoComponent } from './packageinfo.component';

describe('PackageinfoComponent', () => {
  let component: PackageinfoComponent;
  let fixture: ComponentFixture<PackageinfoComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ PackageinfoComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(PackageinfoComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
