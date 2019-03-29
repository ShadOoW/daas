import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Person, Appointment } from '../model';
import {Subject} from 'rxjs/internal/Subject';

@Injectable({
  providedIn: 'root'
})
export class ApiService {
  public appointmentSubject: Subject<Appointment[]> = new Subject();
  public doctorsSubject: Subject<Person[]> = new Subject();
  public patientsSubject: Subject<Person[]> = new Subject();

  constructor(private http: HttpClient) { }

  public listPatients(): void {
    const url = 'http://localhost:8000/patient/list';
    this.http.get<Person[]>(url).subscribe(response => {
      this.patientsSubject.next(response.map(item => new Person(
        item.id,
        item.name,
        item.appointments_count
      )));
    });
  }

  public listDoctors(): void {
    const url = 'http://localhost:8000/doctor/list';
    this.http.get<Person[]>(url).subscribe(response => {
      this.doctorsSubject.next(response.map(item => new Person(
        item.id,
        item.name,
        item.appointments_count
      )));
    });
  }

  public listAppointmentByPatient(id): void {
    const url = 'http://localhost:8000/appointment/patient/' + id;
    this.http.get<Appointment[]>(url).subscribe(response => {
      this.appointmentSubject.next(response.map(item => new Appointment(
        item.id,
        item.patient,
        item.doctor,
        item.name,
        item.start_time,
        item.end_time,
        item.conflicts
      )));
    });
  }

  public listAppointmentByDoctor(id): void {
    const url = 'http://localhost:8000/appointment/doctor/' + id;
    this.http.get<Appointment[]>(url).subscribe(response => {
      this.appointmentSubject.next(response.map(item => new Appointment(
        item.id,
        item.patient,
        item.doctor,
        item.name,
        item.start_time,
        item.end_time,
        item.conflicts
      )));
    });
  }
}
