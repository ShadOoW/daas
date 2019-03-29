import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule, Routes } from '@angular/router';
import { PatientComponent } from './pages/patient.component';
import { DoctorComponent } from './pages/doctor.component';

const routes: Routes = [
  { path: '', redirectTo: '/doctors', pathMatch: 'full' },
  { path: 'doctors', component:  DoctorComponent},
  { path: 'patients', component:  PatientComponent},
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
