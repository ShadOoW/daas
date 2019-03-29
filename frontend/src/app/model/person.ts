export class Person {
  constructor(
    public id: number,
    public name: string,
    public appointments_count: number
  ) {
    this.id = id;
    this.name = name;
    this.appointments_count = appointments_count;
  }
}
