# smsSenderServer
a mail server using php predis and mysql

for using this code first you should install redis 

then with using composer libraries like predis should be installed 

then for connecting to db please make a database called mydb in your db
<!-- or you can change db name with your favorite name in entities->phoneNumber.php  -->

in your db make a table with name phoneNumber with mysql command line

and then run your php server on specific port that in this case is port:83
<-- or you can change port to your prefered port by changing port in public/index.php file 

with some api like : http://localhost:83/sms/send/?body=test&number=332211445 
you can see the result in your browser showing a html file that reports your state of mail servers and additional informations.
 
<--! note that in this case ports: 81 and 82 are used for mail servers so for running this app please at first free this two port --> 
