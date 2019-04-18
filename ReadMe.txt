######Open phpMyAdmin
######Create a user with username = "root" and password = ""
######Grant all previleges to "root"
######If using already created user , make changes in connection.php file


######Steps To Create A Database:-
######Create a Database Named -- library_manager
######Create table -- user_credentials
       
######Structure of table -- user_credentials is :- 
     Name              Type         Default       Extra
  1. Id               int(11)        None      Auto_Increment,Primary_Key
  2. first_name      varchar(20)     None          None
  3. last_name       varchar(20)     None          None
  4. username        varchar(20)     None          None
  5. password        varchar(40)     None          None
  6. email_id        varchar(100)    None          None
  7. mobile_number   varchar(10)     None          None
  8. gender          varchar(6)      None          None
  9. account_type    varchar(10)     user          None
 10. fine_due        int(11)          0            None

######Structure of table -- otp_expiry is :-
     Name              Type         Default       Extra
  1. Id              int(10)         None      Auto_Increment,Primary_Key
  2. username       varchar(100)     None          None
  3. otp             int(6)          None          None
  4. expiry_status   int(1)          None          None
  5. create_at       datetime        None          None

######Structure of table -- issued_books is :-
     Name              Type         Default       Extra
  1. issue_id        int(11)         None      Auto_Increment,Primary_Key
  2. user_id         int(10)         None       Foreign_Key(With reference to Id in user_credentials)
  3. username       varchar(100)     None          None
  4. book_id         int(11)         None          None
  5. issue_date        date          None          None
  6. due_date          date          None          None

######Structure of table -- books is :-
     Name              Type         Default       Extra
  1. book_id          int(11)        None      Auto_Increment,Primary_Key
  2. book_name       varchar(100)    None          None
  3. isbn_number     bigint(14)      None          None
  4. subject         varchar(20)     None          None
  5. writer_name     varchar(100)    None          None
  6. issue_status     int(1)           0           None

######Import the -- library_manager.sql -- file using import option
######The Required Data Will be Stored.


######The Library Management System Features Three Types Of Accounts:-
1. Admin
2. Faculty
3. User

######Admin Account Has The Following Features:-
1.Browse All the books present in database
2.Browse All users details 
3.Browse All faculty details
4.Change account type of user
5.Delete user details
6.Live Search of book present in database

######Faculty Account has the following features:- 
1.Browse All the books present in database
2.Browse All users details 
3.Live Search of book present in database
4.Issue and return book
5.Collect Fine
6.Add and delete books in database

######User Account has the following features:-
1.Browse All the books present in database
2.Check Fine due
3.Live Search of book present in database
4.Check issued books


######To login initially use the following details:-
Admin:-Username:sunny
       Password:cccc@1234

Faculty:-Username:siddhant
         Password:bbbb@1234

User:-Username:harshit
      Password:aaaa@1234


#######Generate your sendgrid API Key 
#######ADD API Ket to mail_function.php file in sending_email folder



    
