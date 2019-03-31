import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { MyDoctorComponent } from './my-doctor.component';

describe('MyDoctorComponent', () => {
  let component: MyDoctorComponent;
  let fixture: ComponentFixture<MyDoctorComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ MyDoctorComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(MyDoctorComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
