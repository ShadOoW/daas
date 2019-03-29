export class Appointment {
  constructor(
    public id: number,
    public patient: string,
    public doctor: string,
    public name: string,
    public start_time: number,
    public end_time: number,
    public conflicts: {
      patient: string,
      patient_name: string,
      start_time: string;
      end_time: string;
    },
  ) {
    this.id = id;
    this.patient = patient;
    this.doctor = doctor;
    this.name = name;
    this.start_time = start_time;
    this.end_time = end_time;
    this.conflicts = conflicts;
  }
}
