import { Component } from '@angular/core';

// Services
import { ApiService } from './../service/api.service';

// Models
import { Appointment, Person } from './../model'

@Component({
  selector: 'app-doctor',
  templateUrl: './doctor.component.html',
  styleUrls: ['./pages.component.scss']
})
export class DoctorComponent {
  public doctors: Array<Person> = [];
  public doctor: Person;
  public appointments: Array<Appointment>;
  public appointmentsRetrieved: boolean = false;

  constructor(private apiService: ApiService) {
    apiService.listDoctors();

    apiService.doctorsSubject.subscribe(response => {
      this.doctors = response;
    });

    apiService.appointmentSubject.subscribe(response => {
      this.appointments = response;
      this.appointmentsRetrieved = true;
    });
  }

  selectDoctor(id) {
    this.appointmentsRetrieved = false;
    this.doctor = this.doctors.find(doctor => doctor.id === id);
    this.apiService.listAppointmentByDoctor(id);
  }
}
