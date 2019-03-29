import { Component } from '@angular/core';

// Services
import { ApiService } from './../service/api.service';

// Models
import { Appointment, Person } from './../model'

@Component({
  selector: 'app-patient',
  templateUrl: './patient.component.html',
  styleUrls: ['./pages.component.scss']
})
export class PatientComponent {
  public patients: Array<Person> = [];
  public patient: Person;
  public appointments: Array<Appointment>;
  public appointmentsRetrieved: boolean = false;

  constructor(private apiService: ApiService) {
    apiService.listPatients();

    apiService.patientsSubject.subscribe(response => {
      this.patients = response;
    });

    apiService.appointmentSubject.subscribe(response => {
      this.appointments = response;
      this.appointmentsRetrieved = true;
    });
  }

  selectPatient(id) {
    this.appointmentsRetrieved = false;
    this.patient = this.patients.find(patient => patient.id === id);
    this.apiService.listAppointmentByPatient(id);
  }
}
