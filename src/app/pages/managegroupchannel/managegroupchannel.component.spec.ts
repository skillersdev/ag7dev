import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { ManagegroupchannelComponent } from './managegroupchannel.component';

describe('ManagegroupchannelComponent', () => {
  let component: ManagegroupchannelComponent;
  let fixture: ComponentFixture<ManagegroupchannelComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ ManagegroupchannelComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(ManagegroupchannelComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
