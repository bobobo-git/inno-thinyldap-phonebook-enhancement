importing additional contacts to the phonebook in an easy way was asked by a client.

how about a solution that asks for a name when a call arrives that is unknown till now?  

i'm on my way to code a solution using a programm that is started  
as [external_application from mypbx](http://wiki.innovaphone.com/index.php?title=Reference11r1:Concept_myPBX#Starting_an_external_application_for_a_call),
contacting the mysql-table of  
the phonebook to put in new data (the name has to be entered by  
the mypbx-user) if the number doesn't exist in telephoneNumber,  
mobile or homePhone.
i think it will connect the database via http(s)  
avoiding to install local software like odbc-connector or stuff

