import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { ManagechannelsComponent } from './managechannels.component';

describe('ManagechannelsComponent', () => {
  let component: ManagechannelsComponent;
  let fixture: ComponentFixture<ManagechannelsComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ ManagechannelsComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(ManagechannelsComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
