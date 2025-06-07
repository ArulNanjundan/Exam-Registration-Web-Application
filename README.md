User:

Step 1: User Registration (Login Page):

•	The student opens the website
.
•	They first go to the login/registration page.

•	They enter their email and password.

•	This data is sent to the PHP backend.

•	It is stored in a user login table in the MySQL database.


 Step 2: Fill Full Registration Form:
 
•	After login, the student fills a detailed form:

o	Name, Initial

o	Father’s and Mother’s Name

o	Gender, Religion, Community

o	Date of Birth (DOB)

o	Mobile Number

o	Full Address, Pin code, etc.

•	This form is built using HTML.

•	The form looks clean and styled using CSS.

•	JavaScript checks if all required fields are filled correctly.

Step 3: Data Sent to Backend (PHP):

•	After the student clicks “Submit”, the data goes to the PHP script (reg.php).

•	This PHP script takes all the form values and updates the student’s data in the registration table.

•	It connects to the MySQL database and saves the data.

 Step 4: Data Stored in Database (MySQL):
 
•	The database has two tables:

o	user_login – stores email & password.

o	registration – stores all personal and exam details.

•	Each student has a record with all their information saved securely.

________________________________________

Admin:

Step 1: Admin Login:

•	The goes to a login page.

•	They enter their admin username and password.

•	The system checks these credentials using PHP and the admin table in the MySQL database.

•	If correct → they are allowed in.

•	If wrong → they see an error message.

Step 2: View Registered Students

•	After login, the admin sees a dashboard showing:

o	Student names

o	Registration numbers

o	Exam info (subject/department)

This table data is fetched from the registration table in the database.

Step 3: Admin Actions:

Admins can:

•	Edit student details (like name, mobile, address).

•	Delete wrong or duplicate entries.

•	Exam Schedule Management (Create, Edit, Delete).


