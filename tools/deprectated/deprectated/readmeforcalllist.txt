
Create Callist table

mysql -u root
  source /var/www/tools/calllist.sql
  exit

=========
not really needed

http://<ip of lap>:8080/tools

edit the index.html

call editor.php?username=addressmaster&select=address will show the editor
for the address table

call editor via url http://<LAPIP>:8080/editor.php?username=addressmaster&select=address&where%5B0%5D%5Bcol%5D=company&where%5B0%5D%5Bop%5D=&where%5B0%5D%5Bval%5D=&where%5B01%5D%5Bcol%5D=&where%5B01%5D%5Bop%5D=&where%5B01%5D%5Bval%5D=&order%5B1%5D=company&limit=50
calls the editor and shows all datasets with empty company

---
input.php?no=++49123456798&nt=phonr will insert a new dataset with number in phone and no company
will go to editor with the selection of all datasets with no company set

ask.php?no=+49123456798  will aks if there is a dataset with the number (no) in phone,mobile or home
if there is no result it calls input.pho with parameters to insert it as ne dataset
if is a result nothing is done.