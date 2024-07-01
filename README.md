## Task Manager - Rest Api
This is a Task Management With following Features:
1. Rest Api Using JWT Authentication
 - User Register, Login, Logout, Profile View Api's  
 - Board Create, Update, View, Delete. Operation allowed for autheticated user only 
 - Task Create, update, View, Delete.  Operation allowed for autheticated user only

# Information
 Composer
 Lravel 10
 PHP - 8.1
 Mysql
 JWT

# Setup
1. Clone the task-manager repo
2. Run composer install in terminal
3. Set up environment variables by copying `.env.example` to `.env` and updating the values
4. Add database info inside .env file
5. Run this command to generate jwt secret token: `php artisan jwt:secret `(this will be added automatically to .env file )
5. Run: php artisan migrate
6. Run: php artisan serve

#  Rest API Endpoints
- POST /api/user/register : Register a new user
- POST /api/user/login : Login a user
- POST /api/user/logout : Logout a user
- POST /api/user/me : View user profile
- POST api/boards : create a new board
- POST api/boards/{board} : update a board
- Get api/boards : get all boards
- Delete api/boards/{board} : Delete a board
- POST api/boards/{board}/tasks : Create task inside a baord
- Get api/boards/{board}/tasks : get all task in a board
- Get api/boards/{board}/tasks/{task} : get a specific task in a board 
- POST api/boards/{board}/tasks/{task} : Update a task data
- DELETE api/boards/{board}/tasks/{task} : Delete a task
