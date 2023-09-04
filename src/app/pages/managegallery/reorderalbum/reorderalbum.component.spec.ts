import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { ReorderalbumComponent } from './reorderalbum.component';

describe('ReorderalbumComponent', () => {
  let component: ReorderalbumComponent;
  let fixture: ComponentFixture<ReorderalbumComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ ReorderalbumComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(ReorderalbumComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
