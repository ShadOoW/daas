import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';

import { HttpClientModule } from '@angular/common/http';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { PatientComponent } from './pages/patient.component';
import { DoctorComponent } from './pages/doctor.component';

import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import {
  MatToolbarModule,
  MatTabsModule,
  MatButtonModule,
  MatProgressSpinnerModule,
  MatCardModule,
} from '@angular/material';

@NgModule({
  declarations: [
    AppComponent,
    PatientComponent,
    DoctorComponent
  ],
  imports: [
    HttpClientModule,
    BrowserModule,
    AppRoutingModule,
    BrowserAnimationsModule,
    MatToolbarModule,
    MatTabsModule,
    MatButtonModule,
    MatProgressSpinnerModule,
    MatCardModule,
  ],
  providers: [],
  bootstrap: [
    AppComponent
  ]
})
export class AppModule { }
