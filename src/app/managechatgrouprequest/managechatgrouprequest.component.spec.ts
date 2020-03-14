import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { ManagechatgrouprequestComponent } from './managechatgrouprequest.component';

describe('ManagechatgrouprequestComponent', () => {
  let component: ManagechatgrouprequestComponent;
  let fixture: ComponentFixture<ManagechatgrouprequestComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ ManagechatgrouprequestComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(ManagechatgrouprequestComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
