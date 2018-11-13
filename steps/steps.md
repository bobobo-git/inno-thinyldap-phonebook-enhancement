# Step 1

## creating the app to get data from myPBX with an incoming call
Starting an external application for a call.  
Should be OS independant.

Starting with Windows, calling cmd /K with parameters

# Step 2

Testing access to the phonebook table via Http(s) with __no Success__

# Step 3

Further testing access to the phonebook table via Http(s) with __no Success__

# Step 4 1

Decision to use an mysql-odbc-connector to access the phonebook-table

# Step 4 2

It ended with using mysql-odbc-connector and a selfmade  
programm started as external app from myPBX that checks  
incoming calls and shows an inputdialog for input names
and selecting  Numbertype (phone,mobile or home)

i have a running version here.

# [it's alive](https://youtu.be/xos2MnVxe-c?t=4)

# Step 5 1  

Testing phase  

# Step 6

scratching head

# Step 6 new deviation
I thought about the odbc-connector and came to the enlightment that this is  
not the way to go on further.  
to avoid installations more than the lokal app itself it could be wise to get
and put data from and to the mysql-tables NOT via odbc-connectors but access  
through the webserver itself.

While innovaphone's lighttpd will ask for user and password (htdisgest) when  
accessed via port 80 or 443 i will enhance the lighthttpd.conf to get access  
throught another port (8080 f.i.) without asking user and password.  
The local app will get and set data through this port data to the mysql-table.

# Step 7

create tools and jobs (php on webside and my programlanguage on local side)
to get and set data into the mysql-table.

I think i will make it as browserbased as possible.

the local app should get the possibility to switch on/off the datainput with  
unknown incomming numbers.
And has a a switch to browse to a webside where the mysql-table-data can be managed
change names, numbers, insert whole sets, delete whole sets, and so on.

# Step 8

some tools created
(input.php)
inserting a new dataset with a number at phone,mobile or home via urlparameter

(ask.php)
check if a number already exists (and call input.php with parameters if not, this
is not ok as it is not clear what numbertype it is)

the app should ask if it's a phone, mobile or home number
and call the input.php afterwards.
mobile could be analyzed +4915 +4916 +4917  for Germany

so the app calls ask.php  and get back how often ths number is already in the address-table  (receivehttpdata)

if 0 the app calls input.php with parameter and asks beforehand the numbertype from the user.

# Step 9 

tools on websewrver created  
local app can handle data via those tools  
the local app fetches the address table and put it in a local sqlite database    
which is used for seaching name, company, firstname phonetype and addressID  

has got F1 for Help and F3 to switch to the editor (webbased)  

# Step 10

testing phase   __<- WE ARE HERE__


# 
 
# Step 88 

make an installation guide

- install&config the local applikation
- config myPBX to use the local application

# Step 99 

think about if and how to publish it

----
[wiki-reference](http://wiki.innovaphone.com/index.php?title=Reference11r1:Concept_myPBX#Starting_an_external_application_for_a_call)

