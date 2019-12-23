# Blogsymfony
I used Symfony 4 with MAMP in my project.

## The function: 
1.	***Blog***

•	Create new Blog by user(connected) or Admin

•	Edit Blog by user (connected) and admin

•	Delete the Blog and Commentaries by the admin just 

•	Show all the Blogs and Commentaries by all (if you are connected or not)

•	Add and Edit Commentaries just if the user is connected

2.	***Security***

•	New User, we check the data or the input if it is correct or not with comment for user to help him, par example if the password and Confirm password is the same or not and if there are more than 8 char or not , check the email field if he is an email par example like email@email.com

•	When the user is connected the button in top-right corner change to Disconnected and if he is not connected it change to Connexion

### The problems :

***The First Problem :*** I find in my project a big problem to integrate FOSUserBundle because he want to change the version of twing, form ..etc. to old version and I think this is not the goal of this project . because of this I used anther thing for security , for more information you can see the code.

***The Second Problem :*** after i deloy my project in heroku i have this problem when i want to register new user or Connexion the user , i tried solve it but i didn't found the solution
![GitHub Logo](blogsymfony/image/error.png)

***For this reason i made two version***

1- The first version with security , this is the link :

2- The second version without security (So you can see the other part of the project ) , this is the link :
