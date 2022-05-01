##  Newsifier Karma Rating

You can simple follow this simple steps to run the projects:

- Create a new MySQL database and import the newsifer_karma_rating_200k dataset placed in database folder. 
- Run composer install.
- create .env file with the the credentials for the created database.
- run the project.

## Project Routes

The project has two routes:
API route:
http://127.0.0.1:8000/api/v1/user/5377/karma-position?limit=6
you can pass it without limit

Web Route:
http://127.0.0.1:8000/v1/user/karma-position
has its own form
