import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { ReordersectionComponent } from './reordersection.component';

describe('ReordersectionComponent', () => {
  let component: ReordersectionComponent;
  let fixture: ComponentFixture<ReordersectionComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ ReordersectionComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(ReordersectionComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
