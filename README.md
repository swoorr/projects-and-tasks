# Project Management System

## Features
- Project creation and management
- Task management within projects
- User authentication and authorization
- Real-time task status updates

## Tech Stack
- Laravel
- MySQL
- Bootstrap
- jQuery

## Setup
1. Clone repository
2. `composer install`
4. Copy `.env.example` to `.env`
5. `php artisan key:generate`
6. Configure database in `.env`
7. `php artisan migrate`
8. `php artisan serve`

## Docker Install and Run 
1. use docker-compose and run `docker-compose up` command

## Usage
- Register/login
- Create project
- Add tasks to project
- Update task status

## API Endpoints
- `POST /api/projects`: Create project
- `GET /api/projects`: List projects
- `POST /api/tasks`: Create task
- `PUT /api/tasks/{id}`: Update task

## Contributing
1. Fork repository
2. Create feature branch
3. Commit changes
4. Push to branch
5. Create pull request

## License
MIT
