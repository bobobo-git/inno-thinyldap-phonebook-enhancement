# Thoughts

1. creating the app to get data from myPBX starting the app as  
  external application while a call happens. Should be OS independant.
___
2. Starting with Windows, calling cmd /K with parameters that  
  works ok  
___
3. Test to get access via HTTP(s) of the regular paths of the LAP  
  http(s)://<LAP IP>/apps/phonebook isn't successful. The LAP-  
  webserver uses basic access authentication and my skills aren't  
  high enough to handle with it with the programinglanguage i use  
  for my app.
___
4.  the decision to use an odbc-connector was rejected. I want  
  to make an app that's portable and has low impact on the host.  
  An installation of mysql-odbc-connector doesn't come handy here.
___
5. decision to create another path to the webserver and create  
  php-scripts to handle the database via http-calls that  
  send data to and get data from mysql via http. Using another port  
  than 80 or 443. i use 8080
___
6. develope the app.
	
___
# App
___
- store variables in an PreferencesFile (ini) , extension, used webserver  
  username, password if needed,...

___
- Popup while a in- or outwards call happens with "no name". i.e. the  
  LDAP-Server hasn't delivered a name for the called (out) or caller  
  (in) number. Input Lastname, search while input to names that matches  
  the name as entered. Input company, can select companies that matches  
  to the lastname. input firstname, can select matching firstnames  
  (lastname and company matches)
___
- **canceled, using innovapphoen reporting instead :** The app can be  
  switched to a "record-only"-mode. Calls without a name are stored in  
  a mysql-table. Later this can be used to fill the phonebook manually
___
- to achieve the matching the app has to load the data from the ldap.  
  a call of a php-script on the ldap webserver delivers the table that is  
  locally stored in a sqlite-database, which is used for the serching while  
  enter names and company.
___
- to get it simple (see above 3.) create a webaccessible parallel folder  
  to the original webaccessible folders of the LAP. Don't include it  
  in the password-management (htdigest) of the webserver Port 80 and 443.  
- Access via calling the http://<LAPIP>:8080/scriptname.php will be used  
  to get or set data to the database. Creating some in- and output-php-  
  scripts that can handle the mysql-accessto the phonebook-table  
  Create one or two mysql-users that has appropriate access to the  
  phonebook-table and the record-table.
___

- create php-script to get data from mysql. Using GET variables. Delivers as
  textoutput, read by the app. On php-side sql is used to get the data.  
  a simple echo or print is used to send the data back to the calling  
  browser-process, the browser-process take the data into mempory and use  
  it to create and fill the local sqlite-db.  
  ####  - *getting the phonebook-table*
___
- create php-script to det data to mysql. Using GET variables. On php-side  
  sql is used to get the data.  
  returnvalues "ok" or "nok" are sent as text output to the browser-process
- set single datasets if app is in editor-mode (name,company, numbertype and number)
- __canceled (see above) :__ set datasets if app is in record-mode (callernumber, timestamp, extension)
  

# [it's alive](https://youtu.be/xos2MnVxe-c?t=4)

app exists, php-scripts exists

# Testing phase

# #WE ARE HERE#
# Step 6
# Step 10
# Step 88 

make an installation guide

- install&config the local applikation
- config myPBX to use the local application

# Step 99 

think about if and how to publish it

----
[wiki-reference](http://wiki.innovaphone.com/index.php?title=Reference11r1:Concept_myPBX#Starting_an_external_application_for_a_call)

