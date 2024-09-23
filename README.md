### Laravel 11 with Vite and React.js Skills Test Task
**Objective:**
Create a microservice-based application with Laravel 11, Vite, and React.js that simulates a
simple "Task Management System." The system will include features for user authentication, task creation, management, and reporting. This task tests the candidate's knowledge of
Laravel’s core features (Service Providers, Gates, Guards, Middleware, Migration, Resources, Authentication) as well as integration with React.js. 

### Requirements:

#### 1. **Microservices Architecture**: 
- Split the application into at least two microservices:
- **User Service**: Manages user registration, authentication, and profile management.
- **Task Service**: Manages task creation, assignment, and status updates.
- The microservices should communicate via APIs (e.g., using HTTP requests or queues).

- #### 2. **Service Providers**:
- Create a custom Service Provider to manage complex service bindings and share common
functionality between different services (e.g., logging, event management).

#### 3. **Authentication**: 

- Use **JWT authentication** for securing the APIs.
- Implement both **guards** and **gates** to ensure that only authenticated users can access protected routes and perform certain actions.
- Only admins can manage tasks, while normal users can only create and update their own
tasks.

#### 4. **Middleware**: 

- Create a custom Middleware to log every request and response to a log file with the timestamp and user ID.
- Create another Middleware to restrict access based on user roles (admin, normal user). ####

5. **Database and Migrations**:

- Create database migrations for:
- **Users** (with roles and authentication tokens).
- **Tasks** (with columns for `title`, `description`, `status`, `assigned_user`, `due_date`, etc.).
- Ensure database relations are well-established (one-to-many for users and tasks).

#### 6. **Gates & Policies**: 

- Use Laravel Gates or Policies to control task permissions. For example:
- - Only admins can assign tasks to users.
- - Users can only update their own tasks. - Admins can delete any task.

 #### 7. **Laravel Resources & API**: 
- Create resource classes for tasks and users to properly structure the API responses.
- Implement CRUD functionality for tasks through API endpoints.
- The APIs should be protected by **auth:api** middleware using JWT tokens.

#### 8. **React.js Frontend with Vite**: 

- Create a React.js frontend using Vite that communicates with the Laravel API.
- Implement the following pages:
- **Login/Register Page**: Allow users to register and login using the JWT token-based authentication.
- **Dashboard**: Display tasks (list of tasks with status and assignees for admins, and a personal list of tasks for regular users).
- **Task Management**: Allow admins to create, assign, and update tasks. Normal users should be able to update and mark their own tasks as completed.
- Use **React Router** for navigation and **Axios** for API communication.

#### 9. **Testing**: 
- Write **unit tests** for all critical functionality including middleware, gates, and resources.
- Write **API tests** for the task management system to ensure proper role-based access
control.

#### 10. **Additional Features** (Bonus): 

- Implement **soft deletes** for tasks, allowing admins to recover deleted tasks.
- Create a **report generation** feature where admins can export a list of all tasks (CSV or PDF).
- Implement real-time updates using **Laravel Echo** and **Pusher** (optional).
-
- ### Deliverables: - A GitHub repository containing the Laravel 11 vite stack code. - Make use of Mongodb or Postgres database
- Clear setup instructions on how to run both the Laravel backend and React frontend.
- Sample API documentation (e.g., using Postman or Swagger).
- - Unit tests and API tests.
 
****Instructions****

Instructions for Running Laravel Backend and React Frontend
Prerequisites
Ensure you have the following installed:
•	PHP 8+
•	Composer
•	Node.js & NPM
•	MySQL (or other database)
•	Git
________________________________________
Laravel Backend Setup
1.	Install Laravel
o	
composer create-project --prefer-dist laravel/laravel backend-app 
cd backend-app

2.	Configure .env File
•	Update .env with your database details:
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password

3.	Generate App Key
php artisan key:generate
4.	Migrate the Database
php artisan migrate
5.	Run Laravel Server
start the Laravel development server:
php artisan serve

The server will run at http://127.0.0.1:8000.

React Frontend Setup
1.	Create React App
o	Run:
npx create-react-app frontend-app
cd frontend-app

2.	Install Axios for API Requests
•	Run:
npm install axios

3.	Proxy Setup (Optional)
•	In package.json, set the Laravel backend as a proxy:
"proxy": "http://127.0.0.1:8000",

4.	Environment Variables
•	Create a .env file and add your backend URL:
REACT_APP_BACKEND_URL=http://127.0.0.1:8000

5.	Run React Server
•	Start the React development server:
npm start

The frontend will run at http://localhost:3000.
Running Both Simultaneously
1.	Start Laravel Backend
o	Run:
php artisan serve
2.	Start React Frontend
•	Run:
npm start

Both the Laravel backend (http://127.0.0.1:8000) and React frontend (http://localhost:3000) will now run simultaneously.
