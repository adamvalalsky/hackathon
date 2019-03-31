import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { LoginComponent } from './login/login.component';
import { UserDashboardComponent } from './user-dashboard/user-dashboard.component';
import { DoctorDetailComponent } from './doctor-detail/doctor-detail.component';
import { MyDoctorComponent } from './my-doctor/my-doctor.component';
import { FreeTerminComponent } from './free-termin/free-termin.component';
import { CreateOrderComponent } from './create-order/create-order.component';

const routes: Routes = [
  { path: "", redirectTo: "/login" , pathMatch: "full" },
  { path: "login", component: LoginComponent },
  { path: "user-dashboard", component: UserDashboardComponent },
  { path: "doctor-detail/:id", component: DoctorDetailComponent },
  { path: "my-doctor/:id", component: MyDoctorComponent },
  { path: "free-termins/:doc_id/:month/:day", component: FreeTerminComponent },
  { path: "create-order/:doc_id/date/:date/term/:term", component: CreateOrderComponent }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
