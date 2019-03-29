import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule, Routes } from '@angular/router';
import { DashboardComponent } from './dashboard/dashboard.component';
import { PatientComponent } from './dashboard/patient.component';
import { DoctorComponent } from './dashboard/doctor.component';
import { LoginComponent } from './login/login.component';

import { AuthGuard } from './guard/auth.guard'

const routes: Routes = [
  {
    path: 'login',
    component: LoginComponent
  },

  // otherwise redirect to home
  { path: '', redirectTo: '/dashboard', pathMatch: 'full', canActivate: [AuthGuard] },
  { path: 'login', component: LoginComponent },
  {
    path: 'dashboard',
    component: DashboardComponent,
    canActivate: [AuthGuard],
    children: [
      { path: "doctors", component: DoctorComponent, canActivate: [AuthGuard] },
      { path: "patients", component: PatientComponent, canActivate: [AuthGuard] }
    ]
  },
  { path: '**', redirectTo: '' },
];
export const appRouting = RouterModule.forRoot(routes);
@NgModule({
  imports: [
    RouterModule.forRoot(routes),
    CommonModule
  ],
  exports: [ RouterModule ],
  declarations: []
})
export class AppRoutingModule { }
