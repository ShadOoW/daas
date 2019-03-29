# Demo
[Youtube Video](https://youtu.be/solp8Uarsbs)

## How to run
Refer to README files inside backend and frontend folders.

## Code structure
The project is split in two:
    - Backend: REST API based on Lumen framework
    - Frontend: A client based on Angular 7
    
## Implemented
**JWT authentication**: once the user provides a valid email and password, backend will generate a Token, the frontend uses the token to request resources from the API.

**ORM**: using [Eloquent](https://laravel.com/docs/5.0/eloquent#introduction), each table is corresponds to a Model to simplify database operations and migration.

**Material UI**: the application UI/UX is based mainly on Material UI to reduce effort spent on UX/UI.

**Guard**: guards again routing in the frontend by intercepting all routes and confirming that the user has access.

**JWT interceptor**: intercept all API request from frontend and inject the Token.

**RxJs (Reactive Programming)**: using observable to trigger frontend changes, helps decouple components.

**Partial: Unit Test**: Unit test is setup for both projects, but only critical functions are unit tested at the moment.

## Missing features
**Containerisation**: implement DockerFile for frontend, backend and database, and docker-compose to orchestrate the project.

**API Gateway**: implement an API gateway that is the single entry point for all clients. The API gateway handles requests in one of two ways. Some requests are simply proxied/routed to the appropriate service. It handles other requests by fanning out to multiple services.

**GraphQL**: implement a query language to empower the client to control the data returned by the API.

**ProActive Monitoring**: at the moment the admin need to actively monitor the system for fault, it would be better to automatically detect issues with patient and doctor appointments and report them to admin by email or push notification.

**Application Deployment pipeline**: speed up the deployment (Dev/QA/Production) of new features.

## Architecture
**API**:
Using microservices architecture:
- Help keep application easy to modify as it scales up in size
- Different services may have different update and release frequencies.
- To allow for parts of the API to scale up and down independently from each other.
- To allow for different technologies to be used by team members.
- To be resilient to failure if part of the system fails.

**Lumen**:
Lumen is a modern framework based on Laravel, in order to match the requirement of microservices architecture:
- Fast and light
- Secure
- Message Driven
- ORM (Database configuration)
- Productive
- Opinionated

**Angular**
Angular is a very productive framework, it provides:
- An opinionated structure for the code base
- A powerful CLI to bootstrap projects
- Optimized production builds with Webpack (AOT, Chunks, Tree shacking...)
- Encapsulation with WebComponents
- Typescript, a typed language with all the latest EMAScript features, that help reduce mistakes.
- Modular: Great separation of code with Modules
- Powerful templating engine, with Pipes, Directives, Binding...

## Serverless
Serverless function allow even greater separation of concerns, at the cost of slowing the deployment process.

A hybrid architecture is a valid option, to take advantage of architectures that can complement each other if many ways:
- Small features can be implemented as functions while bigger features can be microservices.
- A FaaS API gateway can create a Serverless HTTP-fronted microservice, and take advantage of scaling and other benefits of FaaS.
- Services that are not called often, could be deployed to a shared cloud, instead of a dedicated server, to pay only for used CPU power. 
- Serverless can also help with HTTP request spikes, auto-scalling may take too long to start new instances to catch the spike, while FaaS easly solves this problem.

Serverless FaaS is a good option to use to solve certain problems that otherwise end up costing more money and time, but a hybrid aproach is still the best way to take advantage of the different strength of each technology.
