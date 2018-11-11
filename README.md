<<<<<<< HEAD
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
=======
# phonebook-enhancement for a the [inno-thinyldap provided by a-schild](https://github.com/a-schild/inno-thinyldap)

What about an ehnhancement to [this phonebook](https://github.com/a-schild/inno-thinyldap) ?

noticed in innovaphone forum [here](http://class.innovaphone.com/moodle2/mod/forum/discuss.php?d=20447)

myPBX can [call externals apps with incoming calls](http://wiki.innovaphone.com/index.php?title=Reference11r1:Concept_myPBX#Starting_an_external_application_for_a_call)

this app can deal with the parameters myPBX deliers as output while caling the app.

getting info from the mySQL-table or the phonebook concerning this number  
and show a dialog to put in additional data to save it as new dataset into the phonebook table
should work.



[steps](steps/steps.md)


>>>>>>> 3d9359abd1849736674653f32b8071851add06c7

